<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RSS Citi Health Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <style>
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

        /* Custom animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 5px rgba(59, 130, 246, 0.5); }
            50% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.8), 0 0 30px rgba(59, 130, 246, 0.6); }
        }
        
        @keyframes slide-in {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-float { animation: float 2s ease-in-out infinite; }
        .animate-pulse-glow { animation: pulse-glow 2s infinite; }
        .animate-slide-in { animation: slide-in 0.6s ease-out; }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="bg-white/90 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center space-x-2 text-2xl font-bold text-blue-600 hover:text-blue-700 transition-colors duration-200">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-wave-square text-white text-base"></i>
                        </div>
                        <span class="hidden sm:block">RSS Citi Health Services</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="/" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200 relative group">
                            Home
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-200 group-hover:w-full"></span>
                        </a>
                        <a href="/about" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200 relative group">
                            About
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-200 group-hover:w-full"></span>
                        </a>
                        <a href="/service" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200 relative group">
                            Service
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-200 group-hover:w-full"></span>
                        </a>
                        <a href="/location" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200 relative group">
                            Location
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-200 group-hover:w-full"></span>
                        </a>
                    </div>
                </div>

                <!-- Auth Button -->
                <div class="hidden md:block">
                    <button onclick="openLoginModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Login
                    </button>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button onclick="toggleMobileMenu()" class="text-gray-700 hover:text-blue-600 focus:outline-none focus:text-blue-600 transition-colors duration-200">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="md:hidden hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-100">
                    <a href="/" class="text-gray-700 hover:text-blue-600 block px-3 py-2 text-base font-medium transition-colors duration-200">Home</a>
                    <a href="/about" class="text-gray-700 hover:text-blue-600 block px-3 py-2 text-base font-medium transition-colors duration-200">About</a>
                    <a href="/service" class="text-gray-700 hover:text-blue-600 block px-3 py-2 text-base font-medium transition-colors duration-200">Service</a>
                    <a href="/location" class="text-gray-700 hover:text-blue-600 block px-3 py-2 text-base font-medium transition-colors duration-200">Location</a>
                    <button onclick="openLoginModal()" class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-all duration-200">
                        Login
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-20 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%232563eb" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="animate-slide-in">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        <?php echo $loginContent['hero_title']->content_value ?? '<span class="text-blue-600">Faith</span> is being sure of what we <span class="text-indigo-600">hope</span> for, and certain of what we do not see.'; ?>

                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        <?php echo e($loginContent['hero_subtitle']->content_value ?? 'Welcome to RSS Citi Health Services, where compassionate care meets modern medicine. Your health and wellness are our top priorities.'); ?>

                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button onclick="openLoginModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            Get Started
                        </button>
                        <a href="/about" class="border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-200 text-center">
                            Learn More
                        </a>
                    </div>
                </div>
                
                <!-- Visual Element -->
                <div class="relative animate-float">
                    <div class="relative z-10">
                        <div class="w-full h-96 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-3xl shadow-2xl flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fa-solid fa-heart text-7xl mx-auto mb-4 opacity-80"></i>
                                <h3 class="text-2xl font-bold mb-2">Healthcare Excellence</h3>
                                <p class="text-lg opacity-90">Compassionate care for all</p>
                            </div>
                        </div>
                    </div>
                    <!-- Floating Elements -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-yellow-400 rounded-full opacity-80 animate-pulse"></div>
                    <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-green-400 rounded-full opacity-80 animate-pulse" style="animation-delay: 1s;"></div>
                </div>
            </div>
        </div>
    </section>

  <!-- Info Cards Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4"><?php echo e($loginContent['services_title']->content_value ?? 'Our Services'); ?></h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    <?php echo e($loginContent['services_subtitle']->content_value ?? 'Discover our comprehensive healthcare services designed to meet your needs'); ?>

                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Corporate Booking Card -->
                <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-700 rounded-bl-3xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">01</span>
                        </div>
                    
                    <div class="p-8">
                        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-200 transition-colors duration-300">
                            <i class="fa-solid fa-building text-blue-600 text-2xl"></i>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-4"><?php echo e($loginContent['corporate_title']->content_value ?? 'Corporate Booking'); ?></h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            <?php echo e($loginContent['corporate_description']->content_value ?? 'Schedule appointments for your entire organization with our corporate booking service. Special rates available for companies with more than 50 employees.'); ?>

                        </p>
                        
                        <a href="<?php echo e(route('register')); ?>?corporate=1" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200">
                            Learn More
                            <i class="fa-solid fa-arrow-right ml-2 transition-transform duration-200 group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
                
                <!-- RSS Daily Schedule Card -->
                <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-bl-3xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">02</span>
                        </div>
                    
                    <div class="p-8">
                        <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-200 transition-colors duration-300">
                            <i class="fa-regular fa-calendar text-indigo-600 text-2xl"></i>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">RSS Daily Schedule</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            View our daily schedule of activities, services, and special events. 
                            Morning prayers start at 6:00 AM, followed by regular services throughout the day.
                        </p>
                        
                        <a href="#" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-semibold transition-colors duration-200">
                            View Schedule
                            <i class="fa-solid fa-arrow-right ml-2 transition-transform duration-200 group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
                
                <!-- OPD Walk-in Card -->
                <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-bl-3xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">03</span>
                        </div>
                    
                    <div class="p-8">
                        <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-200 transition-colors duration-300">
                            <i class="fa-solid fa-user text-green-600 text-2xl"></i>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-4"><?php echo e($loginContent['opd_title']->content_value ?? 'OPD (Walk-in)'); ?></h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            <?php echo e($loginContent['opd_description']->content_value ?? 'Our Outpatient Department welcomes walk-in patients from 8:00 AM to 5:00 PM, Monday through Saturday. No appointment necessary for general consultations.'); ?>

                        </p>
                        
                        <a href="<?php echo e(route('register.opd')); ?>" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold transition-colors duration-200">
                            Register as OPD Patient
                            <i class="fa-solid fa-user-plus ml-2 transition-transform duration-200 group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 py-20 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">Our Impact</h2>
                <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                    Numbers that reflect our commitment to excellence in healthcare
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Services Stat -->
                <div class="text-center group">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-white/30 transition-colors duration-300">
                            <i class="fa-solid fa-wave-square text-white text-2xl"></i>
                        </div>
                        <h3 class="text-4xl md:text-5xl font-bold text-white mb-2 counter" data-target="10">0</h3>
                        <p class="text-blue-100 text-lg font-medium">Services</p>
                    </div>
                </div>
                
                <!-- Doctors Stat -->
                <div class="text-center group">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-white/30 transition-colors duration-300">
                            <i class="fa-solid fa-user-doctor text-white text-2xl"></i>
                        </div>
                        <h3 class="text-4xl md:text-5xl font-bold text-white mb-2 counter" data-target="2">0</h3>
                        <p class="text-blue-100 text-lg font-medium">Doctors</p>
                    </div>
                </div>
                
                <!-- Patients Stat -->
                <div class="text-center group">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-white/30 transition-colors duration-300">
                            <i class="fa-solid fa-heart text-white text-2xl"></i>
                        </div>
                        <h3 class="text-4xl md:text-5xl font-bold text-white mb-2 counter" data-target="500">0</h3>
                        <p class="text-blue-100 text-lg font-medium">Happy Patients</p>
                    </div>
                </div>
                
                <!-- Experience Stat -->
                <div class="text-center group">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-white/30 transition-colors duration-300">
                            <i class="fa-solid fa-award text-white text-2xl"></i>
                        </div>
                        <h3 class="text-4xl md:text-5xl font-bold text-white mb-2 counter" data-target="28">0</h3>
                        <p class="text-blue-100 text-lg font-medium">Years of Experience</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-right-to-bracket"></i>
                        </div>
                        <h3 class="text-xl font-bold">Login to Your Account</h3>
                    </div>
                    <button onclick="closeLoginModal()" class="text-white/80 hover:text-white transition-colors duration-200">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                    <?php if(session('error')): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <div class="flex items-center">
                            <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
                            <?php echo e(session('error')); ?>

                        </div>
                        </div>
                    <?php endif; ?>
                
                <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Email/Phone Field -->
                    <div>
                        <label for="login-email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email/Phone Number
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="login-email" 
                                   name="email" 
                                   value="<?php echo e(old('email')); ?>" 
                                   placeholder="Enter your email or phone" 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   required>
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                    <!-- Password Field -->
                    <div>
                        <label for="login-password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" 
                                   id="login-password" 
                                   name="password" 
                                   placeholder="Enter your password" 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   required>
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="remember" 
                               name="remember" 
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                        <label for="remember" class="ml-2 text-sm text-gray-700">
                            Remember me
                        </label>
                        </div>
                        
                    <!-- Login Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <div class="flex items-center justify-center">
                            <i class="fa-solid fa-unlock mr-2"></i>
                            Login
                        </div>
                    </button>
                    </form>
                    
                <!-- Registration Links -->
                <div class="mt-6 space-y-4 text-center">
                    <!-- General Registration -->
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-sm text-gray-600 mb-3 font-medium">
                            Don't have an account? Choose your registration type:
                        </p>
                        <div class="grid grid-cols-1 gap-3">
                            <!-- OPD Walk-in Registration -->
                            <a href="<?php echo e(route('register.opd')); ?>" class="group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-user text-sm"></i>
                                    </div>
                                    <div class="text-left">
                                        <div class="text-sm font-bold">OPD Walk-in Patient</div>
                                        <div class="text-xs opacity-90">Quick registration for walk-in services</div>
                                    </div>
                                </div>
                                <i class="fa-solid fa-arrow-right ml-2 transition-transform duration-200 group-hover:translate-x-1"></i>
                            </a>
                            
                            <!-- Corporate Registration -->
                            <a href="<?php echo e(route('register')); ?>?corporate=1" class="group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-building text-sm"></i>
                                    </div>
                                    <div class="text-left">
                                        <div class="text-sm font-bold">Corporate Client</div>
                                        <div class="text-xs opacity-90">For companies and organizations</div>
                                    </div>
                                </div>
                                <i class="fa-solid fa-arrow-right ml-2 transition-transform duration-200 group-hover:translate-x-1"></i>
                            </a>
                            
                            <!-- General Registration -->
                            <a href="<?php echo e(route('register')); ?>" class="group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-purple-500 to-violet-600 hover:from-purple-600 hover:to-violet-700 text-white rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-user-plus text-sm"></i>
                                    </div>
                                    <div class="text-left">
                                        <div class="text-sm font-bold">General Registration</div>
                                        <div class="text-xs opacity-90">Standard account registration</div>
                                    </div>
                                </div>
                                <i class="fa-solid fa-arrow-right ml-2 transition-transform duration-200 group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }
        
        // Login modal functions
        function openLoginModal() {
            const modal = document.getElementById('loginModal');
            const modalContent = document.getElementById('modalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Trigger animation
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function closeLoginModal() {
            const modal = document.getElementById('loginModal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }
        
        // Close modal when clicking outside
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLoginModal();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLoginModal();
            }
        });
            
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
        function initStatsAnimation() {
            const statsSection = document.querySelector('section:has(.counter)');
            if (statsSection) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Start counter animation
                            animateCounters();
                            
                            // Unobserve after animation is triggered
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.2 }); // Trigger when 20% of the section is visible
                
                observer.observe(statsSection);
            }
        }
        
        // Page transition functionality
        function initPageTransitions() {
            const navLinks = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"]):not([onclick])');
            
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
        }
        
        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initStatsAnimation();
            initPageTransitions();
        });
    </script>

    <!-- Footer Section -->
    <footer class="bg-gray-50 border-t border-gray-200">
        <!-- Main Footer Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-wave-square text-white"></i>
                        </div>
                        <span class="text-2xl font-bold text-gray-900">RSS Citi Health Services</span>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed max-w-md">
                        Providing quality healthcare services since 1997. Our mission is to deliver compassionate care and promote wellness in our community.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-200 hover:bg-blue-600 text-gray-600 hover:text-white rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-110">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-200 hover:bg-blue-600 text-gray-600 hover:text-white rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-110">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-200 hover:bg-blue-600 text-gray-600 hover:text-white rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-110">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-200 hover:bg-blue-600 text-gray-600 hover:text-white rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-110">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Departments -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Departments</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fa-solid fa-heart mr-2"></i>Cardiology
                        </a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fa-solid fa-brain mr-2"></i>Neurology
                        </a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fa-solid fa-bone mr-2"></i>Orthopedics
                        </a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fa-solid fa-baby mr-2"></i>Pediatrics
                        </a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Support</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fa-solid fa-phone mr-2"></i>Contact Us
                        </a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fa-regular fa-circle-question mr-2"></i>FAQs
                        </a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fa-solid fa-shield-halved mr-2"></i>Privacy Policy
                        </a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fa-regular fa-file-lines mr-2"></i>Terms of Service
                        </a></li>
                    </ul>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fa-regular fa-calendar mr-2"></i>Appointments
                        </a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fa-solid fa-user-doctor mr-2"></i>Doctors
                        </a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fa-solid fa-stethoscope mr-2"></i>Services
                        </a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fa-regular fa-star mr-2"></i>Testimonials
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Newsletter Subscription -->
        <div class="bg-white border-t border-gray-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Stay Updated</h3>
                    <p class="text-gray-600 mb-6">Subscribe to our newsletter for health tips and updates</p>
                    <div class="max-w-md mx-auto flex gap-3">
                        <input type="email" 
                               placeholder="Enter your email" 
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105">
                            Subscribe
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="bg-gray-100 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-600 text-sm">
                        &copy; 2024 RSS Citi Health Services. All rights reserved.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-600 hover:text-blue-600 text-sm transition-colors duration-200">Privacy Policy</a>
                        <a href="#" class="text-gray-600 hover:text-blue-600 text-sm transition-colors duration-200">Terms of Service</a>
                        <a href="#" class="text-gray-600 hover:text-blue-600 text-sm transition-colors duration-200">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Page Transition Element -->
    <div class="page-transition"></div>
    
    <!-- Company Pending Modal -->
    <?php if(session('company_pending')): ?>
    <div id="companyPendingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Company Account Under Review</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 mb-4">
                        Thank you for registering! Your company account is currently being processed by our administrators. 
                        You will receive an email notification once your account has been approved.
                    </p>
                    <p class="text-xs text-gray-400">
                        This process typically takes 1-2 business days.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button onclick="closeCompanyPendingModal()" 
                            class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        I Understand
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function closeCompanyPendingModal() {
            document.getElementById('companyPendingModal').style.display = 'none';
        }
        
        // Auto-show modal if session exists
        <?php if(session('company_pending')): ?>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('companyPendingModal').style.display = 'block';
            });
        <?php endif; ?>
    </script>
    <?php endif; ?>

    <!-- Account Rejected Modal -->
    <?php if(session('account_rejected')): ?>
    <div id="accountRejectedModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Account Access Denied</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 mb-4">
                        Your company account application has been reviewed and unfortunately cannot be approved at this time. 
                        Please contact our support team if you believe this is an error.
                    </p>
                    <p class="text-xs text-gray-400">
                        Support: rsscitihealthservices@gmail.com
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button onclick="closeAccountRejectedModal()" 
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                        I Understand
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function closeAccountRejectedModal() {
            document.getElementById('accountRejectedModal').style.display = 'none';
        }
        
        // Auto-show modal if session exists
        <?php if(session('account_rejected')): ?>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('accountRejectedModal').style.display = 'block';
            });
        <?php endif; ?>
    </script>
    <?php endif; ?>


</body>
</html><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/auth/login.blade.php ENDPATH**/ ?>