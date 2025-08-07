<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\customer;
use App\Models\services;
use App\Mail\BookingConfirmation;
use App\Mail\AdminBookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'preferred_date' => 'required|date|after:today',
            'preferred_time' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'message' => 'nullable|string',
            'special_instructions' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            sweetalert()->success('Validation error: '.  $validator->errors());
        }

        try {
            DB::beginTransaction();

            // Find or create customer
            $customer = customer::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'status' => customer::STATUS_ACTIVE,
                    'customer_reference' => customer::generateCustomerReference(),
                ]
            );

            // Get service details
            $service = services::findOrFail($request->service_id);

            // Create booking
            $booking = booking::create([
                'customer_id' => $customer->id,
                'service_id' => $service->id,
                'service_name' => $service->name,
                'preferred_date' => $request->preferred_date,
                'preferred_time' => $request->preferred_time,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'message' => $request->message,
                'special_instructions' => $request->special_instructions,
                'status' => booking::STATUS_PENDING,
                'total_amount' => $service->price,
                'payment_status' => booking::PAYMENT_PENDING,
                'booking_reference' => booking::generateBookingReference(),
            ]);

            // Update customer stats
            $customer->update([
                'total_bookings' => $customer->bookings()->count(),
                'total_spent' => $customer->bookings()->sum('total_amount'),
                'last_booking_date' => now(),
            ]);

            DB::commit();

            // Send email notifications
            try {
                // Send confirmation email to customer
                Mail::to($request->email)->send(new BookingConfirmation($booking));

                // Send notification email to admin
                Mail::to(config('mail.admin_email', 'admin@delvora.com'))->send(new AdminBookingNotification($booking));
            } catch (\Exception $e) {
                // Log email error but don't fail the booking
                Log::error('Email sending failed: ' . $e->getMessage());
            }


            sweetalert()->success('Your submission has been received successfully.');
            return redirect()->route('front.confirmation', ['reference' => $booking->booking_reference]);


        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking creation failed: ' . $e->getMessage());

            sweetalert()->error('An error occurred while creating your booking. Please try again.');
            return redirect()->back();
        }
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
            ->with(['customer', 'service'])
            ->firstOrFail();

        return view('front.track', compact('booking'));
    }

    public function cancel($reference)
    {
        $booking = booking::where('booking_reference', $reference)->firstOrFail();
        
        if ($booking->status === booking::STATUS_PENDING) {
            $booking->update(['status' => booking::STATUS_CANCELLED]);

            sweetalert()->success('Booking cancelled  successfully.');
            return redirect()->back();
        }

        sweetalert()->success('Booking cannot be cancelled at this stage!.');
        return redirect()->back();
    }
}
