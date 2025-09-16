<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - RSS Citi Health Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .page-transition { position: fixed; inset: 0; background-color: #ffffff; z-index: 50; opacity: 0; pointer-events: none; transition: opacity .3s ease-in-out; }
        .page-transition.active { opacity: .5; pointer-events: all; }
        @keyframes float { 0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)} }
        .animate-float { animation: float 3s ease-in-out infinite; }
        @keyframes slide-in { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .service-card { animation: slide-in 0.6s ease-out; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .service-card:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .service-card:hover .service-icon { animation: float 2s ease-in-out infinite; }
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
                    <a href="/about" class="relative group text-gray-700 hover:text-blue-600 transition-colors">About<span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span></a>
                    <a href="/services" class="relative group text-blue-700 font-semibold">Services<span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-700"></span></a>
                    <a href="/location" class="relative group text-gray-700 hover:text-blue-600 transition-colors">Location<span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span></a>
                </div>

                <div class="hidden md:block">
                    <button onclick="openLoginModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition-all transform hover:scale-105 shadow">
                        Login
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
                    <a href="/about" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">About</a>
                    <a href="/services" class="block px-3 py-2 rounded-lg text-blue-700 bg-blue-50">Services</a>
                    <a href="/location" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Location</a>
                    <button onclick="openLoginModal()" class="w-full px-3 py-2 rounded-lg bg-blue-600 text-white">Login</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        <div class="absolute inset-0 pointer-events-none opacity-10" style="background-image:url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%232563eb\" fill-opacity=\"0.15\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 mb-6">Our Medical Services</h1>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">We provide a comprehensive range of diagnostic and preventive healthcare services to ensure your well-being. From routine check-ups to specialized testing, our state-of-the-art facility delivers accurate results with compassionate care.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#services" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                            View All Services
                            <i class="fa-solid fa-arrow-down ml-2"></i>
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                            Book Appointment
                            <i class="fa-solid fa-calendar-plus ml-2"></i>
                        </a>
                    </div>
                </div>
                <div class="relative animate-float">
                    <div class="w-full h-72 sm:h-96 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-3xl shadow-2xl grid place-items-center text-white">
                        <div class="text-center">
                            <i class="fa-solid fa-stethoscope text-6xl opacity-90"></i>
                            <h3 class="mt-4 text-2xl font-semibold">Quality Healthcare</h3>
                            <p class="mt-2 text-blue-100">Comprehensive Medical Services</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Medical Services</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Comprehensive diagnostic and preventive healthcare services delivered with precision and care</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Drug Test Service -->
                <div class="service-card bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-blue-100 text-blue-600 grid place-items-center service-icon">
                        <i class="fa-solid fa-pills text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Drug Testing</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Comprehensive drug screening services for pre-employment, random testing, and medical purposes. Our laboratory provides accurate results with quick turnaround times.
                    </p>
                    <a href="{{ route('register') }}?corporate=1" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                        Learn More
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- CBC Service -->
                <div class="service-card bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-blue-100 text-blue-600 grid place-items-center service-icon">
                        <i class="fa-solid fa-tint text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Complete Blood Count (CBC)</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Evaluates overall health and detects a wide range of disorders including anemia, infection, and leukemia through comprehensive blood analysis.
                    </p>
                    <a href="{{ route('register') }}?corporate=1" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                        Learn More
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Hematology Service -->
                <div class="service-card bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-blue-100 text-blue-600 grid place-items-center service-icon">
                        <i class="fa-solid fa-microscope text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Hematology</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Specialized blood testing to diagnose blood disorders, assess blood cell production, and monitor blood-related conditions with precision and accuracy.
                    </p>
                    <a href="{{ route('register') }}?corporate=1" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                        Learn More
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Urine Analysis Service -->
                <div class="service-card bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-blue-100 text-blue-600 grid place-items-center service-icon">
                        <i class="fa-solid fa-flask text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Urine Analysis</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Complete urinalysis to detect various conditions including urinary tract infections, kidney disease, diabetes, and liver problems.
                    </p>
                    <a href="{{ route('register') }}?corporate=1" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                        Learn More
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Stool Test Service -->
                <div class="service-card bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-blue-100 text-blue-600 grid place-items-center service-icon">
                        <i class="fa-solid fa-clipboard-list text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Stool Examination</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Stool analysis for detecting digestive disorders, parasitic infections, and screening for colorectal cancer through occult blood testing.
                    </p>
                    <a href="{{ route('register') }}?corporate=1" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                        Learn More
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- ECG Service -->
                <div class="service-card bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-blue-100 text-blue-600 grid place-items-center service-icon">
                        <i class="fa-solid fa-heart-pulse text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Electrocardiogram (ECG)</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Non-invasive test that records the electrical activity of your heart to detect heart problems and monitor heart health.
                    </p>
                    <a href="{{ route('register') }}?corporate=1" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                        Learn More
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- X-Ray Service -->
                <div class="service-card bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-blue-100 text-blue-600 grid place-items-center service-icon">
                        <i class="fa-solid fa-x-ray text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">X-Ray Imaging</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Advanced X-ray imaging services for diagnosing bone fractures, lung conditions, and other internal issues with minimal radiation exposure.
                    </p>
                    <a href="{{ route('register') }}?corporate=1" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                        Learn More
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Vision Test Service -->
                <div class="service-card bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-blue-100 text-blue-600 grid place-items-center service-icon">
                        <i class="fa-solid fa-eye text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Vision Testing</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Comprehensive eye examinations to assess visual acuity, detect vision problems, and screen for eye diseases such as glaucoma and cataracts.
                    </p>
                    <a href="{{ route('register') }}?corporate=1" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                        Learn More
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Blood Pressure Service -->
                <div class="service-card bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-blue-100 text-blue-600 grid place-items-center service-icon">
                        <i class="fa-solid fa-heartbeat text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Blood Pressure Monitoring</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Regular blood pressure checks to monitor cardiovascular health, detect hypertension early, and prevent related health complications.
                    </p>
                    <a href="{{ route('register') }}?corporate=1" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                        Learn More
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-16 bg-gradient-to-br from-indigo-700 to-blue-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Schedule Your Appointment?</h2>
            <p class="text-blue-100 max-w-3xl mx-auto mb-8">Our team of healthcare professionals is ready to provide you with the best care possible. Book your appointment today and take the first step towards better health.</p>
            <div class="flex justify-center">
                <a href="{{ route('register') }}" class="px-8 py-3 rounded-lg bg-white text-indigo-700 font-semibold hover:bg-blue-50 transition">
                    <i class="fa-solid fa-calendar-plus mr-2"></i>
                    Book Appointment
                </a>
            </div>
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
                    <p class="text-gray-600 max-w-md mb-4">Providing quality healthcare services since 2005. Compassionate care and modern diagnostics for our community.</p>
                    <div class="flex space-x-4 text-gray-600">
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
                        <li><a href="#" class="hover:text-blue-600">Blood Tests</a></li>
                            </ul>
                        </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="/" class="hover:text-blue-600">Home</a></li>
                        <li><a href="/about" class="hover:text-blue-600">About Us</a></li>
                        <li><a href="/services" class="hover:text-blue-600">Services</a></li>
                        <li><a href="/location" class="hover:text-blue-600">Location</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-blue-600">Register</a></li>
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

   <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div id="loginContent" class="bg-white w-full max-w-md rounded-2xl shadow-2xl transform transition duration-300 scale-95 opacity-0">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-t-2xl flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg grid place-items-center"><i class="fa-solid fa-sign-in-alt"></i></div>
                    <h3 class="text-xl font-bold">Login to Your Account</h3>
                </div>
                <button onclick="closeLoginModal()" class="text-white/80 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <div class="p-6">
                    @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-800 text-sm flex items-center">
                            <i class="fa-solid fa-circle-exclamation mr-2"></i>
                            {{ session('error') }}
                        </p>
                        </div>
                    @endif
                    
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                    <div>
                        <label for="login-email" class="block text-sm font-semibold text-gray-700 mb-2">Email/Phone Number</label>
                        <div class="relative">
                            <input type="text" name="email" id="login-email" value="{{ old('email') }}" required 
                                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                                   placeholder="Enter your email or phone">
                            <i class="fa-solid fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        
                    <div>
                        <label for="login-password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="login-password" required 
                                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                                   placeholder="Enter your password">
                            <i class="fa-solid fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fa-solid fa-sign-in-alt mr-2"></i>
                        Login
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                            Sign up
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Page Transition Element -->
    <div class="page-transition"></div>
    
    <script>
        function toggleMobileMenu(){ const m=document.getElementById('mobile-menu'); m.classList.toggle('hidden'); }
        function openLoginModal(){ const m=document.getElementById('loginModal'); const c=document.getElementById('loginContent'); m.classList.remove('hidden'); m.classList.add('flex'); setTimeout(()=>{ c.classList.remove('scale-95','opacity-0'); c.classList.add('scale-100','opacity-100'); },10); }
        function closeLoginModal(){ const m=document.getElementById('loginModal'); const c=document.getElementById('loginContent'); c.classList.remove('scale-100','opacity-100'); c.classList.add('scale-95','opacity-0'); setTimeout(()=>{ m.classList.add('hidden'); m.classList.remove('flex'); },300); }
        document.getElementById('loginModal').addEventListener('click',e=>{ if(e.target.id==='loginModal'){ closeLoginModal(); }});
        document.addEventListener('keydown',e=>{ if(e.key==='Escape'){ closeLoginModal(); }});

        // Page transitions
        function initPageTransitions(){ 
            const links=document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"]):not([onclick])'); 
            links.forEach(link=>{ 
                link.addEventListener('click',e=>{ 
                    if(link.hostname===window.location.hostname){ 
                        e.preventDefault(); 
                        const t=document.querySelector('.page-transition'); 
                        t.classList.add('active'); 
                        document.body.style.opacity='0.8'; 
                        setTimeout(()=>{ window.location.href=link.href; },300); 
                    } 
                }); 
            }); 
            window.addEventListener('pageshow',()=>{ 
                document.body.style.opacity='1'; 
                document.querySelector('.page-transition').classList.remove('active'); 
            }); 
        }
        
        document.addEventListener('DOMContentLoaded',()=>{ 
            initPageTransitions(); 
        });
    </script>
</body>
</html>
