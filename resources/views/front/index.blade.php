<x-front-layout>
     <!-- Custom Styles -->
     <style>
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0d6efd 100%);
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        .slider-image-container {
            position: relative;
            height: 600px;
            overflow: hidden;
        }

        .slider-image {
            height: 600px;
            object-fit: cover;
            object-position: center;
            transition: transform 0.5s ease;
        }

        .slider-image:hover {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            padding: 3rem 2rem 2rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .carousel-item:hover .image-overlay {
            transform: translateY(0);
        }

        .overlay-content {
            text-align: center;
        }

        .carousel-indicators {
            bottom: -50px;
        }

        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #fff;
            background-color: transparent;
            margin: 0 8px;
            transition: all 0.3s ease;
        }

        .carousel-indicators button.active {
            background-color: #fff;
            transform: scale(1.2);
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .carousel-control-prev {
            left: 15px;
        }

        .carousel-control-next {
            right: 15px;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 20px;
            height: 20px;
        }

        .btn-light {
            border: none;
            background: #fff;
            color: #333;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-light:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 991px) {
            .slider-image-container {
                height: 400px;
            }
            
            .slider-image {
                height: 400px;
            }
            
            .hero-section .row {
                min-height: auto;
                padding: 4rem 0;
            }
        }

        @media (max-width: 767px) {
            .slider-image-container {
                height: 300px;
                margin-top: 2rem;
            }
            
            .slider-image {
                height: 300px;
            }
            
            .carousel-control-prev,
            .carousel-control-next {
                display: none;
            }
        }

        /* Animation classes */
        .animate__animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        .animate__fadeInLeft {
            animation-name: fadeInLeft;
        }

        .animate__delay-1s {
            animation-delay: 0.5s;
        }

        .animate__delay-2s {
            animation-delay: 1s;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translate3d(-100%, 0, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
    </style>

    <!-- Hero Section with Image Slider -->
    <section class="hero-section position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center min-vh-100 pt-5">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold text-white mb-4 animate__animated animate__fadeInLeft">
                        Professional Cleaning Services You Can Trust
                    </h1>
                    <p class="lead text-white-50 mb-4 animate__animated animate__fadeInLeft animate__delay-1s">
                        Transform your space with our expert cleaning team. Reliable, thorough, and affordable cleaning services for homes and offices.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 animate__animated animate__fadeInLeft animate__delay-2s">
                        <a href="{{route('front.book')}}" class="btn btn-light btn-lg px-4 py-3 fw-semibold">
                            <i class="fas fa-calendar-check me-2"></i>Book Now
                        </a>
                        <a href="{{route('front.services')}}" class="btn btn-outline-light btn-lg px-4 py-3 fw-semibold">
                            <i class="fas fa-list me-2"></i>View Services
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- Image Slider -->
                    <div id="cleaningSlider" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#cleaningSlider" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#cleaningSlider" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#cleaningSlider" data-bs-slide-to="2"></button>
                            <button type="button" data-bs-target="#cleaningSlider" data-bs-slide-to="3"></button>
                            <button type="button" data-bs-target="#cleaningSlider" data-bs-slide-to="4"></button>
                        </div>
                        <div class="carousel-inner rounded-4 shadow-lg overflow-hidden">
                            <div class="carousel-item active">
                                <div class="slider-image-container">
                                    <img src="https://images.pexels.com/photos/4239130/pexels-photo-4239130.jpeg" 
                                         class="d-block w-100 slider-image" 
                                         alt="Professional cleaning team at work">
                                    <div class="image-overlay">
                                        <div class="overlay-content">
                                            <h5 class="text-white fw-bold">Expert Team</h5>
                                            <p class="text-white-50 mb-0">Professional cleaning specialists</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="slider-image-container">
                                    <img src="https://images.pexels.com/photos/4239031/pexels-photo-4239031.jpeg" 
                                         class="d-block w-100 slider-image" 
                                         alt="Modern home cleaning service">
                                    <div class="image-overlay">
                                        <div class="overlay-content">
                                            <h5 class="text-white fw-bold">Home Cleaning</h5>
                                            <p class="text-white-50 mb-0">Spotless homes, happy families</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="slider-image-container">
                                    <img src="https://images.pexels.com/photos/6197109/pexels-photo-6197109.jpeg" 
                                         class="d-block w-100 slider-image" 
                                         alt="Office cleaning professionals">
                                    <div class="image-overlay">
                                        <div class="overlay-content">
                                            <h5 class="text-white fw-bold">Office Cleaning</h5>
                                            <p class="text-white-50 mb-0">Clean workspace, productive team</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="slider-image-container">
                                    <img src="https://images.pexels.com/photos/3616735/pexels-photo-3616735.jpeg" 
                                         class="d-block w-100 slider-image" 
                                         alt="Deep cleaning service">
                                    <div class="image-overlay">
                                        <div class="overlay-content">
                                            <h5 class="text-white fw-bold">Deep Cleaning</h5>
                                            <p class="text-white-50 mb-0">Thorough and detailed service</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="slider-image-container">
                                    <img src="https://images.pexels.com/photos/6196228/pexels-photo-6196228.jpeg" 
                                         class="d-block w-100 slider-image" 
                                         alt="Eco-friendly cleaning supplies">
                                    <div class="image-overlay">
                                        <div class="overlay-content">
                                            <h5 class="text-white fw-bold">Eco-Friendly</h5>
                                            <p class="text-white-50 mb-0">Safe for you and the environment</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#cleaningSlider" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#cleaningSlider" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

   

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Why Choose Delvoraq?</h2>
                <p class="lead text-muted">We deliver exceptional cleaning services with attention to detail and customer satisfaction.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body p-4">
                            <i class="fas fa-users fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Expert Team</h5>
                            <p class="card-text text-muted">Trained and experienced cleaning professionals</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body p-4">
                            <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Insured & Bonded</h5>
                            <p class="card-text text-muted">Fully licensed and insured for your peace of mind</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body p-4">
                            <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Flexible Scheduling</h5>
                            <p class="card-text text-muted">Book at your convenience, including weekends</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body p-4">
                            <i class="fas fa-check-circle fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Satisfaction Guaranteed</h5>
                            <p class="card-text text-muted">100% satisfaction guarantee on all services</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Preview -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Our Services</h2>
                <p class="lead text-muted">Comprehensive cleaning solutions for every need</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://images.pexels.com/photos/6197121/pexels-photo-6197121.jpeg" class="card-img-top" alt="House Cleaning">
                        <div class="card-body">
                            <h5 class="card-title">House Cleaning</h5>
                            <p class="card-text text-muted">Regular and deep cleaning for your home</p>
                            <p class="h4 text-primary fw-bold">Starting at $120</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://images.pexels.com/photos/6197109/pexels-photo-6197109.jpeg" class="card-img-top" alt="Office Cleaning">
                        <div class="card-body">
                            <h5 class="card-title">Office Cleaning</h5>
                            <p class="card-text text-muted">Professional cleaning for workspaces</p>
                            <p class="h4 text-primary fw-bold">Starting at $80</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://images.pexels.com/photos/735319/pexels-photo-735319.jpeg" class="card-img-top" alt="Deep Cleaning">
                        <div class="card-body">
                            <h5 class="card-title">Deep Cleaning</h5>
                            <p class="card-text text-muted">Intensive cleaning for special occasions</p>
                            <p class="h4 text-primary fw-bold">Starting at $200</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="{{route('front.services')}}" class="btn btn-primary btn-lg">View All Services</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">What Our Customers Say</h2>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text text-muted mb-3">
                                "Excellent service! The team was professional, thorough, and left my house spotless. Highly recommend!"
                            </p>
                            <p class="fw-bold mb-0">- Sarah Johnson</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text text-muted mb-3">
                                "Great value for money. The deep cleaning service exceeded my expectations. Will definitely book again!"
                            </p>
                            <p class="fw-bold mb-0">- Mike Rodriguez</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text text-muted mb-3">
                                "Reliable and trustworthy. They've been cleaning our office for months and always do an amazing job."
                            </p>
                            <p class="fw-bold mb-0">- Emma Davis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-3">Ready to Get Started?</h2>
            <p class="lead mb-4">Book your cleaning service today and experience the CleanPro difference.</p>
            <a href="{{route('front.book')}}" class="btn btn-light btn-lg">Book Your Service</a>
        </div>
    </section>
</x-front-layout>