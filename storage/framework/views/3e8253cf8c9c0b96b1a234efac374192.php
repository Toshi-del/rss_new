<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - RSS Citi Health Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        .page-transition { position: fixed; inset: 0; background-color: #ffffff; z-index: 50; opacity: 0; pointer-events: none; transition: opacity .3s ease-in-out; }
        .page-transition.active { opacity: .5; pointer-events: all; }
        @keyframes float { 0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)} }
        .animate-float { animation: float 3s ease-in-out infinite; }
    </style>
</head>
<body class="bg-white text-gray-900">
    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-40 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center space-x-2 text-xl font-bold text-blue-600 hover:text-blue-700">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-md grid place-items-center">
                        <i class="fa-solid fa-wave-square text-white text-sm"></i>
                    </div>
                    <span class="hidden sm:block">RSS Citi Health Services</span>
                </a>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="/" class="relative group text-gray-700 hover:text-blue-600 transition-colors">Home<span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span></a>
                    <a href="/about" class="relative group text-blue-700 font-semibold">About<span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-700"></span></a>
                    <a href="/service" class="relative group text-gray-700 hover:text-blue-600 transition-colors">Service<span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span></a>
                    <a href="/location" class="relative group text-gray-700 hover:text-blue-600 transition-colors">Location<span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span></a>
                </div>

                <div class="hidden md:block">
                    <button onclick="openRegisterModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition-all transform hover:scale-105 shadow">
                        Register
                    </button>
                </div>

                <button onclick="toggleMobileMenu()" class="md:hidden text-gray-700 hover:text-blue-600">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="pt-2 space-y-2 border-t border-gray-100">
                    <a href="/" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Home</a>
                    <a href="/about" class="block px-3 py-2 rounded-lg text-blue-700 bg-blue-50">About</a>
                    <a href="/service" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Service</a>
                    <a href="/location" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Location</a>
                    <button onclick="openRegisterModal()" class="w-full px-3 py-2 rounded-lg bg-blue-600 text-white">Register</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        <div class="absolute inset-0 pointer-events-none opacity-10" style="background-image:url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%232563eb\" fill-opacity=\"0.15\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 mb-6">About RSS Citi Health Services</h1>
                    <p class="text-lg text-gray-600 leading-relaxed">Dedicated to providing exceptional, compassionate healthcare services since 2005. We combine modern diagnostics with personalized care to improve community wellness.</p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="#leadership" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                            Meet our leadership
                            <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                        <button onclick="openRegisterModal()" class="inline-flex items-center px-6 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                            Get Started
                            <i class="fa-solid fa-user-plus ml-2"></i>
                        </button>
                    </div>
                </div>
                <div class="relative animate-float">
                    <div class="w-full h-72 sm:h-96 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-3xl shadow-2xl grid place-items-center text-white">
                        <div class="text-center">
                            <i class="fa-solid fa-hand-holding-heart text-6xl opacity-90"></i>
                            <h3 class="mt-4 text-2xl font-semibold">Compassion. Excellence. Trust.</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Overview -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <img src="<?php echo e(asset('images/unnamed.jpg')); ?>" alt="Company Overview" class="w-full h-[420px] object-cover rounded-2xl shadow-lg" onerror="this.src='<?php echo e(asset('images/placeholder.jpg')); ?>'">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Story</h2>
                    <p class="text-gray-600 leading-7 mb-4">RSS Citi Health Services was established in 2005 with a vision to provide accessible, high-quality healthcare to our community.</p>
                    <p class="text-gray-600 leading-7 mb-4">From a small clinic to a comprehensive facility serving thousands annually, our growth reflects our commitment to excellence and evolving patient needs.</p>
                    <p class="text-gray-600 leading-7">Today, we offer a wide range of diagnostic and preventive services, delivered by experienced professionals who prioritize personalized care and attention.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Mission & Vision</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="rounded-2xl border border-gray-100 shadow-sm p-8 bg-gradient-to-br from-blue-50 to-white">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 grid place-items-center mr-3">
                            <i class="fa-solid fa-bullseye"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Our Mission</h3>
                    </div>
                    <p class="text-gray-700 leading-7">To provide accessible, high-quality healthcare services that promote wellness and improve the quality of life for our patients. We deliver compassionate care addressing physical, emotional, and spiritual needs.</p>
                </div>
                <div class="rounded-2xl border border-gray-100 shadow-sm p-8 bg-gradient-to-br from-indigo-50 to-white">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 grid place-items-center mr-3">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Our Vision</h3>
                    </div>
                    <p class="text-gray-700 leading-7">To be the leading healthcare provider in our region, recognized for excellence in diagnostics, preventive care, and patient satisfaction, continuously innovating to deliver the highest standards.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Core Values</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="h-full rounded-2xl bg-white border border-gray-100 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-blue-100 text-blue-600 grid place-items-center">
                        <i class="fa-solid fa-heart-pulse text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Compassion</h4>
                    <p class="text-gray-600">We treat every patient with kindness, empathy, and respect, recognizing their unique needs and concerns.</p>
                </div>
                <div class="h-full rounded-2xl bg-white border border-gray-100 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-blue-100 text-blue-600 grid place-items-center">
                        <i class="fa-solid fa-shield-heart text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Excellence</h4>
                    <p class="text-gray-600">We are committed to delivering the highest standard of care through continuous learning and improvement.</p>
                </div>
                <div class="h-full rounded-2xl bg-white border border-gray-100 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-blue-100 text-blue-600 grid place-items-center">
                        <i class="fa-solid fa-scale-balanced text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Integrity</h4>
                    <p class="text-gray-600">We uphold high ethical standards in all interactions, ensuring transparency and honesty in everything we do.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Team -->
    <section id="leadership" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Leadership Team</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Card Template: equal height via flex -->
                <div class="flex flex-col rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                    <div class="relative h-56 bg-gray-100">
                        <img src="<?php echo e(asset('images/admin.jpg')); ?>" alt="Administrator" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.querySelector('.avatar-fallback').classList.remove('hidden')">
                        <div class="avatar-fallback hidden absolute inset-0 grid place-items-center text-blue-600">
                            <i class="fa-solid fa-user-tie text-5xl"></i>
                        </div>
                    </div>
                    <div class="flex-1 p-5">
                        <h3 class="text-lg font-semibold">Elsa Guarin-Nayan</h3>
                        <p class="text-blue-600 font-medium">Administrator</p>
                        <p class="text-gray-600 mt-3">Over 28 years of healthcare management experience overseeing all administrative operations.</p>
                        <div class="mt-4 flex space-x-3 text-gray-500">
                            <a href="#" class="hover:text-blue-600"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#" class="hover:text-blue-600"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="#" class="hover:text-blue-600"><i class="fa-regular fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                    <div class="relative h-56 bg-gray-100">
                        <img src="<?php echo e(asset('images/doctor.jpg')); ?>" alt="Assistant Administrator" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.querySelector('.avatar-fallback').classList.remove('hidden')">
                        <div class="avatar-fallback hidden absolute inset-0 grid place-items-center text-blue-600">
                            <i class="fa-solid fa-user-tie text-5xl"></i>
                        </div>
                    </div>
                    <div class="flex-1 p-5">
                        <h3 class="text-lg font-semibold">Marian Blanco</h3>
                        <p class="text-blue-600 font-medium">Assistant Administrator</p>
                        <p class="text-gray-600 mt-3">Board-certified professional with years of clinical and administrative experience.</p>
                        <div class="mt-4 flex space-x-3 text-gray-500">
                            <a href="#" class="hover:text-blue-600"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#" class="hover:text-blue-600"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="#" class="hover:text-blue-600"><i class="fa-regular fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                    <div class="relative h-56 bg-gray-100">
                        <img src="<?php echo e(asset('images/medtech.jpg')); ?>" alt="Head Medical Technologist" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.querySelector('.avatar-fallback').classList.remove('hidden')">
                        <div class="avatar-fallback hidden absolute inset-0 grid place-items-center text-blue-600">
                            <i class="fa-solid fa-user-tie text-5xl"></i></div>
                    </div>
                    <div class="flex-1 p-5">
                        <h3 class="text-lg font-semibold">Ian Nathaniel Barrientos</h3>
                        <p class="text-blue-600 font-medium">Head Medical Technologist</p>
                        <p class="text-gray-600 mt-3">Leads laboratory services with expertise in diagnostic testing and quality assurance.</p>
                        <div class="mt-4 flex space-x-3 text-gray-500">
                            <a href="#" class="hover:text-blue-600"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#" class="hover:text-blue-600"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="#" class="hover:text-blue-600"><i class="fa-regular fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                    <div class="relative h-56 bg-gray-100">
                        <img src="<?php echo e(asset('images/nurse.jpg')); ?>" alt="Finance Head" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.querySelector('.avatar-fallback').classList.remove('hidden')">
                        <div class="avatar-fallback hidden absolute inset-0 grid place-items-center text-blue-600">
                            <i class="fa-solid fa-user-tie text-5xl"></i></div>
                    </div>
                    <div class="flex-1 p-5">
                        <h3 class="text-lg font-semibold">Rosemary Gerona</h3>
                        <p class="text-blue-600 font-medium">Finance Head</p>
                        <p class="text-gray-600 mt-3">Oversees financial planning and resource management to support patient services.</p>
                        <div class="mt-4 flex space-x-3 text-gray-500">
                            <a href="#" class="hover:text-blue-600"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#" class="hover:text-blue-600"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="#" class="hover:text-blue-600"><i class="fa-regular fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">What Our Patients Say</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <div class="mb-6">
                        <i class="fa-solid fa-quote-left text-3xl text-blue-600"></i>
                    </div>
                    <p class="text-gray-700 leading-7 mb-6">
                        The staff at RSS Citi Health Services is exceptional. They made me feel comfortable and well-cared for during my visit. The diagnostic process was efficient, and the results were explained clearly.
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4 bg-gray-200 flex items-center justify-center">
                            <img src="<?php echo e(asset('images/testimonial1.jpg')); ?>" alt="Patient" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fa-solid fa-user text-gray-500\'></i>'">
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-900">John Davis</h5>
                            <p class="text-sm text-gray-600">Patient since 2018</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <div class="mb-6">
                        <i class="fa-solid fa-quote-left text-3xl text-blue-600"></i>
                    </div>
                    <p class="text-gray-700 leading-7 mb-6">
                        I've been coming to RSS Citi Health Services for my annual check-ups for years. The medical team is knowledgeable, professional, and genuinely cares about their patients' well-being.
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4 bg-gray-200 flex items-center justify-center">
                            <img src="<?php echo e(asset('images/testimonial2.jpg')); ?>" alt="Patient" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fa-solid fa-user text-gray-500\'></i>'">
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-900">Maria Rodriguez</h5>
                            <p class="text-sm text-gray-600">Patient since 2015</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <div class="mb-6">
                        <i class="fa-solid fa-quote-left text-3xl text-blue-600"></i>
                    </div>
                    <p class="text-gray-700 leading-7 mb-6">
                        The diagnostic services at RSS Citi Health Services are top-notch. The facility is clean, modern, and equipped with the latest technology. I appreciate the quick turnaround time for test results.
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4 bg-gray-200 flex items-center justify-center">
                            <img src="<?php echo e(asset('images/testimonial3.jpg')); ?>" alt="Patient" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fa-solid fa-user text-gray-500\'></i>'">
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-900">David Thompson</h5>
                            <p class="text-sm text-gray-600">Patient since 2020</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Our Impact</h2>
                <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                    Numbers that reflect our commitment to excellence in healthcare
                </p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-stethoscope text-white text-xl"></i>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-bold text-white mb-2 counter" data-target="10">0</h3>
                        <p class="text-blue-100 font-medium">Services</p>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-user-doctor text-white text-xl"></i>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-bold text-white mb-2 counter" data-target="2">0</h3>
                        <p class="text-blue-100 font-medium">Doctors</p>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-heart text-white text-xl"></i>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-bold text-white mb-2 counter" data-target="500">0</h3>
                        <p class="text-blue-100 font-medium">Happy Patients</p>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-award text-white text-xl"></i>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-bold text-white mb-2 counter" data-target="15">0</h3>
                        <p class="text-blue-100 font-medium">Years of Experience</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-gradient-to-br from-indigo-700 to-blue-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Join Our Healthcare Family</h2>
            <p class="text-blue-100 max-w-3xl mx-auto mb-8">Experience the difference of personalized, compassionate healthcare at RSS Citi Health Services.</p>
            <button onclick="openRegisterModal()" class="px-8 py-3 rounded-lg bg-white text-indigo-700 font-semibold hover:bg-blue-50 transition">Schedule an Appointment</button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-md grid place-items-center">
                            <i class="fa-solid fa-wave-square text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold">RSS Citi Health Services</span>
                    </div>
                    <p class="text-gray-600 max-w-md">Providing quality healthcare services since 2005. Compassionate care and modern diagnostics for our community.</p>
                    <div class="mt-4 flex space-x-4 text-gray-600">
                        <a href="#" class="w-10 h-10 grid place-items-center rounded-lg bg-gray-200 hover:bg-blue-600 hover:text-white transition"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 grid place-items-center rounded-lg bg-gray-200 hover:bg-blue-600 hover:text-white transition"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="w-10 h-10 grid place-items-center rounded-lg bg-gray-200 hover:bg-blue-600 hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 grid place-items-center rounded-lg bg-gray-200 hover:bg-blue-600 hover:text-white transition"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Services</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-blue-600">Drug Testing</a></li>
                        <li><a href="#" class="hover:text-blue-600">Urine Analysis</a></li>
                        <li><a href="#" class="hover:text-blue-600">ECG</a></li>
                        <li><a href="#" class="hover:text-blue-600">X-Ray Services</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><i class="fa-solid fa-location-dot mr-2"></i>123 Health Avenue</li>
                        <li><i class="fa-solid fa-phone mr-2"></i>(123) 456-7890</li>
                        <li><i class="fa-regular fa-envelope mr-2"></i>rsscitihealthservices@gmail.com</li>
                        <li><i class="fa-regular fa-clock mr-2"></i>Mon-Sat: 8:00 AM - 6:00 PM</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
                <p class="text-gray-600 text-sm">&copy; 2024 RSS Citi Health Services. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0 text-sm text-gray-600">
                    <a href="#" class="hover:text-blue-600">Privacy Policy</a>
                    <a href="#" class="hover:text-blue-600">Terms of Service</a>
                    <a href="#" class="hover:text-blue-600">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Register Modal -->
    <div id="registerModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div id="registerContent" class="bg-white w-full max-w-lg rounded-2xl shadow-2xl transform transition duration-300 scale-95 opacity-0">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-t-2xl flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg grid place-items-center"><i class="fa-solid fa-user-plus"></i></div>
                    <h3 class="text-xl font-bold">Create your account</h3>
                </div>
                <button onclick="closeRegisterModal()" class="text-white/80 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <div class="p-6 space-y-6">
                <p class="text-gray-600">Choose how you want to register. You can switch to corporate during registration as well.</p>
                <div class="grid sm:grid-cols-2 gap-4">
                    <a href="<?php echo e(route('register')); ?>" class="block w-full text-center px-6 py-4 rounded-xl border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-semibold transition"><i class="fa-solid fa-user mr-2"></i> Individual</a>
                    <a href="<?php echo e(route('register')); ?>?corporate=1" class="block w-full text-center px-6 py-4 rounded-xl bg-blue-600 text-white hover:bg-blue-700 font-semibold transition"><i class="fa-solid fa-building mr-2"></i> Corporate</a>
                </div>
                <p class="text-xs text-gray-500">By continuing you agree to our Terms and Privacy Policy.</p>
            </div>
        </div>
    </div>

    <!-- Page Transition Element -->
    <div class="page-transition"></div>

    <script>
        function toggleMobileMenu(){ const m=document.getElementById('mobile-menu'); m.classList.toggle('hidden'); }
        function openRegisterModal(){ const m=document.getElementById('registerModal'); const c=document.getElementById('registerContent'); m.classList.remove('hidden'); m.classList.add('flex'); setTimeout(()=>{ c.classList.remove('scale-95','opacity-0'); c.classList.add('scale-100','opacity-100'); },10); }
        function closeRegisterModal(){ const m=document.getElementById('registerModal'); const c=document.getElementById('registerContent'); c.classList.remove('scale-100','opacity-100'); c.classList.add('scale-95','opacity-0'); setTimeout(()=>{ m.classList.add('hidden'); m.classList.remove('flex'); },300); }
        document.getElementById('registerModal').addEventListener('click',e=>{ if(e.target.id==='registerModal'){ closeRegisterModal(); }});
        document.addEventListener('keydown',e=>{ if(e.key==='Escape'){ closeRegisterModal(); }});

        // Counter animation
        function animateCounters() {
            const counters = document.querySelectorAll('.counter');
            const speed = 200;
            
            counters.forEach(counter => {
                const animate = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const increment = target / speed;
                    
                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment);
                        setTimeout(animate, 1);
                    } else {
                        counter.innerText = target;
                    }
                };
                animate();
            });
        }

        // Intersection Observer for counter animation
        function initStatsAnimation() {
            const statsSection = document.querySelector('section:has(.counter)');
            if (statsSection) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateCounters();
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.2 });
                observer.observe(statsSection);
            }
        }

        // Page transitions
        function initPageTransitions(){ const links=document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"]):not([onclick])'); links.forEach(link=>{ link.addEventListener('click',e=>{ if(link.hostname===window.location.hostname){ e.preventDefault(); const t=document.querySelector('.page-transition'); t.classList.add('active'); document.body.style.opacity='0.8'; setTimeout(()=>{ window.location.href=link.href; },300); } }); }); window.addEventListener('pageshow',()=>{ document.body.style.opacity='1'; document.querySelector('.page-transition').classList.remove('active'); }); }
        
        document.addEventListener('DOMContentLoaded',()=>{ 
            initPageTransitions(); 
            initStatsAnimation();
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\rss_new\resources\views/about.blade.php ENDPATH**/ ?>