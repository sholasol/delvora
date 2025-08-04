<x-front-layout>
    <!-- Hero Section -->
    <section class="hero-section bg-primary text-white py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Book Your Cleaning Service</h1>
                    <p class="lead mb-4">Get professional cleaning services tailored to your needs. Book now and enjoy a spotless home!</p>
                    <div class="d-flex gap-3">
                        <div class="text-center">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                            <h5>Quick Booking</h5>
                            <small>Book in minutes</small>
                        </div>
                        <div class="text-center">
                            <i class="fas fa-shield-alt fa-2x mb-2"></i>
                            <h5>Trusted Service</h5>
                            <small>100% satisfaction</small>
                        </div>
                        <div class="text-center">
                            <i class="fas fa-star fa-2x mb-2"></i>
                            <h5>5-Star Rated</h5>
                            <small>Customer approved</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.pexels.com/photos/6195955/pexels-photo-6195955.jpeg" alt="Booking" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-lg">
                        <div class="card-header bg-white">
                            <h3 class="mb-0 text-center">Book Your Service</h3>
                            <p class="text-muted text-center mb-0">Fill out the form below to schedule your cleaning service</p>
                        </div>
                        <div class="card-body p-4">
                            <form id="bookingForm">
                                @csrf
                                
                                <!-- Service Selection -->
                                <div class="mb-4">
                                    <h5 class="mb-3">Select Service</h5>
                                    <div class="row">
                                        @foreach($services as $service)
                                        <div class="col-md-6 mb-3">
                                            <div class="card service-card h-100" data-service-id="{{ $service->id }}" data-service-price="{{ $service->price }}">
                                                <div class="card-body text-center">
                                                    @if($service->image)
                                                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="img-fluid mb-3" style="max-height: 100px;">
                                                    @else
                                                        <div class="bg-light rounded p-3 mb-3">
                                                            <i class="fas fa-broom fa-2x text-primary"></i>
                                                        </div>
                                                    @endif
                                                    <h6 class="card-title">{{ $service->name }}</h6>
                                                    <p class="card-text small text-muted">{{ Str::limit($service->description, 100) }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="text-primary fw-bold">${{ number_format($service->price, 2) }}</span>
                                                        <span class="badge bg-secondary">{{ $service->duration }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="service_id" id="selectedServiceId" required>
                                    <div class="invalid-feedback">Please select a service.</div>
                                </div>

                                <!-- Service Details -->
                                <div id="serviceDetails" class="mb-4" style="display: none;">
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">Selected Service Details</h6>
                                        <div id="serviceInfo"></div>
                                    </div>
                                </div>

                                <!-- Personal Information -->
                                <div class="mb-4">
                                    <h5 class="mb-3">Personal Information</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Full Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                            <div class="invalid-feedback">Please enter your full name.</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email Address *</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                            <div class="invalid-feedback">Please enter a valid email address.</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Phone Number *</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" required>
                                            <div class="invalid-feedback">Please enter your phone number.</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="preferred_date" class="form-label">Preferred Date *</label>
                                            <input type="date" class="form-control" id="preferred_date" name="preferred_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                            <div class="invalid-feedback">Please select a preferred date.</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="preferred_time" class="form-label">Preferred Time *</label>
                                            <select class="form-select" id="preferred_time" name="preferred_time" required>
                                                <option value="">Select time</option>
                                                <option value="08:00 AM">8:00 AM</option>
                                                <option value="09:00 AM">9:00 AM</option>
                                                <option value="10:00 AM">10:00 AM</option>
                                                <option value="11:00 AM">11:00 AM</option>
                                                <option value="12:00 PM">12:00 PM</option>
                                                <option value="01:00 PM">1:00 PM</option>
                                                <option value="02:00 PM">2:00 PM</option>
                                                <option value="03:00 PM">3:00 PM</option>
                                                <option value="04:00 PM">4:00 PM</option>
                                                <option value="05:00 PM">5:00 PM</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a preferred time.</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="total_amount" class="form-label">Total Amount</label>
                                            <input type="text" class="form-control" id="total_amount" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Service Address -->
                                <div class="mb-4">
                                    <h5 class="mb-3">Service Address</h5>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Full Address *</label>
                                        <textarea class="form-control" id="address" name="address" rows="3" required placeholder="Enter your complete address including street, city, state, and zip code"></textarea>
                                        <div class="invalid-feedback">Please enter your complete address.</div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="mb-4">
                                    <h5 class="mb-3">Additional Information</h5>
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Special Instructions (Optional)</label>
                                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Any special requirements or instructions for the cleaning service"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="special_instructions" class="form-label">Additional Notes (Optional)</label>
                                        <textarea class="form-control" id="special_instructions" name="special_instructions" rows="2" placeholder="Any additional notes or preferences"></textarea>
                                    </div>
                                </div>

                                <!-- Terms and Conditions -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a> and <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a> *
                                        </label>
                                        <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                                        <i class="fas fa-calendar-check me-2"></i>
                                        Book Now
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Why Choose Delvora?</h2>
                <p class="lead text-muted">Professional cleaning services you can trust</p>
            </div>
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-white rounded p-4 h-100 shadow-sm">
                        <i class="fas fa-user-check fa-3x text-primary mb-3"></i>
                        <h5>Professional Staff</h5>
                        <p class="text-muted">Our trained and experienced cleaning professionals ensure quality service every time.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-white rounded p-4 h-100 shadow-sm">
                        <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                        <h5>100% Satisfaction</h5>
                        <p class="text-muted">We guarantee your satisfaction with our cleaning services or your money back.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-white rounded p-4 h-100 shadow-sm">
                        <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                        <h5>Flexible Scheduling</h5>
                        <p class="text-muted">Choose the date and time that works best for your schedule.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6>Service Agreement</h6>
                    <p>By booking our cleaning service, you agree to the following terms:</p>
                    <ul>
                        <li>Payment is due upon completion of service</li>
                        <li>Cancellation must be made 24 hours in advance</li>
                        <li>We are not responsible for damage to fragile items</li>
                        <li>Service may be rescheduled due to weather or emergencies</li>
                        <li>Customer must provide access to the premises</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Privacy Policy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6>Data Protection</h6>
                    <p>We are committed to protecting your privacy:</p>
                    <ul>
                        <li>Your personal information is kept confidential</li>
                        <li>We do not share your data with third parties</li>
                        <li>You can request deletion of your data at any time</li>
                        <li>We use secure methods to process payments</li>
                        <li>Your address is only used for service delivery</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Service selection
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove active class from all cards
                document.querySelectorAll('.service-card').forEach(c => c.classList.remove('border-primary'));
                
                // Add active class to selected card
                this.classList.add('border-primary');
                
                // Get service details
                const serviceId = this.dataset.serviceId;
                const servicePrice = this.dataset.servicePrice;
                const serviceName = this.querySelector('.card-title').textContent;
                const serviceDescription = this.querySelector('.card-text').textContent;
                
                // Update form
                document.getElementById('selectedServiceId').value = serviceId;
                document.getElementById('total_amount').value = '$' + parseFloat(servicePrice).toFixed(2);
                
                // Show service details
                document.getElementById('serviceInfo').innerHTML = `
                    <strong>${serviceName}</strong><br>
                    ${serviceDescription}<br>
                    <strong>Price: $${parseFloat(servicePrice).toFixed(2)}</strong>
                `;
                document.getElementById('serviceDetails').style.display = 'block';
            });
        });

        // Form submission
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }
            
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            submitBtn.disabled = true;
            
            const formData = new FormData(this);
            
            fetch('{{ route("bookings.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect_url;
                } else {
                    alert('Error: ' + data.message);
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    </script>
</x-front-layout>