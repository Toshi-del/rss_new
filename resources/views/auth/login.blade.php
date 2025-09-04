<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RSS Citi Health Services</title>
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

        /* Enhanced Card Styling */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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
        /* Number Badge Styling - Modern Design */
        .number-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .number-badge:before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        .number-badge:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.4);
        }
        .info-number {
            display: flex;
            justify-content: center;
        }
        @media (max-width: 991px) {
            .navbar-nav {
                gap: 0.5rem;
                padding: 1rem 0;
            }
            .navbar .btn {
                margin: 0.5rem 0;
                display: block;
                width: 100%;
            }
        }

        /* Footer Styling */

        .footer {
            background-color: #f8f9fa;
            padding: 2rem 0; /* Reduced from 4rem */
            margin-top: 3rem; /* Reduced from 5rem */
            border-top: 1px solid #e9ecef;
        }
        
        .footer-logo img {
            width: 120px; /* Reduced from 180px */
            height: auto;
            margin-bottom: 1rem; /* Reduced from 1.5rem */
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
        .subscribe {
            text-align: center;
            margin-top: 1rem;
        }
        .subscribe input {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px;
        }
        .subscribe button {
            padding: 0.5rem 1rem;
            border: none;
            background-color: #2563eb;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .subscribe button:hover {
            background-color: #1d4ed8;
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
                        <a class="nav-link" href="/location" style="font-size: 1.1rem; font-weight: 500; padding: 0.5rem 1rem; transition: all 0.3s ease; position: relative;">
                            Location
                            <span class="nav-hover-effect"></span>
                        </a>
                    </li>
                </ul>
                <div class="auth-buttons">
                    <a href="#" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size: 1rem; font-weight: 500; padding: 0.5rem 1.5rem;">Login</a>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <section class="hero-section" style="padding: 3rem 0; margin-bottom: 3rem;">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <h1 class="hero-text" style="color: #1e40af; font-weight: 600; line-height: 1.2; margin-bottom: 1.5rem; font-size: 1.8rem; text-align: left;">
                        Faith is being sure of what we hope for,
                        and certain of what we do not see.
                    </h1>
                </div>
            </div>
        </div>
    </section>

  <!-- Info Cards Section -->
    <section class="info-cards-container py-5">
        <div class="container">
            <div class="row">
                <!-- Corporate Booking Card -->
                <div class="col-md-4 mb-4">
                    <div class="info-card h-100">
                        <div class="icon">
                            <i class="bi bi-building-fill"></i>
                        </div>
                        <h3 class="card-title mb-3">Corporate Booking</h3>
                        <div class="info-number mb-3">
                            <span class="number-badge">01</span>
                        </div>
                        <p class="card-text">Schedule appointments for your entire organization with our corporate booking service. Special rates available for companies with more than 50 employees.</p>
                        <a href="{{ route('register') }}?corporate=1" class="btn btn-outline-primary mt-3">Learn More</a>
                    </div>
                </div>
                
                <!-- RSS Daily Schedule Card -->
                <div class="col-md-4 mb-4">
                    <div class="info-card h-100">
                        <div class="icon">
                            <i class="bi bi-calendar-week-fill"></i>
                        </div>
                        <h3 class="card-title mb-3">RSS Daily Schedule</h3>
                        <div class="info-number mb-3">
                            <span class="number-badge">02</span>
                        </div>
                        <p class="card-text">View our daily schedule of activities, services, and special events. Morning prayers start at 6:00 AM, followed by regular services throughout the day.</p>
                        <a href="#" class="btn btn-outline-primary mt-3">View Schedule</a>
                    </div>
                </div>
                
                <!-- OPD Walk-in Card -->
                <div class="col-md-4 mb-4">
                    <div class="info-card h-100">
                        <div class="icon">
                            <i class="bi bi-person-walking"></i>
                        </div>
                        <h3 class="card-title mb-3">OPD (Walk-in)</h3>
                        <div class="info-number mb-3">
                            <span class="number-badge">03</span>
                        </div>
                        <p class="card-text">Our Outpatient Department welcomes walk-in patients from 8:00 AM to 5:00 PM, Monday through Saturday. No appointment necessary for general consultations.</p>
                        <a href="#" class="btn btn-outline-primary mt-3">Visit Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section" style="background: linear-gradient(135deg, #1e3a8a, #2563eb); padding: 4rem 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-3 stat-box">
                    <h2 class="counter" data-target="3468" style="color: white;">10</h2>
                    <p style="color: white;">Services</p>
                </div>
                <div class="col-md-3 stat-box">
                    <h2 class="counter" data-target="557" style="color: white;">2</h2>
                    <p style="color: white;">Doctors</p>
                </div>
                <div class="col-md-3 stat-box">
                    <h2 class="counter" data-target="4379" style="color: white;">500+</h2>
                    <p style="color: white;">Happy Patients</p>
                </div>
                <div class="col-md-3 stat-box">
                    <h2 class="counter" data-target="32" style="color: white;">15</h2>
                    <p style="color: white;">Years of Experience</p>
                </div>
            </div>
        </div>
    </section>

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
                        <p class="text-sm text-gray-600">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                                Register here
                            </a>
                        </p>
                        <p class="mt-2 text-sm">
                            Are you a new Corporate Client? 
                            <a href="{{ route('register') }}?corporate=1" class="text-blue-600 hover:text-blue-800 font-medium">
                                Register here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <script>
        // Function to calculate age from birthday
        document.addEventListener('DOMContentLoaded', function() {
            const birthdayInput = document.getElementById('birthday');
            const ageInput = document.getElementById('age');
            
            // Only add event listener if elements exist
            if (birthdayInput && ageInput) {
                // Add event listener to birthday input
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
            
            // Function to animate counters
            function animateCounters() {
                const counters = document.querySelectorAll('.counter');
                const speed = 200; // The lower the faster
                
                counters.forEach(counter => {
                    const animate = () => {
                        const target = +counter.getAttribute('data-target');
                        const count = +counter.innerText;
                        
                        // Calculate increment
                        const increment = target / speed;
                        
                        // If count is less than target, add increment
                        if (count < target) {
                            // Round up and set counter value
                            counter.innerText = Math.ceil(count + increment);
                            // Call function every ms
                            setTimeout(animate, 1);
                        } else {
                            counter.innerText = target;
                        }
                    };
                    
                    animate();
                });
            }
            
            // Use Intersection Observer to trigger animation when stats section is visible
            const statsSection = document.querySelector('.stats-section');
            if (statsSection) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Add animation class to stat boxes
                            document.querySelectorAll('.stat-box').forEach(box => {
                                box.classList.add('animate');
                            });
                            
                            // Start counter animation
                            animateCounters();
                            
                            // Unobserve after animation is triggered
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.2 }); // Trigger when 20% of the section is visible
                
                observer.observe(statsSection);
            }
        });
    </script>

    <!-- Footer Section -->
    <footer class="footer mt-5" style="background: #f8f9fa; padding: 4rem 0;">
        <div class="footer-container container">
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
                <div class="col-md-8 footer-right">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <h3 class="mb-3" style="font-weight: 600; color: #1e40af;">About Us</h3>
                            <p style="color: #4b5563; line-height: 1.6; font-size: 0.95rem;">
                                RSS Clift Health Services - Providing quality healthcare services since 2005. Our mission is to deliver compassionate care and promote wellness in our community.
                            </p>
                        </div>
                        <div class="col-md-3 mb-4">
                            <h3 class="mb-3" style="font-weight: 600; color: #1e40af;">Departments</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Cardiology</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Neurology</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Orthopedics</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Pediatrics</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 mb-4">
                            <h3 class="mb-3" style="font-weight: 600; color: #1e40af;">Support</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Contact Us</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">FAQs</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Privacy Policy</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Terms of Service</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 mb-4">
                            <h3 class="mb-3" style="font-weight: 600; color: #1e40af;">Quick Links</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Appointments</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Doctors</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Services</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #4b5563; transition: color 0.3s ease;">Testimonials</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribe">
            <input type="email" placeholder="Enter your email">
            <button type="submit">Subscribe</button>
        </div>
        <div class="text-center mt-4">
            <p class="text-muted small mb-0">&copy; 2023 RSS Citi Health Services. All rights reserved.</p>
        </div>
    </footer>
    
    <!-- Page Transition Element -->
    <div class="page-transition"></div>
    
    <script>
        // Page transition functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all navigation links for smooth transitions
            const navLinks = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"]):not([data-bs-toggle])');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Only apply transition for internal links
                    if (this.hostname === window.location.hostname) {
                        e.preventDefault();
                        const transitionElement = document.querySelector('.page-transition');
                        const destination = this.href;
                        
                        // Activate transition
                        transitionElement.classList.add('active');
                        document.body.style.opacity = '0.8';
                        
                        // Navigate after transition effect
                        setTimeout(function() {
                            window.location.href = destination;
                        }, 300);
                    }
                });
            });
            
            // Fade in when page loads
            window.addEventListener('pageshow', function() {
                document.body.style.opacity = '1';
                document.querySelector('.page-transition').classList.remove('active');
            });
        });


            document.addEventListener('DOMContentLoaded', function() {
                // Company dropdown "Other" option functionality
                const companySelect = document.getElementById('company');
                const otherCompanyField = document.getElementById('otherCompanyField');
                const otherCompanyInput = document.getElementById('otherCompany');
                
                if (companySelect) {
                    companySelect.addEventListener('change', function() {
                        if (this.value === 'Other') {
                            otherCompanyField.classList.remove('d-none');
                            // Update the main company field with the custom value
                            otherCompanyInput.addEventListener('input', function() {
                                // This will update the actual company value that gets submitted
                                const hiddenInput = document.createElement('input');
                                hiddenInput.type = 'hidden';
                                hiddenInput.name = 'company';
                                hiddenInput.value = this.value;
                                // Replace any existing hidden input
                                const existingHidden = document.querySelector('input[type="hidden"][name="company"]');
                                if (existingHidden && existingHidden !== companySelect) {
                                    existingHidden.remove();
                                }
                                companySelect.parentNode.appendChild(hiddenInput);
                            });
                        } else {
                            otherCompanyField.classList.add('d-none');
                        }
                    });
                }
            });
        </script>


</body>
</html>