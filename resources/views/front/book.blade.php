<x-front-layout>
        <!-- Header -->
        <section class="py-5 bg-primary text-white">
            <div class="container">
                <div class="text-center">
                    <h1 class="display-4 fw-bold mb-3">Book Your Cleaning Service</h1>
                    <p class="lead">Fill out the form below and we'll get back to you with a confirmation within 24 hours.</p>
                </div>
            </div>
        </section>
    
        <!-- Booking Form -->
        <section class="py-5">
            <div class="container">
                <div class="row g-5">
                    <!-- Form -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h3 class="card-title mb-0">
                                    <i class="fas fa-calendar me-2"></i>
                                    Booking Details
                                </h3>
                            </div>
                            <div class="card-body p-4">
                                <form id="bookingForm">
                                    <!-- Service Selection -->
                                    <div class="mb-4">
                                        <label for="serviceId" class="form-label">Service Type *</label>
                                        <select class="form-select" id="serviceId" name="serviceId" required>
                                            <option value="">Select a service</option>
                                            <option value="1">Standard House Cleaning - $120</option>
                                            <option value="2">Deep Cleaning - $200</option>
                                            <option value="3">Move-in/Move-out Cleaning - $250</option>
                                            <option value="4">Office Cleaning - $80</option>
                                            <option value="5">Post-Construction Cleanup - $300</option>
                                        </select>
                                    </div>
    
                                    <!-- Date and Time -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label for="bookingDate" class="form-label">Preferred Date *</label>
                                            <input type="date" class="form-control" id="bookingDate" name="bookingDate" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="bookingTime" class="form-label">Preferred Time *</label>
                                            <select class="form-select" id="bookingTime" name="bookingTime" required>
                                                <option value="">Select time</option>
                                                <option value="08:00">8:00 AM</option>
                                                <option value="09:00">9:00 AM</option>
                                                <option value="10:00">10:00 AM</option>
                                                <option value="11:00">11:00 AM</option>
                                                <option value="12:00">12:00 PM</option>
                                                <option value="13:00">1:00 PM</option>
                                                <option value="14:00">2:00 PM</option>
                                                <option value="15:00">3:00 PM</option>
                                                <option value="16:00">4:00 PM</option>
                                            </select>
                                        </div>
                                    </div>
    
                                    <!-- Customer Information -->
                                    <div class="border-top pt-4 mb-4">
                                        <h5 class="mb-3">
                                            <i class="fas fa-user me-2"></i>
                                            Your Information
                                        </h5>
                                        
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Full Name *</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email *</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <label for="phone" class="form-label">Phone Number *</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" required>
                                        </div>
                                    </div>
    
                                    <!-- Address -->
                                    <div class="border-top pt-4 mb-4">
                                        <h5 class="mb-3">
                                            <i class="fas fa-map-marker-alt me-2"></i>
                                            Service Address
                                        </h5>
                                        
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Full Address *</label>
                                            <textarea class="form-control" id="address" name="address" rows="3" required placeholder="Street address, city, state, zip code"></textarea>
                                        </div>
                                    </div>
    
                                    <!-- Special Instructions -->
                                    <div class="mb-4">
                                        <label for="specialInstructions" class="form-label">Special Instructions</label>
                                        <textarea class="form-control" id="specialInstructions" name="specialInstructions" rows="4" placeholder="Any special requests, areas of focus, or access instructions..."></textarea>
                                    </div>
    
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <span class="submit-text">Book Service</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    </button>
                                    
                                    <div id="formMessage" class="mt-3"></div>
                                </form>
                            </div>
                        </div>
                    </div>
    
                    <!-- Booking Summary -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm sticky-top" style="top: 100px;">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Booking Summary</h5>
                            </div>
                            <div class="card-body">
                                <div id="selectedService" class="d-none">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fw-medium">Service:</span>
                                        <span id="serviceName" class="text-end"></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="fw-medium">Starting Price:</span>
                                        <span id="servicePrice" class="h4 text-success fw-bold"></span>
                                    </div>
                                    <div class="border-top pt-3">
                                        <p class="small text-muted mb-0">* Final price may vary based on home size and specific requirements</p>
                                    </div>
                                </div>
                                
                                <div id="noService" class="text-muted">
                                    <p>Select a service to see pricing</p>
                                </div>
    
                                <div class="border-top pt-3 mt-3">
                                    <div class="d-flex align-items-center mb-2 small text-muted">
                                        <i class="fas fa-clock me-2"></i>
                                        <span>Free consultation included</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 small text-muted">
                                        <i class="fas fa-calendar me-2"></i>
                                        <span>Flexible rescheduling</span>
                                    </div>
                                    <div class="d-flex align-items-center small text-muted">
                                        <i class="fas fa-user me-2"></i>
                                        <span>Satisfaction guaranteed</span>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <!-- Contact Info -->
                        <div class="card shadow-sm mt-4">
                            <div class="card-header bg-white">
                                <h6 class="card-title mb-0">Need Help?</h6>
                            </div>
                            <div class="card-body">
                                <p class="small text-muted mb-3">Have questions about our services or need a custom quote?</p>
                                <div class="small">
                                    <p class="mb-1"><strong>Phone:</strong> (555) 123-4567</p>
                                    <p class="mb-0"><strong>Email:</strong> info@cleanpro.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</x-front-layout>