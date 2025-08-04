<x-front-layout>
    <!-- Header Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-4 fw-bold mb-3">Track Your Booking</h1>
                    <p class="lead mb-0">Stay updated on the status of your cleaning service</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Status Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0">Booking Status</h3>
                                <span class="badge bg-primary fs-6">{{ $booking->booking_reference }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Status Timeline -->
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-md-3 text-center mb-3">
                                        <div class="position-relative">
                                            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <h6 class="mb-1">Booked</h6>
                                            <small class="text-muted">{{ $booking->created_at->format('M j, Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center mb-3">
                                        <div class="position-relative">
                                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2 {{ $booking->status != 'pending' ? 'bg-success text-white' : 'bg-secondary text-white' }}" style="width: 50px; height: 50px;">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                            <h6 class="mb-1">Confirmed</h6>
                                            <small class="text-muted">
                                                @if($booking->confirmed_at)
                                                    {{ $booking->confirmed_at->format('M j, Y') }}
                                                @else
                                                    Pending
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center mb-3">
                                        <div class="position-relative">
                                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2 {{ in_array($booking->status, ['in_progress', 'completed']) ? 'bg-success text-white' : 'bg-secondary text-white' }}" style="width: 50px; height: 50px;">
                                                <i class="fas fa-broom"></i>
                                            </div>
                                            <h6 class="mb-1">In Progress</h6>
                                            <small class="text-muted">
                                                @if($booking->status == 'in_progress')
                                                    Started
                                                @elseif($booking->status == 'completed')
                                                    Completed
                                                @else
                                                    Pending
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center mb-3">
                                        <div class="position-relative">
                                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2 {{ $booking->status == 'completed' ? 'bg-success text-white' : 'bg-secondary text-white' }}" style="width: 50px; height: 50px;">
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <h6 class="mb-1">Completed</h6>
                                            <small class="text-muted">
                                                @if($booking->completed_at)
                                                    {{ $booking->completed_at->format('M j, Y') }}
                                                @else
                                                    Pending
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Current Status -->
                            <div class="alert alert-info">
                                <h5 class="alert-heading">Current Status: {{ ucfirst(str_replace('_', ' ', $booking->status)) }}</h5>
                                @if($booking->status == 'pending')
                                    <p class="mb-0">Your booking is pending confirmation. Our team will contact you within 24 hours to confirm your appointment.</p>
                                @elseif($booking->status == 'confirmed')
                                    <p class="mb-0">Your booking has been confirmed! Our team will arrive at your location on the scheduled date and time.</p>
                                @elseif($booking->status == 'in_progress')
                                    <p class="mb-0">Our cleaning team is currently working at your location. They will complete the service as scheduled.</p>
                                @elseif($booking->status == 'completed')
                                    <p class="mb-0">Your cleaning service has been completed successfully! We hope you're satisfied with our work.</p>
                                @elseif($booking->status == 'cancelled')
                                    <p class="mb-0">This booking has been cancelled. If you need to reschedule, please contact us.</p>
                                @endif
                            </div>

                            <!-- Booking Details -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Service Details</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Service:</strong></td>
                                            <td>{{ $booking->service_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date:</strong></td>
                                            <td>{{ $booking->preferred_date ? $booking->preferred_date->format('l, F j, Y') : 'To be scheduled' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Time:</strong></td>
                                            <td>{{ $booking->preferred_time }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Amount:</strong></td>
                                            <td class="text-success fw-bold">${{ number_format($booking->total_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Status:</strong></td>
                                            <td>
                                                <span class="badge {{ $booking->payment_status_badge }}">
                                                    {{ ucfirst($booking->payment_status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Assigned Staff</h5>
                                    @if($booking->assignedStaff)
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $booking->assignedStaff->name }}</h6>
                                                <p class="text-muted mb-0">{{ $booking->assignedStaff->position }}</p>
                                            </div>
                                        </div>
                                        <p class="text-muted small">Your assigned cleaning professional will contact you before arrival.</p>
                                    @else
                                        <p class="text-muted">Staff assignment is pending. You will be notified once assigned.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Service Address -->
                            <div class="mt-4">
                                <h5 class="text-primary mb-3">Service Address</h5>
                                <div class="alert alert-light">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    {{ $booking->address }}
                                </div>
                            </div>

                            @if($booking->message || $booking->special_instructions)
                            <!-- Special Instructions -->
                            <div class="mt-4">
                                <h5 class="text-primary mb-3">Special Instructions</h5>
                                @if($booking->message)
                                <div class="alert alert-light mb-2">
                                    <strong>Message:</strong> {{ $booking->message }}
                                </div>
                                @endif
                                @if($booking->special_instructions)
                                <div class="alert alert-light">
                                    <strong>Additional Notes:</strong> {{ $booking->special_instructions }}
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Action Buttons Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3 class="mb-4">Need to Make Changes?</h3>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        @if($booking->status == 'pending')
                        <button class="btn btn-danger btn-lg" onclick="cancelBooking()">
                            <i class="fas fa-times me-2"></i>
                            Cancel Booking
                        </button>
                        @endif
                        <a href="tel:+15551234567" class="btn btn-primary btn-lg">
                            <i class="fas fa-phone me-2"></i>
                            Call Us
                        </a>
                        <a href="mailto:info@delvora.com" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-envelope me-2"></i>
                            Email Us
                        </a>
                        <a href="{{ route('front.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-home me-2"></i>
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3 class="mb-4">Contact Information</h3>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <i class="fas fa-phone fa-2x text-primary mb-3"></i>
                                    <h5>Phone</h5>
                                    <p class="mb-0">(555) 123-4567</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                                    <h5>Email</h5>
                                    <p class="mb-0">info@delvora.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <i class="fas fa-clock fa-2x text-primary mb-3"></i>
                                    <h5>Business Hours</h5>
                                    <p class="mb-0">Mon-Fri: 8AM-6PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function cancelBooking() {
            if (confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
                fetch('{{ route("bookings.cancel", $booking->booking_reference) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Booking cancelled successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            }
        }
    </script>
</x-front-layout> 