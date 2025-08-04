<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\customer;
use App\Models\Staff;
use App\Models\gallery;
use App\Models\services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingStatusUpdate;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_bookings' => booking::count(),
            'pending_bookings' => booking::where('status', booking::STATUS_PENDING)->count(),
            'total_customers' => customer::count(),
            'total_revenue' => booking::where('status', booking::STATUS_COMPLETED)->sum('total_amount'),
            'active_staff' => Staff::where('status', Staff::STATUS_ACTIVE)->count(),
            'total_services' => services::where('status', services::STATUS_ACTIVE)->count(),
        ];

        $recent_bookings = booking::with(['customer', 'service'])
            ->latest()
            ->take(5)
            ->get();

        $recent_customers = customer::latest()->take(5)->get();

        return view('admin.index', compact('stats', 'recent_bookings', 'recent_customers'));
    }

    public function bookings()
    {
        $bookings = booking::with(['customer', 'service', 'assignedStaff'])
            ->latest()
            ->paginate(15);

        $staff = Staff::where('status', Staff::STATUS_ACTIVE)->get();

        return view('admin.bookings', compact('bookings', 'staff'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $booking = booking::findOrFail($id);
        $oldStatus = $booking->status;
        
        $booking->update([
            'status' => $request->status,
            'assigned_staff_id' => $request->assigned_staff_id,
        ]);

        if ($request->status === booking::STATUS_CONFIRMED && !$booking->confirmed_at) {
            $booking->update(['confirmed_at' => now()]);
        }

        if ($request->status === booking::STATUS_COMPLETED && !$booking->completed_at) {
            $booking->update(['completed_at' => now()]);
        }

        // Send email notification for status change
        try {
            Mail::to($booking->email)->send(new BookingStatusUpdate($booking, $oldStatus));
        } catch (\Exception $e) {
            Log::error('Status update email failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking status updated successfully!'
        ]);
    }

    public function customers()
    {
        $customers = customer::withCount('bookings')
            ->withSum('bookings', 'total_amount')
            ->latest()
            ->paginate(15);

        return view('admin.customers', compact('customers'));
    }

    public function customerDetails($id)
    {
        $customer = customer::with(['bookings.service', 'bookings.assignedStaff'])
            ->findOrFail($id);

        return view('admin.customer-details', compact('customer'));
    }

    public function staff()
    {
        $staff = Staff::withCount('bookings')
            ->withCount(['bookings as completed_bookings' => function($query) {
                $query->where('status', booking::STATUS_COMPLETED);
            }])
            ->latest()
            ->paginate(15);

        return view('admin.staff', compact('staff'));
    }

    public function storeStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'hire_date' => 'required|date',
            'hourly_rate' => 'required|numeric|min:0',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'skills' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['employee_id'] = Staff::generateEmployeeId();
        $data['status'] = Staff::STATUS_ACTIVE;

        if ($request->hasFile('avatar')) {

            // $data['avatar'] = $request->file('avatar')->store('staff', 'public');

            $imageName = time() . '.' . $request->avatar->extension();
            $imgPath = $request->avatar->storeAs('staff', $imageName);
            $data['avatar'] = $imgPath;
        }

        Staff::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Staff member added successfully!'
        ]);
    }

    public function updateStaff(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $id,
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'hire_date' => 'required|date',
            'hourly_rate' => 'required|numeric|min:0',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'skills' => 'nullable|string',
            'status' => 'required|in:active,inactive,on_leave,terminated',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($staff->avatar) {
                unlink(public_path('asset/image/' . $staff->avatar)); 
                // Storage::disk('public')->delete($staff->avatar);
            }
            // $data['avatar'] = $request->file('avatar')->store('staff', 'public');

            $imageName = time() . '.' . $request->avatar->extension();
            $imgPath = $request->avatar->storeAs('staff', $imageName);
            $data['avatar'] = $imgPath;
        }

        $staff->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Staff member updated successfully!'
        ]);
    }

    public function gallery()
    {
        $galleries = gallery::with(['customer', 'booking', 'staff'])
            ->latest()
            ->paginate(12);

        $customers = customer::all();
        $bookings = booking::where('status', booking::STATUS_COMPLETED)->get();
        $staff = Staff::where('status', Staff::STATUS_ACTIVE)->get();

        return view('admin.gallery', compact('galleries', 'customers', 'bookings', 'staff'));
    }

    public function storeGallery(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'customer_id' => 'required|exists:customers,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'staff_id' => 'nullable|exists:staff,id',
            'service_type' => 'required|string|max:255',
            'before_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'after_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'featured' => 'boolean',
            'status' => 'required|in:draft,published,archived',
        ]);

        $data = $request->all();

        if ($request->hasFile('before_image')) {
            // $data['before_image'] = $request->file('before_image')->store('gallery', 'public');
            $imageName = time() . '.' . $request->before_image->extension();
            $imgPath = $request->before_image->storeAs('gallery', $imageName);
            $data['before_image'] = $imgPath;
        }

        if ($request->hasFile('after_image')) {
            // $data['after_image'] = $request->file('after_image')->store('gallery', 'public');

            $imageName = time() . '.' . $request->after_image->extension();
            $imgPath = $request->after_image->storeAs('gallery', $imageName);
            $data['after_image'] = $imgPath;
        }

        gallery::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Gallery item added successfully!'
        ]);
    }

    public function updateGallery(Request $request, $id)
    {
        $gallery = gallery::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'customer_id' => 'required|exists:customers,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'staff_id' => 'nullable|exists:staff,id',
            'service_type' => 'required|string|max:255',
            'before_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'after_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'featured' => 'boolean',
            'status' => 'required|in:draft,published,archived',
        ]);

        $data = $request->all();

        if ($request->hasFile('before_image')) {
            if ($gallery->before_image) {
                // Storage::disk('public')->delete($gallery->before_image);
                unlink(public_path('asset/image/' . $gallery->before_image)); 
            }
            // $data['before_image'] = $request->file('before_image')->store('gallery', 'public');

            $imageName = time() . '.' . $request->before_image->extension();
            $imgPath = $request->before_image->storeAs('gallery', $imageName);
            $data['before_image'] = $imgPath;
        }

        if ($request->hasFile('after_image')) {
            if ($gallery->after_image) {
                // Storage::disk('public')->delete($gallery->after_image);
                unlink(public_path('asset/image/' . $gallery->after_image)); 
            }
            // $data['after_image'] = $request->file('after_image')->store('gallery', 'public');

            $imageName = time() . '.' . $request->after_image->extension();
            $imgPath = $request->after_image->storeAs('gallery', $imageName);
            $data['after_image'] = $imgPath;
        }

        $gallery->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Gallery item updated successfully!'
        ]);
    }

    public function services()
    {
        $services = services::latest()->paginate(15);
        return view('admin.services', compact('services'));
    }

    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'include' => 'nullable|string',
            'exclude' => 'nullable|string',
            'status' => 'required|in:active,inactive,draft',
            'featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');

            $imageName = time() . '.' . $request->image->extension();
            $imgPath = $request->image->storeAs('services', $imageName);
            $data['image'] = $imgPath;
        }

        services::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Service added successfully!'
        ]);
    }

    public function updateService(Request $request, $id)
    {
        $service = services::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'include' => 'nullable|string',
            'exclude' => 'nullable|string',
            'status' => 'required|in:active,inactive,draft',
            'featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($service->image) {
                // Storage::disk('public')->delete($service->image);
                unlink(public_path('asset/image/' . $service->image)); 
            }
            // $data['image'] = $request->file('image')->store('services', 'public');
            $imageName = time() . '.' . $request->image->extension();
            $imgPath = $request->image->storeAs('services', $imageName);
            $data['image'] = $imgPath;
        }

        $service->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Service updated successfully!'
        ]);
    }

    public function settings()
    {
        $stats = [
            'total_bookings' => booking::count(),
            'total_customers' => customer::count(),
            'total_staff' => Staff::count(),
            'total_services' => services::count(),
            'total_gallery_items' => gallery::count(),
            'monthly_revenue' => booking::where('status', booking::STATUS_COMPLETED)
                ->whereMonth('created_at', now()->month)
                ->sum('total_amount'),
            'pending_bookings' => booking::where('status', booking::STATUS_PENDING)->count(),
            'active_staff' => Staff::where('status', Staff::STATUS_ACTIVE)->count(),
        ];

        return view('admin.settings', compact('stats'));
    }

    public function exportBookings()
    {
        $bookings = booking::with(['customer', 'service', 'assignedStaff'])
            ->latest()
            ->get();

        $filename = 'bookings_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['ID', 'Reference', 'Customer', 'Service', 'Date', 'Time', 'Status', 'Amount', 'Staff', 'Created Date']);
            
            // Add data
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->booking_reference,
                    $booking->customer->name ?? 'N/A',
                    $booking->service_name,
                    $booking->preferred_date,
                    $booking->preferred_time,
                    $booking->status,
                    $booking->total_amount,
                    $booking->assignedStaff->name ?? 'Unassigned',
                    $booking->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function dashboardStats()
    {
        $stats = [
            'total_bookings' => booking::count(),
            'pending_bookings' => booking::where('status', booking::STATUS_PENDING)->count(),
            'total_customers' => customer::count(),
            'total_revenue' => booking::where('status', booking::STATUS_COMPLETED)->sum('total_amount'),
            'active_staff' => Staff::where('status', Staff::STATUS_ACTIVE)->count(),
            'total_services' => services::where('status', services::STATUS_ACTIVE)->count(),
            'monthly_revenue' => booking::where('status', booking::STATUS_COMPLETED)
                ->whereMonth('created_at', now()->month)
                ->sum('total_amount'),
            'weekly_bookings' => booking::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        return response()->json($stats);
    }
}
