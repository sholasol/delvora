<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CleanPro - Professional Cleaning Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-3" href="/">Delvora</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('front.services')}}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('front.about')}}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('front.gallery')}}">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('front.contact')}}">Contact</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <div class="me-3 d-none d-md-block">
                        <i class="fas fa-phone text-primary me-2"></i>
                        <span class="text-muted">(555) 123-4567</span>
                    </div>
                    <a href="{{route('front.book')}}" class="btn btn-primary">Book Now</a>
                </div>
            </div>
        </div>
    </nav>

    {{$slot}}   

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3">
                    <h5 class="text-primary mb-3">CleanPro</h5>
                    <p class="text-muted mb-3">Professional cleaning services you can trust. We make your space spotless.</p>
                    <div class="d-flex gap-3">
                        <i class="fab fa-facebook fa-lg text-muted"></i>
                        <i class="fab fa-twitter fa-lg text-muted"></i>
                        <i class="fab fa-instagram fa-lg text-muted"></i>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <h6 class="mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="index.html" class="text-muted text-decoration-none">Home</a></li>
                        <li><a href="services.html" class="text-muted text-decoration-none">Services</a></li>
                        <li><a href="about.html" class="text-muted text-decoration-none">About</a></li>
                        <li><a href="gallery.html" class="text-muted text-decoration-none">Gallery</a></li>
                        <li><a href="contact.html" class="text-muted text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3">
                    <h6 class="mb-3">Services</h6>
                    <ul class="list-unstyled text-muted">
                        <li>House Cleaning</li>
                        <li>Deep Cleaning</li>
                        <li>Office Cleaning</li>
                        <li>Move-in/Move-out</li>
                        <li>Post-Construction</li>
                    </ul>
                </div>
                
                <div class="col-md-3">
                    <h6 class="mb-3">Contact Info</h6>
                    <div class="text-muted">
                        <p><i class="fas fa-phone me-2 text-primary"></i>(555) 123-4567</p>
                        <p><i class="fas fa-envelope me-2 text-primary"></i>info@cleanpro.com</p>
                        <p><i class="fas fa-map-marker-alt me-2 text-primary"></i>123 Business St, City, ST 12345</p>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            <div class="text-center text-muted">
                <p>&copy; 2024 CleanPro. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
