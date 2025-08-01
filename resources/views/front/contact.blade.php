<x-front-layout>
        <!-- Header -->
        <section class="py-5 bg-primary text-white">
            <div class="container">
                <div class="text-center">
                    <h1 class="display-4 fw-bold mb-3">Contact Us</h1>
                    <p class="lead">Get in touch with us for a free quote or to schedule your cleaning service. We're here to help!</p>
                </div>
            </div>
        </section>
    
        <!-- Contact Form & Info -->
        <section class="py-5">
            <div class="container">
                <div class="row g-5">
                    <!-- Contact Form -->
                    <div class="col-lg-7">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h3 class="card-title mb-0">Send us a Message</h3>
                            </div>
                            <div class="card-body p-4">
                                <form id="contactForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message *</label>
                                        <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Tell us about your cleaning needs..."></textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary w-100">
                                        <span class="submit-text">Send Message</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    </button>
                                    
                                    <div id="formMessage" class="mt-3"></div>
                                </form>
                            </div>
                        </div>
                    </div>
    
                    <!-- Contact Information -->
                    <div class="col-lg-5">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h3 class="card-title mb-0">Get in Touch</h3>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start mb-4">
                                    <i class="fas fa-phone fa-lg text-primary me-3 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Phone</h6>
                                        <p class="mb-1">(555) 123-4567</p>
                                        <small class="text-muted">Available 24/7 for emergencies</small>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start mb-4">
                                    <i class="fas fa-envelope fa-lg text-primary me-3 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Email</h6>
                                        <p class="mb-1">info@delvora.com</p>
                                        <small class="text-muted">We'll respond within 24 hours</small>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start mb-4">
                                    <i class="fas fa-map-marker-alt fa-lg text-primary me-3 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Address</h6>
                                        <p class="mb-0">123 Business Street<br>City, ST 12345</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-clock fa-lg text-primary me-3 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Business Hours</h6>
                                        <div class="small">
                                            <p class="mb-1">Monday - Friday: 8:00 AM - 6:00 PM</p>
                                            <p class="mb-1">Saturday: 9:00 AM - 4:00 PM</p>
                                            <p class="mb-0">Sunday: Closed</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <!-- Map -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Find Us</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <p class="text-muted">Google Maps Integration</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- FAQ Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-6 fw-bold mb-3">Frequently Asked Questions</h2>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-2">How far in advance should I book?</h6>
                                <p class="card-text text-muted mb-0">We recommend booking at least 48 hours in advance, though we can often accommodate same-day requests.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-2">Do you provide cleaning supplies?</h6>
                                <p class="card-text text-muted mb-0">Yes, we bring all necessary cleaning supplies and equipment. We use eco-friendly products by default.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-2">Are you insured and bonded?</h6>
                                <p class="card-text text-muted mb-0">We are fully licensed, bonded, and insured for your complete peace of mind.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-2">What if I'm not satisfied?</h6>
                                <p class="card-text text-muted mb-0">We offer a 100% satisfaction guarantee. If you're not happy, we'll return within 24 hours to make it right.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</x-front-layout>