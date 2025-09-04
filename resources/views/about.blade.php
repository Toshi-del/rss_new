<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - RSS Citi Health Services</title>
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
        .navbar .btn {
            padding: 0.6rem 1.5rem;
            margin-left: 1rem;
        }
        .navbar-brand {
            font-size: 1.5rem;
            padding-right: 2rem;
        }
        
        /* About Page Specific Styles */
        .about-header {
            background: linear-gradient(rgba(30, 64, 175, 0.8), rgba(30, 64, 175, 0.9)), url('{{ asset("images/about-bg.jpg") }}');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 5rem 0;
            margin-bottom: 3rem;
        }
        
        .mission-vision-section {
            padding: 4rem 0;
            background-color: #ffffff;
        }
        
        .mission-card, .vision-card {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .mission-card:hover, .vision-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        
        .mission-card {
            background: linear-gradient(135deg, #f0f9ff, #e6f7ff);
            border-left: 5px solid #2563eb;
        }
        
        .vision-card {
            background: linear-gradient(135deg, #f0f9ff, #e6f7ff);
            border-left: 5px solid #1e40af;
        }
        
        .team-section {
            padding: 4rem 0;
            background-color: #f8f9fa;
        }
        
        .team-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 2rem;
        }
        
        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        
        .team-img-container {
            position: relative;
            overflow: hidden;
            height: 250px;
        }
        
        .team-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .team-card:hover .team-img {
            transform: scale(1.1);
        }
        
        .team-info {
            padding: 1.5rem;
            background-color: white;
        }
        
        .team-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }
        
        .team-position {
            color: #2563eb;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        
        .team-bio {
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        .team-social {
            margin-top: 1rem;
        }
        
        .team-social a {
            display: inline-block;
            width: 36px;
            height: 36px;
            background-color: #f3f4f6;
            border-radius: 50%;
            text-align: center;
            line-height: 36px;
            margin-right: 0.5rem;
            color: #4b5563;
            transition: all 0.3s ease;
        }
        
        .team-social a:hover {
            background-color: #2563eb;
            color: white;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 3rem;
            padding-bottom: 1rem;
            text-align: center;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, #1e40af, #2563eb);
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
                        <a class="nav-link active" href="/about" style="font-size: 1.1rem; font-weight: 500; padding: 0.5rem 1rem; transition: all 0.3s ease; position: relative; color: #2563eb;">
                            About
                            <span class="nav-hover-effect" style="width: 100%;"></span>
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
        </div>
    </nav>

    <!-- About Header Section -->
    <section class="about-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 mb-4" style="font-weight: 700;">About RSS Citi Health Services</h1>
                    <p class="lead mb-0">Dedicated to providing exceptional healthcare services since 2005</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Overview Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('images/unnamed.jpg') }}" alt="Company Overview" class="img-fluid rounded-lg shadow-lg" style="object-fit: cover; height: 500px; width: 100%;">
                </div>
                <div class="col-lg-6">
                    <h2 class="mb-4" style="color: #1e40af; font-weight: 600;">Our Story</h2>
                    <p class="lead mb-4" style="color: #4b5563;">
                        RSS Citi Health Services was established in 2005 with a vision to provide accessible, high-quality healthcare services to our community.
                    </p>
                    <p class="mb-4" style="color: #4b5563; line-height: 1.8;">
                        What began as a small clinic with just three staff members has grown into a comprehensive healthcare facility serving thousands of patients annually. Our growth reflects our commitment to excellence in healthcare delivery and our dedication to meeting the evolving needs of our community.
                    </p>
                    <p style="color: #4b5563; line-height: 1.8;">
                        Today, RSS Citi Health Services stands as a beacon of healthcare excellence, offering a wide range of diagnostic and preventive services. Our team of experienced healthcare professionals works tirelessly to ensure that every patient receives personalized care and attention.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="mission-vision-section">
        <div class="container">
            <h2 class="section-title" style="color: #1e40af; font-weight: 600;">Our Mission & Vision</h2>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="mission-card">
                        <div class="d-flex align-items-center mb-4">
                            <div class="me-3">
                                <i class="bi bi-bullseye" style="font-size: 2.5rem; color: #2563eb;"></i>
                            </div>
                            <h3 style="color: #1e40af; font-weight: 600; margin-bottom: 0;">Our Mission</h3>
                        </div>
                        <p style="color: #4b5563; line-height: 1.8;">
                            To provide accessible, high-quality healthcare services that promote wellness and improve the quality of life for our patients. We are committed to delivering compassionate care that addresses the physical, emotional, and spiritual needs of those we serve.
                        </p>
                        <p style="color: #4b5563; line-height: 1.8;">
                            We strive to be a trusted healthcare partner for our community, offering comprehensive diagnostic and preventive services that empower individuals to take control of their health and well-being.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="vision-card">
                        <div class="d-flex align-items-center mb-4">
                            <div class="me-3">
                                <i class="bi bi-eye-fill" style="font-size: 2.5rem; color: #1e40af;"></i>
                            </div>
                            <h3 style="color: #1e40af; font-weight: 600; margin-bottom: 0;">Our Vision</h3>
                        </div>
                        <p style="color: #4b5563; line-height: 1.8;">
                            To be the leading healthcare provider in our region, recognized for excellence in diagnostic services, preventive care, and patient satisfaction. We envision a community where everyone has access to quality healthcare services that enable them to live healthier, more fulfilling lives.
                        </p>
                        <p style="color: #4b5563; line-height: 1.8;">
                            We aim to continuously innovate and improve our services, embracing new technologies and best practices to deliver the highest standard of care to our patients.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title" style="color: #1e40af; font-weight: 600;">Our Core Values</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-heart-pulse-fill" style="font-size: 2.5rem; color: #2563eb;"></i>
                            </div>
                            <h4 class="mb-3" style="color: #1e40af; font-weight: 600;">Compassion</h4>
                            <p style="color: #4b5563;">We treat every patient with kindness, empathy, and respect, recognizing their unique needs and concerns.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-shield-check" style="font-size: 2.5rem; color: #2563eb;"></i>
                            </div>
                            <h4 class="mb-3" style="color: #1e40af; font-weight: 600;">Excellence</h4>
                            <p style="color: #4b5563;">We are committed to delivering the highest standard of care through continuous learning and improvement.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-people-fill" style="font-size: 2.5rem; color: #2563eb;"></i>
                            </div>
                            <h4 class="mb-3" style="color: #1e40af; font-weight: 600;">Integrity</h4>
                            <p style="color: #4b5563;">We uphold the highest ethical standards in all our interactions, ensuring transparency and honesty in everything we do.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <h2 class="section-title" style="color: #1e40af; font-weight: 600;">Our Leadership Team</h2>
            <div class="row">
                                <!-- Administrator -->
                                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card">
                        <div class="team-img-container">
                            <img src="{{ asset('images/admin.jpg') }}" alt="Administrator" class="team-img">
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Elsa Guarin-Nayan</h3>
                            <p class="team-position">Administrator</p>
                            <p class="team-bio">
                                With over 28 years of healthcare management experience, Ms. Nayan oversees all administrative operations at RSS Citi Health Services.
                            </p>
                            <div class="team-social">
                                <a href="#"><i class="bi bi-linkedin"></i></a>
                                <a href="#"><i class="bi bi-twitter"></i></a>
                                <a href="#"><i class="bi bi-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Doctor -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card">
                        <div class="team-img-container">
                            <img src="{{ asset('images/doctor.jpg') }}" alt="Doctor" class="team-img">
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Marian Blanco</h3>
                            <p class="team-position">Assistant Administrator</p>
                            <p class="team-bio">
                               Ms. Blanco is a board-certified and over the years of clinical experience.
                            </p>
                            <div class="team-social">
                                <a href="#"><i class="bi bi-linkedin"></i></a>
                                <a href="#"><i class="bi bi-twitter"></i></a>
                                <a href="#"><i class="bi bi-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Medical Technologist -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card">
                        <div class="team-img-container">
                            <img src="{{ asset('images/medtech.jpg') }}" alt="Medical Technologist" class="team-img">
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Ian Nathaniel Barrientos</h3>
                            <p class="team-position">Head Medical Technologist</p>
                            <p class="team-bio">
                                Ian leads our laboratory services with his expertise in clinical laboratory science and for years of experience in diagnostic testing.
                            </p>
                            <div class="team-social">
                                <a href="#"><i class="bi bi-linkedin"></i></a>
                                <a href="#"><i class="bi bi-twitter"></i></a>
                                <a href="#"><i class="bi bi-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Nursing Director -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card">
                        <div class="team-img-container">
                            <img src="{{ asset('images/nurse.jpg') }}" alt="Nursing Director" class="team-img">
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Rosemary Gerona</h3>
                            <p class="team-position">Finance Head</p>
                            <p class="team-bio">
                                Rosemary oversees our financing and resources.
                            </p>
                            <div class="team-social">
                                <a href="#"><i class="bi bi-linkedin"></i></a>
                                <a href="#"><i class="bi bi-twitter"></i></a>
                                <a href="#"><i class="bi bi-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title" style="color: #1e40af; font-weight: 600;">What Our Patients Say</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-quote" style="font-size: 2rem; color: #2563eb;"></i>
                            </div>
                            <p class="mb-4" style="color: #4b5563; line-height: 1.8;">
                                The staff at RSS Citi Health Services is exceptional. They made me feel comfortable and well-cared for during my visit. The diagnostic process was efficient, and the results were explained clearly.
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle overflow-hidden me-3" style="width: 50px; height: 50px;">
                                    <img src="{{ asset('images/testimonial1.jpg') }}" alt="Patient" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div>
                                    <h5 class="mb-0" style="color: #1e40af; font-weight: 600;">John Davis</h5>
                                    <p class="mb-0" style="color: #6b7280; font-size: 0.9rem;">Patient since 2018</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-quote" style="font-size: 2rem; color: #2563eb;"></i>
                            </div>
                            <p class="mb-4" style="color: #4b5563; line-height: 1.8;">
                                I've been coming to RSS Citi Health Services for my annual check-ups for years. The medical team is knowledgeable, professional, and genuinely cares about their patients' well-being.
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle overflow-hidden me-3" style="width: 50px; height: 50px;">
                                    <img src="{{ asset('images/testimonial2.jpg') }}" alt="Patient" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div>
                                    <h5 class="mb-0" style="color: #1e40af; font-weight: 600;">Maria Rodriguez</h5>
                                    <p class="mb-0" style="color: #6b7280; font-size: 0.9rem;">Patient since 2015</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-quote" style="font-size: 2rem; color: #2563eb;"></i>
                            </div>
                            <p class="mb-4" style="color: #4b5563; line-height: 1.8;">
                                The diagnostic services at RSS Citi Health Services are top-notch. The facility is clean, modern, and equipped with the latest technology. I appreciate the quick turnaround time for test results.
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle overflow-hidden me-3" style="width: 50px; height: 50px;">
                                    <img src="{{ asset('images/testimonial3.jpg') }}" alt="Patient" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div>
                                    <h5 class="mb-0" style="color: #1e40af; font-weight: 600;">David Thompson</h5>
                                    <p class="mb-0" style="color: #6b7280; font-size: 0.9rem;">Patient since 2020</p>
                                </div>
                            </div>
                        </div>
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
                    <h2 class="display-5 mb-4" style="color: white; font-weight: 600;">Join Our Healthcare Family</h2>
                    <p class="lead mb-5" style="color: white;">
                        Experience the difference of personalized, compassionate healthcare at RSS Citi Health Services.
                    </p>
                    <a href="{{ route('register') }}?corporate=1" class="btn btn-light btn-lg px-5 py-3" style="font-weight: 500;">Schedule an Appointment</a>
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
                                <li class="mb-2" style="color: #4b5563;"><i class="bi bi-envelope me-2"></i> info@rssciti.com</li>
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
               
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    
    <!-- Page Transition Element -->
    <div class="page-transition"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
          document.addEventListener('DOMContentLoaded', function() {
            const birthdayInput = document.getElementById('birthday');
            const ageInput = document.getElementById('age');
            
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
          });


        document.addEventListener('DOMContentLoaded', function() {
            // Page transition effect
            document.body.style.opacity = '1';
            
            // Handle navigation transitions
            const navLinks = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([data-bs-toggle])');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (link.hostname === window.location.hostname) {
                        e.preventDefault();
                        const pageTransition = document.querySelector('.page-transition');
                        pageTransition.classList.add('active');
                        
                        setTimeout(function() {
                            window.location.href = link.href;
                        }, 300);
                    }
                });
            });
            
            // Hover effect for navigation links
            const navItems = document.querySelectorAll('.nav-link');
            
            navItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('active')) {
                        this.querySelector('.nav-hover-effect').style.width = '100%';
                    }
                });
                
                item.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active')) {
                        this.querySelector('.nav-hover-effect').style.width = '0';
                    }
                });
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
