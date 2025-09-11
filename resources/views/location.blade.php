<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location - RSS Citi Health Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 0;
            opacity: 1;
            transition: opacity 0.3s ease-in-out;
        }
        
        /* Page Transition Effects */
        .page-transition {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease-in-out;
        }
        
        .page-transition.active {
            opacity: 0.5;
            pointer-events: all;
        }

        /* Enhanced Navbar Styling */
        .navbar {
            padding: 1rem 0;
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-size: 1.5rem;
            padding-right: 2rem;
            margin-right: 0;
            font-weight: 600;
            letter-spacing: -0.025em;
        }

        .navbar-nav {
            gap: 1.5rem;
        }
        
        /* Auth buttons container */
        .auth-buttons {
            margin-left: auto;
            padding-right: 0;
            display: flex;
            align-items: center;
        }
        
        .nav-item {
            position: relative;
        }

        .nav-link {
            padding: 0.5rem 1rem;
            transition: color 0.3s ease;
        }
        
        /* Modal Styling */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .modal-header {
            padding: 1.2rem 1.5rem;
        }
        .modal-header.bg-primary, .modal-header.bg-blue {
            background-color: #2563eb !important;
        }
        .modal-body {
            padding: 1.8rem;
        }
        .form-label {
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 0.5rem;
        }
        .form-control {
            padding: 0.6rem 1rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.15);
        }
        .input-group-text {
            background-color: #f3f4f6;
            border: 1px solid #e2e8f0;
            color: #6b7280;
            border-radius: 8px 0 0 8px;
        }
        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }
        .btn-primary, .btn-blue {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        .btn-primary:hover, .btn-blue:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
            transform: translateY(-2px);
        }
        .modal a {
            color: #2563eb;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .modal a:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }
        
        /* Footer Styling */
        .footer {
            background-color: #f8f9fa;
            padding: 2rem 0;
            margin-top: 3rem;
            border-top: 1px solid #e9ecef;
        }
        
        .footer-logo img {
            width: 120px;
            height: auto;
            margin-bottom: 1rem;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .footer-left {
            flex: 0 0 25%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        
        .footer-right {
            flex: 0 0 70%;
            display: flex;
            justify-content: flex-end;
            gap: 4rem;
        }
        
        .footer-column {
            flex: 0 0 25%;
            text-align: right;
        }
        
        .footer-column h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2563eb;
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: -5px;
            right: 0;
            width: 50px;
            height: 2px;
            background: #2563eb;
        }
        
        .footer-column p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            text-align: justify;
            text-justify: inter-word;
        }
        
        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: right;
        }
        
        .footer-column ul li {
            margin-bottom: 0.75rem;
        }
        
        .footer-column ul li a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-column ul li a:hover {
            color: #2563eb;
        }
        
        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                gap: 2rem;
            }
            
            .footer-left,
            .footer-right {
                flex: 0 0 100%;
                text-align: center;
                align-items: center;
            }
            
            .footer-column {
                text-align: center;
            }
            
            .footer-column h3::after {
                right: 50%;
                transform: translateX(50%);
            }
            
            .footer-column p {
                text-align: center;
            }
            
            .footer-column ul {
                text-align: center;
            }
        }
        
        .nav-hover-effect {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #2563eb;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover .nav-hover-effect {
            width: 100%;
        }
        
        .nav-link:hover {
            color: #2563eb !important;
        }

        /* Map Styling */
        .map-container {
            position: relative;
            width: 100%;
            height: 450px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        .map-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.9);
            padding: 8px 12px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .map-overlay button {
            background: #2563eb;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .map-overlay button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .map-fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: white;
        }

        .map-fullscreen iframe {
            width: 100%;
            height: 100%;
        }

        .map-fullscreen .map-overlay {
            top: 20px;
            right: 20px;
        }

        .location-info {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .location-info h3 {
            color: #1e40af;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .location-info p {
            color: #4b5563;
            line-height: 1.6;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            background: #eef2ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: #2563eb;
            flex-shrink: 0;
        }

        .contact-text {
            flex-grow: 1;
        }

        .contact-text h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #1e40af;
        }

        .contact-text p {
            margin-bottom: 0;
            color: #4b5563;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background: linear-gradient(135deg, #ffffff, #f8f9fa); box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <div class="container">
            <a class="navbar-brand" href="/" style="font-size: 1.4rem; font-weight: 600; letter-spacing: 0.5px; margin-left: -15px; padding-left: 0; position: relative; left: 0;">
                <i class="bi bi-activity" style="color: #2563eb;"></i> RSS Citi Health Services
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/" style="font-size: 1.1rem; font-weight: 500; padding: 0.5rem 1rem; transition: all 0.3s ease; position: relative;">
                            Home
                            <span class="nav-hover-effect"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about" style="font-size: 1.1rem; font-weight: 500; padding: 0.5rem 1rem; transition: all 0.3s ease; position: relative;">
                            About
                            <span class="nav-hover-effect"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/service" style="font-size: 1.1rem; font-weight: 500; padding: 0.5rem 1rem; transition: all 0.3s ease; position: relative;">
                            Service
                            <span class="nav-hover-effect"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/location" style="font-size: 1.1rem; font-weight: 500; padding: 0.5rem 1rem; transition: all 0.3s ease; position: relative; color: #2563eb;">
                            Location
                            <span class="nav-hover-effect" style="width: 100%;"></span>
                        </a>
                    </li>
                </ul>
                <div class="auth-buttons">
                    <a href="#" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size: 1rem; font-weight: 500; padding: 0.5rem 1.5rem;">Login</a>
                    
                </div>
            </div>
        </div>
    </nav>

    <!-- Location Header -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 mb-4" style="color: #1e40af; font-weight: 600;">Our Location</h1>
                    <p class="lead mb-5" style="color: #4b5563;">
                        Visit our state-of-the-art medical facility, conveniently located to serve you better.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="map-container" id="mapContainer">
                        <div class="map-overlay">
                            <button id="expandMapBtn"><i class="bi bi-arrows-fullscreen"></i> Expand Map</button>
                        </div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.580504401683!2d121.0726871751055!3d14.565965385916304!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c8776061a3f9%3A0xc60878efe8c93aa6!2sRss%20Citi%20Health%20Services%20Corporation!5e0!3m2!1sen!2sph!4v1741794679552!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="location-info">
                        <h3><i class="bi bi-geo-alt-fill me-2"></i>Our Main Clinic</h3>
                        <p>
                            Our main clinic is strategically located in the heart of Pasig City, making it easily accessible for patients from all parts of Metro Manila. The facility is equipped with state-of-the-art medical equipment and staffed by experienced healthcare professionals.
                        </p>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Address</h4>
                                <p>123 Health Avenue, Pasig City, Metro Manila</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Phone</h4>
                                <p>(02) 8123-4567 / 0917-123-4567</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Email</h4>
                                <p>rsscitihealthservices@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="location-info">
                        <h3><i class="bi bi-clock-fill me-2"></i>Operating Hours</h3>
                        <p>
                            We are committed to providing healthcare services when you need them. Our clinic operates with extended hours to accommodate your busy schedule.
                        </p>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-calendar-week"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Weekdays</h4>
                                <p>Monday to Friday: 7:00 AM - 4:00 PM</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-calendar-weekend"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Weekends</h4>
                                <p>Saturday: 8:00 AM - 5:00 PM<br>Sunday: 8:00 AM - 12:00 PM</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Holiday Schedule</h4>
                                <p>Please call our clinic for holiday operating hours</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="location-info">
                        <h3 class="text-center mb-4"><i class="bi bi-signpost-split-fill me-2"></i>How to Reach Us</h3>
                        
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="bi bi-car-front-fill" style="font-size: 2.5rem; color: #2563eb;"></i>
                                        </div>
                                        <h4 class="card-title" style="font-size: 1.2rem; font-weight: 600; color: #1e40af;">By Car</h4>
                                        <p class="card-text" style="color: #4b5563;">
                                            Accessible via C-5 Road and Ortigas Avenue. Ample parking space available for patients and visitors.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="bi bi-train-front-fill" style="font-size: 2.5rem; color: #2563eb;"></i>
                                        </div>
                                        <h4 class="card-title" style="font-size: 1.2rem; font-weight: 600; color: #1e40af;">By Public Transport</h4>
                                        <p class="card-text" style="color: #4b5563;">
                                            Multiple jeepney and bus routes pass near our clinic. The nearest MRT station is Ortigas, a short jeepney ride away.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="bi bi-bicycle" style="font-size: 2.5rem; color: #2563eb;"></i>
                                        </div>
                                        <h4 class="card-title" style="font-size: 1.2rem; font-weight: 600; color: #1e40af;">By Ride-Sharing</h4>
                                        <p class="card-text" style="color: #4b5563;">
                                            Our location is easily accessible via ride-sharing apps. Just set your destination to "RSS Citi Health Services, Pasig City."
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer mt-5" style="background: #f8f9fa; padding: 4rem 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-left mb-4">
                    <div class="footer-logo mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-width: 200px;">
                    </div>
                    <div class="social-icons">
                        <a href="#" class="text-decoration-none me-3" style="color: #4b5563; transition: color 0.3s ease;">
                            <i class="bi bi-facebook" style="font-size: 1.5rem;"></i>
                        </a>
                        <a href="#" class="text-decoration-none me-3" style="color: #4b5563; transition: color 0.3s ease;">
                            <i class="bi bi-twitter" style="font-size: 1.5rem;"></i>
                        </a>
                        <a href="#" class="text-decoration-none me-3" style="color: #4b5563; transition: color 0.3s ease;">
                            <i class="bi bi-instagram" style="font-size: 1.5rem;"></i>
                        </a>
                        <a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">
                            <i class="bi bi-linkedin" style="font-size: 1.5rem;"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <h3 class="mb-3" style="font-weight: 600; color: #1e40af;">About Us</h3>
                            <p style="color: #4b5563; line-height: 1.6; font-size: 0.95rem;">
                                RSS Citi Health Services - Providing quality healthcare services since 2005. Our mission is to deliver compassionate care and promote wellness in our community.
                            </p>
                        </div>
                        <div class="col-md-4 mb-4">
                            <h3 class="mb-3" style="font-weight: 600; color: #1e40af;">Services</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Drug Testing</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Urine Analysis</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">ECG</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">X-Ray Services</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4 mb-4">
                            <h3 class="mb-3" style="font-weight: 600; color: #1e40af;">Contact Us</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2" style="color: #4b5563;"><i class="bi bi-geo-alt me-2"></i> 123 Health Avenue, Medical District</li>
                                <li class="mb-2" style="color: #4b5563;"><i class="bi bi-telephone me-2"></i> (123) 456-7890</li>
                                <li class="mb-2" style="color: #4b5563;"><i class="bi bi-envelope me-2"></i> rsscitihealthservices@gmail.com</li>
                                <li class="mb-2" style="color: #4b5563;"><i class="bi bi-clock me-2"></i> Mon-Fri: 8:00 AM - 4:00 PM</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="border-top pt-4">
                        <p class="text-center mb-0" style="color: #4b5563;">
                            &copy; 2023 RSS Citi Health Services. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="loginModalLabel"><i class="bi bi-box-arrow-in-right me-2"></i>Login to Your Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="login-email" class="form-label">Email/Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="login-email" name="email" value="{{ old('email') }}" placeholder="Enter your email or phone" required>
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="login-password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="login-password" name="password" placeholder="Enter your password" required>
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-unlock-fill me-2"></i>Login</button>
                        </div>
                    </form>
                    
                    <div class="mt-4 text-center">
                      
                    </div>
                </div>
            </div>
        </div>
    </div>

  
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Map expand functionality
            const mapContainer = document.getElementById('mapContainer');
            const expandMapBtn = document.getElementById('expandMapBtn');
            
            if (expandMapBtn) {
                expandMapBtn.addEventListener('click', function() {
                    if (mapContainer.classList.contains('map-fullscreen')) {
                        // Shrink map
                        mapContainer.classList.remove('map-fullscreen');
                        expandMapBtn.innerHTML = '<i class="bi bi-arrows-fullscreen"></i> Expand Map';
                    } else {
                        // Expand map
                        mapContainer.classList.add('map-fullscreen');
                        expandMapBtn.innerHTML = '<i class="bi bi-fullscreen-exit"></i> Shrink Map';
                    }
                });
            }
            
            // Company dropdown "Other" option functionality
            const companySelect = document.getElementById('company');
            const otherCompanyField = document.getElementById('otherCompanyField');
            
            if (companySelect && otherCompanyField) {
                companySelect.addEventListener('change', function() {
                    if (this.value === 'Other') {
                        otherCompanyField.classList.remove('d-none');
                    } else {
                        otherCompanyField.classList.add('d-none');
                    }
                });
            }
            
            // Define the birthday and age input elements
            const birthdayInput = document.getElementById('birthday');
            const ageInput = document.getElementById('age');
            
            // Add event listener to birthday input if it exists
            if (birthdayInput && ageInput) {
                birthdayInput.addEventListener('change', function() {
                    if (this.value) {
                        // Calculate age based on birthday
                        const birthDate = new Date(this.value);
                        const today = new Date();
                        
                        let age = today.getFullYear() - birthDate.getFullYear();
                        const monthDiff = today.getMonth() - birthDate.getMonth();
                        
                        // Adjust age if birthday hasn't occurred yet this year
                        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                            age--;
                        }
                        
                        // Update the age input field
                        ageInput.value = age;
                    }
                });
            }
        });
    </script>
</body>
</html>