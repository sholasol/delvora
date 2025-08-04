<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
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
            background-color: #007bff;
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
            border-left: 4px solid #007bff;
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
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Booking Confirmation</h1>
        <p>Thank you for choosing Delvora Cleaning Services!</p>
    </div>

    <div class="content">
        <p>Dear {{ $booking->name }},</p>

        <p>Your booking has been successfully confirmed. Here are the details:</p>

        <div class="booking-details">
            <h3>Booking Information</h3>
            <p><strong>Booking Reference:</strong> {{ $booking->booking_reference }}</p>
            <p><strong>Service:</strong> {{ $booking->service_name }}</p>
            <p><strong>Date:</strong> {{ $booking->preferred_date->format('l, F j, Y') }}</p>
            <p><strong>Time:</strong> {{ $booking->preferred_time }}</p>
            <p><strong>Address:</strong> {{ $booking->address }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($booking->total_amount, 2) }}</p>
        </div>

        @if($booking->message)
        <div class="booking-details">
            <h3>Special Instructions</h3>
            <p>{{ $booking->message }}</p>
        </div>
        @endif

        <p>Our team will arrive at your location on the scheduled date and time. Please ensure someone is available to provide access to the premises.</p>

        <p>If you need to make any changes to your booking or have any questions, please contact us immediately.</p>

        <div style="text-align: center;">
            <a href="{{ route('front.track', $booking->booking_reference) }}" class="btn">Track Your Booking</a>
        </div>

        <p><strong>Contact Information:</strong></p>
        <ul>
            <li>Phone: (555) 123-4567</li>
            <li>Email: info@delvora.com</li>
            <li>Website: www.delvora.com</li>
        </ul>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Delvora Cleaning Services. All rights reserved.</p>
        <p>This is an automated email. Please do not reply to this message.</p>
    </div>
</body>
</html> 