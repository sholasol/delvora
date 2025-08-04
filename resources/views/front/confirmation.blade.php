<x-front-layout>
    <!-- Success Section -->
    <section class="py-5 bg-success text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <i class="fas fa-check-circle fa-5x mb-4"></i>
                    <h1 class="display-4 fw-bold mb-3">Booking Confirmed!</h1>
                    <p class="lead mb-4">Thank you for choosing Delvora Cleaning Services. Your booking has been successfully created.</p>
                    <div class="alert alert-light text-dark">
                        <strong>Booking Reference:</strong> {{ $booking->booking_reference }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Details Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg">
                        <div class="card-header bg-white">
                            <h3 class="mb-0">Booking Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Service Information</h5>
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
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span class="badge bg-warning text-dark">Pending Confirmation</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Customer Information</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $booking->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $booking->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>{{ $booking->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Address:</strong></td>
                                            <td>{{ $booking->address }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($booking->message)
                            <div class="mt-4">
                                <h5 class="text-primary mb-3">Special Instructions</h5>
                                <div class="alert alert-light">
                                    {{ $booking->message }}
                                </div>
                            </div>
                            @endif

                            @if($booking->special_instructions)
                            <div class="mt-4">
                                <h5 class="text-primary mb-3">Additional Notes</h5>
                                <div class="alert alert-light">
                                    {{ $booking->special_instructions }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Next Steps Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-center mb-5">What Happens Next?</h2>
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="bg-white rounded p-4 h-100 shadow-sm">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-envelope fa-2x"></i>
                                </div>
                                <h5>Confirmation Email</h5>
                                <p class="text-muted">You'll receive a confirmation email with all the details of your booking.</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="bg-white rounded p-4 h-100 shadow-sm">
                                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-phone fa-2x"></i>
                                </div>
                                <h5>Team Contact</h5>
                                <p class="text-muted">Our team will contact you within 24 hours to confirm your appointment.</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="bg-white rounded p-4 h-100 shadow-sm">
                                <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-calendar-check fa-2x"></i>
                                </div>
                                <h5>Service Day</h5>
                                <p class="text-muted">Our professional team will arrive at your location on the scheduled date and time.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Action Buttons Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="{{ route('front.track', $booking->booking_reference) }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>
                            Track Your Booking
                        </a>
                        <a href="{{ route('front.index') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-home me-2"></i>
                            Back to Home
                        </a>
                        <a href="{{ route('front.services') }}" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-plus me-2"></i>
                            Book Another Service
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3 class="mb-4">Need Help?</h3>
                    <p class="lead mb-4">If you have any questions about your booking, don't hesitate to contact us.</p>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-phone fa-2x mb-3 text-primary"></i>
                            <h5>Call Us</h5>
                            <p class="mb-0">(555) 123-4567</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-envelope fa-2x mb-3 text-primary"></i>
                            <h5>Email Us</h5>
                            <p class="mb-0">info@delvora.com</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-clock fa-2x mb-3 text-primary"></i>
                            <h5>Business Hours</h5>
                            <p class="mb-0">Mon-Fri: 8AM-6PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Important Notes Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="alert alert-info">
                        <h5 class="alert-heading">Important Information</h5>
                        <ul class="mb-0">
                            <li>Please ensure someone is available to provide access to the premises on the scheduled date.</li>
                            <li>You can cancel or reschedule your booking up to 24 hours before the scheduled time.</li>
                            <li>Payment is due upon completion of the service.</li>
                            <li>Our team will arrive within the scheduled time window.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-front-layout>