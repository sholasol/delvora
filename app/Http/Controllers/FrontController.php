<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use App\Models\services;
use App\Models\gallery;
use App\Models\booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
    public function index()
    {
        $featuredServices = services::where('status', services::STATUS_ACTIVE)
            ->where('featured', true)
            ->take(3)
            ->get();

        $featuredGallery = gallery::where('status', gallery::STATUS_PUBLISHED)
            ->where('featured', true)
            ->take(6)
            ->get();

        $stats = [
            'total_customers' => \App\Models\customer::count(),
            'completed_bookings' => booking::where('status', booking::STATUS_COMPLETED)->count(),
            'total_revenue' => booking::where('status', booking::STATUS_COMPLETED)->sum('total_amount'),
        ];

        return view('front.index', compact('featuredServices', 'featuredGallery', 'stats'));
    }

    public function about()
    {
        return view('front.about');
    }

    public function services()
    {
        $services = services::where('status', services::STATUS_ACTIVE)
            ->orderBy('sort_order')
            ->get();

        $categories = services::where('status', services::STATUS_ACTIVE)
            ->distinct()
            ->pluck('category')
            ->filter();

        return view('front.services', compact('services', 'categories'));
    }

    public function gallery()
    {
        $galleries = gallery::where('status', gallery::STATUS_PUBLISHED)
            ->with(['customer', 'booking'])
            ->orderBy('sort_order')
            ->paginate(12);

        $categories = gallery::where('status', gallery::STATUS_PUBLISHED)
            ->distinct()
            ->pluck('service_type')
            ->filter();

        return view('front.gallery', compact('galleries', 'categories'));
    }   

    public function contact()
    {
        return view('front.contact');
    }

    public function book()
    {
        $services = services::where('status', services::STATUS_ACTIVE)
            ->orderBy('name')
            ->get();

        return view('front.book', compact('services'));
    }

    public function confirmation($reference)
    {
        $booking = booking::where('booking_reference', $reference)
            ->with(['customer', 'service'])
            ->firstOrFail();

        return view('front.confirmation', compact('booking'));
    }

    public function track($reference)
    {
        $booking = booking::where('booking_reference', $reference)
            ->with(['customer', 'service', 'assignedStaff'])
            ->firstOrFail();

        return view('front.track', compact('booking'));
    }

    public function serviceDetails($id)
    {
        $service = services::where('status', services::STATUS_ACTIVE)
            ->findOrFail($id);

        $relatedServices = services::where('status', services::STATUS_ACTIVE)
            ->where('category', $service->category)
            ->where('id', '!=', $service->id)
            ->take(3)
            ->get();

        $serviceGallery = gallery::where('status', gallery::STATUS_PUBLISHED)
            ->where('service_type', $service->name)
            ->take(6)
            ->get();

        return view('front.service-details', compact('service', 'relatedServices', 'serviceGallery'));
    }

    public function searchServices(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('category');

        $services = services::where('status', services::STATUS_ACTIVE);

        if ($query) {
            $services->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        if ($category) {
            $services->where('category', $category);
        }

        $services = $services->orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'services' => $services
        ]);
    }

    public function contactSubmit(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            // 'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

          // Add the current page URL to the data
    $data = $request->all();
    $data['page_url'] = url()->previous();

    try {
        // Send email to admin
        Mail::to('admin@admin.com')
            ->send(new ContactEmail($data));

        sweetalert()->success('Thank you for your message! We will get back to you soon.');
        return redirect()->back();
    } catch (\Exception $e) {
        // Log the error
        \Log::error('Contact form submission failed: ' . $e->getMessage());

        sweetalert()->error('Something went wrong. Please try again later.');
        return redirect()->back()->withInput();
    }
    }
}
