<?php

namespace App\Http\Controllers;

use App\Models\gallery;
use App\Models\customer;
use App\Models\booking;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->query('status');
        $galleries = gallery::with(['customer', 'booking', 'staff'])
        ->when($statusFilter, function ($query, $status) {
            return $query->where('status', $status);
        })
            ->latest()
            ->paginate(12);

        $customers = customer::all();
        $bookings = booking::where('status', booking::STATUS_COMPLETED)->get();
        $staff = Staff::where('status', Staff::STATUS_ACTIVE)->get();

        return view('admin.gallery', compact('galleries', 'customers', 'bookings', 'staff'));
    }

    public function store(Request $request)
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
            'status' => 'required|in:draft,published,archived',
        ]);

        $data = $request->all();

        $data['featured'] = $request->has('featured');

        // Handle before_image upload
        if ($request->hasFile('before_image')) {
            $beforeImageName = 'before_' . time() . '_' . uniqid() . '.' . $request->before_image->extension();
            $beforeImgPath = $request->before_image->storeAs('gallery', $beforeImageName);
            $data['before_image'] = $beforeImgPath;
        }

        // Handle after_image upload
        if ($request->hasFile('after_image')) {
            $afterImageName = 'after_' . time() . '_' . uniqid() . '.' . $request->after_image->extension();
            $afterImgPath = $request->after_image->storeAs('gallery', $afterImageName);
            $data['after_image'] = $afterImgPath;
        }


        gallery::create($data);

        sweetalert()->success('Gallery item added successfully!');
        return redirect()->back();
    }

    public function show($id)
    {
        $gallery = gallery::with(['customer', 'booking', 'staff'])
            ->findOrFail($id);

        return view('admin.gallery-details', compact('gallery'));
    }

    public function update(Request $request, $id)
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
            'status' => 'required|in:draft,published,archived',
        ]);

        $data = $request->all();

        $data['featured'] = $request->has('featured');

        if ($request->hasFile('before_image')) {
            if ($gallery->before_image && file_exists(public_path($gallery->before_image))) {
                unlink(public_path($gallery->before_image));
            }
            // $data['before_image'] = $request->file('before_image')->store('gallery', 'public');

            $beforeImageName = 'before_' . time() . '_' . uniqid() . '.' . $request->before_image->extension();
            $beforeImgPath = $request->before_image->storeAs('gallery', $beforeImageName);
            $data['before_image'] = $beforeImgPath;
        }

        if ($request->hasFile('after_image')) {
            if ($gallery->after_image && file_exists(public_path($gallery->after_image))) {
                unlink(public_path($gallery->after_image));
            }
            // $data['after_image'] = $request->file('after_image')->store('gallery', 'public');

            $afterImageName = 'after_' . time() . '_' . uniqid() . '.' . $request->after_image->extension();
            $afterImgPath = $request->after_image->storeAs('gallery', $afterImageName);
            $data['after_image'] = $afterImgPath;
        }

        $gallery->update($data);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Gallery item updated successfully!'
        // ]);
        sweetalert()->success('Gallery item updated successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $gallery = gallery::findOrFail($id);

        // Delete images
        if ($gallery->before_image && file_exists(public_path($gallery->before_image))) {
            unlink(public_path($gallery->before_image));
        }
    
        // Delete after_image if it exists
        if ($gallery->after_image && file_exists(public_path($gallery->after_image))) {
            unlink(public_path($gallery->after_image));
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery item deleted successfully!'
        ]);
    }

    public function toggleFeatured($id)
    {
        $gallery = gallery::findOrFail($id);
        $gallery->update(['featured' => !$gallery->featured]);

        return response()->json([
            'success' => true,
            'message' => 'Gallery item featured status updated!',
            'featured' => $gallery->featured
        ]);
    }

    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'galleries' => 'required|array',
            'galleries.*.id' => 'required|exists:galleries,id',
            'galleries.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->galleries as $galleryData) {
            gallery::where('id', $galleryData['id'])
                ->update(['sort_order' => $galleryData['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Gallery order updated successfully!'
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,publish,archive,feature,unfeature',
            'gallery_ids' => 'required|array',
            'gallery_ids.*' => 'exists:galleries,id',
        ]);

        $galleries = gallery::whereIn('id', $request->gallery_ids);

        switch ($request->action) {
            case 'delete':
                // Delete images first
                $galleriesToDelete = $galleries->get();
                foreach ($galleriesToDelete as $gallery) {
                    if ($gallery->before_image) {
                        // Storage::disk('public')->delete($gallery->before_image);
                        unlink(public_path('asset/image/' . $gallery->before_image)); 
                    }
                    if ($gallery->after_image) {
                        // Storage::disk('public')->delete($gallery->after_image);
                        unlink(public_path('asset/image/' . $gallery->after_image)); 
                    }
                }
                $galleries->delete();
                $message = 'Selected gallery items deleted successfully!';
                break;

            case 'publish':
                $galleries->update(['status' => gallery::STATUS_PUBLISHED]);
                $message = 'Selected gallery items published successfully!';
                break;

            case 'archive':
                $galleries->update(['status' => gallery::STATUS_ARCHIVED]);
                $message = 'Selected gallery items archived successfully!';
                break;

            case 'feature':
                $galleries->update(['featured' => true]);
                $message = 'Selected gallery items featured successfully!';
                break;

            case 'unfeature':
                $galleries->update(['featured' => false]);
                $message = 'Selected gallery items unfeatured successfully!';
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
