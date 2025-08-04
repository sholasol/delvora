<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }
        .booking-details {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        .customer-details {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #ffc107;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
        .urgent {
            background-color: #dc3545;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Booking Received</h1>
        <p>A new booking has been submitted and requires your attention</p>
    </div>

    <div class="content">
        <div class="urgent">
            <strong>⚠️ New Booking Alert</strong><br>
            A new booking has been submitted and is pending confirmation.
        </div>

        <div class="booking-details">
            <h3>Booking Information</h3>
            <p><strong>Booking Reference:</strong> {{ $booking->booking_reference }}</p>
            <p><strong>Service:</strong> {{ $booking->service_name }}</p>
            <p><strong>Date:</strong> {{ $booking->preferred_date->format('l, F j, Y') }}</p>
            <p><strong>Time:</strong> {{ $booking->preferred_time }}</p>
            <p><strong>Address:</strong> {{ $booking->address }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($booking->total_amount, 2) }}</p>
            <p><strong>Status:</strong> <span style="color: #ffc107; font-weight: bold;">{{ ucfirst($booking->status) }}</span></p>
        </div>

        <div class="customer-details">
            <h3>Customer Information</h3>
            <p><strong>Name:</strong> {{ $booking->name }}</p>
            <p><strong>Email:</strong> {{ $booking->email }}</p>
            <p><strong>Phone:</strong> {{ $booking->phone }}</p>
            @if($booking->message)
            <p><strong>Message:</strong> {{ $booking->message }}</p>
            @endif
            @if($booking->special_instructions)
            <p><strong>Special Instructions:</strong> {{ $booking->special_instructions }}</p>
            @endif
        </div>

        <p><strong>Action Required:</strong></p>
        <ul>
            <li>Review the booking details</li>
            <li>Confirm availability for the requested date/time</li>
            <li>Assign staff member if needed</li>
            <li>Update booking status</li>
        </ul>

        <div style="text-align: center;">
            <a href="{{ route('bookings') }}" class="btn">View All Bookings</a>
        </div>

        <p><strong>Quick Actions:</strong></p>
        <ul>
            <li>Confirm Booking</li>
            <li>Assign Staff</li>
            <li>Send Quote</li>
            <li>Contact Customer</li>
        </ul>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Delvora Cleaning Services. All rights reserved.</p>
        <p>This is an automated notification from the booking system.</p>
    </div>
</body>
</html> 