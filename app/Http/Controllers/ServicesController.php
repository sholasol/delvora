<?php

namespace App\Http\Controllers;

use App\Models\services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->query('status');
        $services = services::withCount('bookings')
            ->when($statusFilter, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        return view('admin.services', compact('services'));
    }

    public function store(Request $request)
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
            'sort_order' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // dd($data);

        $data['featured'] = $request->has('featured');

        if ($request->hasFile('image')) {
            // $data['image'] = $request->file('image')->store('services', 'public');

            $imageName = time() . '.' . $request->image->extension();
            $imgPath = $request->image->storeAs('services', $imageName);
            $data['image'] = $imgPath;
        }

       
        services::create($data);

        sweetalert()->success('Service added successfully!');
        return redirect()->back();
    }

    public function show($id)
    {
        $service = services::with(['bookings.customer', 'galleries'])
            ->findOrFail($id);

        $stats = [
            'total_bookings' => $service->bookings()->count(),
            'completed_bookings' => $service->bookings()->where('status', 'completed')->count(),
            'total_revenue' => $service->bookings()->where('status', 'completed')->sum('total_amount'),
            'gallery_items' => $service->galleries()->count(),
        ];

        return view('admin.service-details', compact('service', 'stats'));
    }

    public function update(Request $request, $id)
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        $data['featured'] = $request->has('featured');

        if ($request->hasFile('image')) {
            // Delete old image
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

        sweetalert()->success('Service updated successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $service = services::findOrFail($id);

        // Check if service has any bookings
        if ($service->bookings()->count() > 0) {
            sweetalert()->success('Cannot delete service with existing booking!');
        return redirect()->back();
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Cannot delete service with existing bookings.'
            // ], 400);
        }

        // Delete image if exists
        if ($service->image) {
            // Storage::disk('public')->delete($service->image);
            unlink(public_path('asset/image/' . $service->image)); 
        }

        $service->delete();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Service deleted successfully!'
        // ]);
        sweetalert()->success('Service deleted successfully!');
        return redirect()->back();
    }

    public function toggleFeatured($id)
    {
        $service = services::findOrFail($id);
        $service->update(['featured' => !$service->featured]);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Service featured status updated!',
        //     'featured' => $service->featured
        // ]);

        sweetalert()->success('Service featured status updated!');
        return redirect()->back();
    }

    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'services' => 'required|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->services as $serviceData) {
            services::where('id', $serviceData['id'])
                ->update(['sort_order' => $serviceData['sort_order']]);
        }

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Services order updated successfully!'
        // ]);

        sweetalert()->success('Service order updated successfully!');
        return redirect()->back();
    }
}
