<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = customer::withCount('bookings')
            ->withSum('bookings', 'total_amount')
            ->latest()
            ->paginate(15);

        return view('admin.customers', compact('customers'));
    }

    public function show($id)
    {
        $customer = customer::with(['bookings.service', 'bookings.assignedStaff'])
            ->findOrFail($id);

        $stats = [
            'total_bookings' => $customer->bookings()->count(),
            'completed_bookings' => $customer->bookings()->where('status', booking::STATUS_COMPLETED)->count(),
            'total_spent' => $customer->bookings()->where('status', booking::STATUS_COMPLETED)->sum('total_amount'),
            'pending_bookings' => $customer->bookings()->where('status', booking::STATUS_PENDING)->count(),
        ];

        return view('admin.customer-details', compact('customer', 'stats'));
    }

    public function update(Request $request, $id)
    {
        $customer = customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive,blocked',
        ]);

        $customer->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $customer = customer::findOrFail($id);

        // Check if customer has any bookings
        if ($customer->bookings()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete customer with existing bookings.'
            ], 400);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully!'
        ]);
    }

    public function export()
    {
        $customers = customer::withCount('bookings')
            ->withSum('bookings', 'total_amount')
            ->get();

        $filename = 'customers_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($customers) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Address', 'Status', 'Total Bookings', 'Total Spent', 'Created Date']);
            
            // Add data
            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer->id,
                    $customer->name,
                    $customer->email,
                    $customer->phone,
                    $customer->address,
                    $customer->status,
                    $customer->bookings_count,
                    $customer->bookings_sum_total_amount ?? 0,
                    $customer->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
