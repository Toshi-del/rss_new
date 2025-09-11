<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - RSS Citi Health Services</title>
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
        
        /* Service Card Styling */
        .service-card {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: none;
            overflow: hidden;
            height: 100%;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        
        .service-icon {
            font-size: 3rem;
            color: #2563eb;
            margin-bottom: 1rem;
        }
        
        .service-title {
            color: #1e40af;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .service-description {
            color: #4b5563;
            line-height: 1.6;
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
                        <a class="nav-link active" href="/services" style="font-size: 1.1rem; font-weight: 500; padding: 0.5rem 1rem; transition: all 0.3s ease; position: relative; color: #2563eb;">
                            Services
                            <span class="nav-hover-effect" style="width: 100%;"></span>
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
        </div>
    </nav>

    <!-- Services Header -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 mb-4" style="color: #1e40af; font-weight: 600;">Our Medical Services</h1>
                    <p class="lead mb-5" style="color: #4b5563;">
                        We provide a comprehensive range of diagnostic and preventive healthcare services to ensure your well-being.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Drug Test Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card p-4 text-center">
                        <div class="service-icon">
                            <i class="bi bi-capsule"></i>
                        </div>
                        <h3 class="service-title">Drug Testing</h3>
                        <p class="service-description">
                            Comprehensive drug screening services for pre-employment, random testing, and medical purposes. Our laboratory provides accurate results with quick turnaround times.
                        </p>
                        <a href="{{ route('register') }}?corporate=1" class="btn btn-outline-primary mt-3">Learn More</a>
                    </div>
                </div>

                <!-- CBC Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card p-4 text-center">
                        <div class="service-icon">
                            <i class="bi bi-droplet-half"></i>
                        </div>
                        <h3 class="service-title">Complete Blood Count (CBC)</h3>
                        <p class="service-description">
                            Evaluates overall health and detects a wide range of disorders including anemia, infection, and leukemia through comprehensive blood analysis.
                        </p>
                        <a href="{{ route('register') }}?corporate=1" class="btn btn-outline-primary mt-3">Learn More</a>
                    </div>
                </div>

                <!-- Hematology Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card p-4 text-center">
                        <div class="service-icon">
                            <i class="bi bi-eyedropper"></i>
                        </div>
                        <h3 class="service-title">Hematology</h3>
                        <p class="service-description">
                            Specialized blood testing to diagnose blood disorders, assess blood cell production, and monitor blood-related conditions with precision and accuracy.
                        </p>
                        <a href="{{ route('register') }}?corporate=1" class="btn btn-outline-primary mt-3">Learn More</a>
                    </div>
                </div>

                <!-- Urine Analysis Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card p-4 text-center">
                        <div class="service-icon">
                            <i class="bi bi-droplet-fill"></i>
                        </div>
                        <h3 class="service-title">Urine Analysis</h3>
                        <p class="service-description">
                            Complete urinalysis to detect various conditions including urinary tract infections, kidney disease, diabetes, and liver problems.
                        </p>
                        <a href="{{ route('register') }}?corporate=1" class="btn btn-outline-primary mt-3">Learn More</a>
                    </div>
                </div>

                <!-- Stool Test Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card p-4 text-center">
                        <div class="service-icon">
                            <i class="bi bi-clipboard2-pulse"></i>
                        </div>
                        <h3 class="service-title">Stool Examination</h3>
                        <p class="service-description">
                            Stool analysis for detecting digestive disorders, parasitic infections, and screening for colorectal cancer through occult blood testing.
                        </p>
                        <a href="{{ route('register') }}?corporate=1" class="btn btn-outline-primary mt-3">Learn More</a>
                    </div>
                </div>

                <!-- ECG Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card p-4 text-center">
                        <div class="service-icon">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <h3 class="service-title">Electrocardiogram (ECG)</h3>
                        <p class="service-description">
                            Non-invasive test that records the electrical activity of your heart to detect heart problems and monitor heart health.
                        </p>
                        <a href="{{ route('register') }}?corporate=1" class="btn btn-outline-primary mt-3">Learn More</a>
                    </div>
                </div>

                <!-- X-Ray Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card p-4 text-center">
                        <div class="service-icon">
                            <i class="bi bi-file-earmark-medical"></i>
                        </div>
                        <h3 class="service-title">X-Ray Imaging</h3>
                        <p class="service-description">
                            Advanced X-ray imaging services for diagnosing bone fractures, lung conditions, and other internal issues with minimal radiation exposure.
                        </p>
                        <a href="{{ route('register') }}?corporate=1" class="btn btn-outline-primary mt-3">Learn More</a>
                    </div>
                </div>

                <!-- Vision Test Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card p-4 text-center">
                        <div class="service-icon">
                            <i class="bi bi-eye"></i>
                        </div>
                        <h3 class="service-title">Vision Testing</h3>
                        <p class="service-description">
                            Comprehensive eye examinations to assess visual acuity, detect vision problems, and screen for eye diseases such as glaucoma and cataracts.
                        </p>
                        <a href="{{ route('register') }}?corporate=1" class="btn btn-outline-primary mt-3">Learn More</a>
                    </div>
                </div>

                <!-- Blood Pressure Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card p-4 text-center">
                        <div class="service-icon">
                            <i class="bi bi-activity"></i>
                        </div>
                        <h3 class="service-title">Blood Pressure Monitoring</h3>
                        <p class="service-description">
                            Regular blood pressure checks to monitor cardiovascular health, detect hypertension early, and prevent related health complications.
                        </p>
                        <a href="{{ route('register') }}?corporate=1" class="btn btn-outline-primary mt-3">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-5 my-5" style="background: linear-gradient(135deg, #1e3a8a, #2563eb); border-radius: 10px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="display-5 mb-4" style="color: white; font-weight: 600;">Ready to Schedule Your Appointment?</h2>
                    <p class="lead mb-5" style="color: white;">
                        Our team of healthcare professionals is ready to provide you with the best care possible.
                    </p>
                    <a href="#" class="btn btn-light btn-lg px-5 py-3" style="font-weight: 500;">Book Now</a>
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
                                <li class="mb-2" style="color: #4b5563;"><i class="bi bi-clock me-2"></i> Mon-Sat: 8:00 AM - 6:00 PM</li>
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
                        <p>Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#signupModal" data-bs-dismiss="modal">Sign up</a></p>
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
            // Define the birthday and age input elements
            const birthdayInput = document.getElementById('birthday');
            const ageInput = document.getElementById('age');
            
            // Add event listener to birthday input if it exists
            if (birthdayInput) {
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
            
            // Counter animation for statistics
            const counters = document.querySelectorAll('.counter');
            const speed = 200;
            
            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const inc = target / speed;
                    
                    if (count < target) {
                        counter.innerText = Math.ceil(count + inc);
                        setTimeout(updateCount, 1);
                    } else {
                        counter.innerText = target;
                    }
                };
                
                updateCount();
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
                        otherCompanyInput.setAttribute('name', 'company_other');
                        otherCompanyInput.required = true;
                    } else {
                        otherCompanyField.classList.add('d-none');
                        otherCompanyInput.removeAttribute('name');
                        otherCompanyInput.required = false;
                    }
                });
            }
        });
    </script>
</body>
</html>
