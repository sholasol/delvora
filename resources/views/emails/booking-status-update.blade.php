<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Status Update</title>
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
            background-color: #17a2b8;
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
        .status-update {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #17a2b8;
        }
        .booking-details {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #28a745;
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
            background-color: #17a2b8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-confirmed { background-color: #17a2b8; color: white; }
        .status-in-progress { background-color: #007bff; color: white; }
        .status-completed { background-color: #28a745; color: white; }
        .status-cancelled { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Booking Status Update</h1>
        <p>Your booking status has been updated</p>
    </div>

    <div class="content">
        <p>Dear {{ $booking->name }},</p>

        <p>Your booking status has been updated. Here are the details:</p>

        <div class="status-update">
            <h3>Status Update</h3>
            <p><strong>Previous Status:</strong> <span class="status-badge status-{{ $oldStatus }}">{{ ucfirst(str_replace('_', ' ', $oldStatus)) }}</span></p>
            <p><strong>New Status:</strong> <span class="status-badge status-{{ $booking->status }}">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span></p>
        </div>

        <div class="booking-details">
            <h3>Booking Information</h3>
            <p><strong>Booking Reference:</strong> {{ $booking->booking_reference }}</p>
            <p><strong>Service:</strong> {{ $booking->service_name }}</p>
            <p><strong>Date:</strong> {{ $booking->preferred_date->format('l, F j, Y') }}</p>
            <p><strong>Time:</strong> {{ $booking->preferred_time }}</p>
            <p><strong>Address:</strong> {{ $booking->address }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($booking->total_amount, 2) }}</p>
        </div>

        @if($booking->status === 'confirmed')
        <div class="status-update">
            <h3>✅ Booking Confirmed!</h3>
            <p>Great news! Your booking has been confirmed. Our team will arrive at your location on the scheduled date and time.</p>
            <p><strong>Please ensure:</strong></p>
            <ul>
                <li>Someone is available to provide access to the premises</li>
                <li>The area to be cleaned is accessible</li>
                <li>Any special instructions are clearly communicated</li>
            </ul>
        </div>
        @endif

        @if($booking->status === 'in_progress')
        <div class="status-update">
            <h3>🔄 Service In Progress</h3>
            <p>Our team has started working on your cleaning service. We'll keep you updated on the progress.</p>
        </div>
        @endif

        @if($booking->status === 'completed')
        <div class="status-update">
            <h3>✅ Service Completed!</h3>
            <p>Your cleaning service has been completed successfully. We hope you're satisfied with our work!</p>
            <p>Please take a moment to review our service and provide feedback.</p>
        </div>
        @endif

        @if($booking->status === 'cancelled')
        <div class="status-update">
            <h3>❌ Booking Cancelled</h3>
            <p>Your booking has been cancelled. If you have any questions or would like to reschedule, please contact us.</p>
        </div>
        @endif

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