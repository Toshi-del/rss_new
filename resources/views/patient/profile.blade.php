<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile - RSS Citi Health Services</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-indigo: #4f46e5;
            --primary-indigo-dark: #4338ca;
            --primary-indigo-light: #a5b4fc;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        
        .content-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        
        .content-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .profile-gradient {
            background: linear-gradient(to right, #4f46e5, #4338ca) !important;
        }
        
        .nav-item {
            transition: all 0.3s ease;
            border-radius: 1rem;
        }
        
        .nav-item:hover {
            background-color: rgba(79, 70, 229, 0.1);
        }
        
        .nav-item.active {
            background-color: rgba(79, 70, 229, 0.15);
            color: var(--primary-indigo-dark);
            font-weight: 600;
        }
        
        .form-input {
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            ring-color: var(--primary-indigo);
            border-color: var(--primary-indigo);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-indigo);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-indigo-dark);
        }
    </style>
</head>
<body class="bg-slate-50 font-poppins min-h-screen flex flex-col">
    <!-- Modern Header -->
    <header class="bg-white/95 backdrop-blur-sm shadow-sm border-b border-indigo-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-injured text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Patient Portal</h1>
                        <p class="text-indigo-600 text-sm font-medium">RSS Citi Health Services</p>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('patient.dashboard') }}" class="nav-item px-4 py-2 text-gray-700">
                        <i class="fas fa-th-large mr-2"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('patient.profile') }}" class="nav-item px-4 py-2 text-gray-700 active">
                        <i class="fas fa-user-circle mr-2"></i>
                        <span class="font-medium">Profile</span>
                    </a>
                </nav>
                
                <!-- User Profile & Logout -->
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-3">
                        <div class="text-right">
                            <p class="font-semibold text-gray-800">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</p>
                            <p class="text-sm text-indigo-600">Patient</p>
                        </div>
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">
                                {{ substr(Auth::user()->fname, 0, 1) }}{{ substr(Auth::user()->lname, 0, 1) }}
                            </span>
                        </div>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                    
                    <!-- Mobile menu button -->
                    <button id="mobileMenuButton" class="md:hidden p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 flex items-center space-x-3">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif
        
        <!-- Profile Header -->
        <div class="content-card profile-gradient rounded-2xl p-8 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="w-24 h-24 bg-white/20 rounded-2xl flex items-center justify-center relative">
                        <span class="text-white text-3xl font-bold">
                            {{ substr(Auth::user()->fname, 0, 1) }}{{ substr(Auth::user()->lname, 0, 1) }}
                        </span>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-camera text-indigo-600 text-sm"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-2 text-white">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</h1>
                        <p class="text-white/90 text-lg">Manage your personal information and preferences</p>
                        <div class="mt-3">
                            <span class="bg-white/20 text-white text-sm px-3 py-1 rounded-full border border-white/30">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-right bg-white/10 rounded-2xl p-4">
                    <p class="text-white text-sm font-medium">Member Since</p>
                    <p class="text-2xl font-bold text-white">{{ Auth::user()->created_at->format('Y') }}</p>
                    <p class="text-white/80 text-sm">{{ Auth::user()->created_at->format('M d') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Profile Form -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Personal Information -->
            <div class="lg:col-span-2">
                <div class="content-card rounded-2xl p-8">
                    <div class="flex items-center space-x-3 mb-8">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-edit text-indigo-600 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Personal Information</h2>
                            <p class="text-gray-600">Update your personal details and contact information</p>
                        </div>
                    </div>
            
                    <form method="POST" action="{{ route('patient.profile.update') }}" class="space-y-8">
                        @csrf
                        @method('PUT')
                        
                        <!-- Name Fields -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Full Name</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-medium text-gray-700">
                                        <i class="fas fa-user text-indigo-500 mr-2"></i>First Name
                                    </label>
                                    <input type="text" name="fname" value="{{ Auth::user()->fname }}" 
                                           class="form-input w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                           placeholder="Enter your first name">
                                </div>
                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-medium text-gray-700">
                                        <i class="fas fa-user text-indigo-500 mr-2"></i>Last Name
                                    </label>
                                    <input type="text" name="lname" value="{{ Auth::user()->lname }}" 
                                           class="form-input w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                           placeholder="Enter your last name">
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="flex items-center text-sm font-medium text-gray-700">
                                        <i class="fas fa-user text-indigo-500 mr-2"></i>Middle Name
                                    </label>
                                    <input type="text" name="mname" value="{{ Auth::user()->mname }}" 
                                           class="form-input w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                           placeholder="Enter your middle name (optional)">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Contact Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-medium text-gray-700">
                                        <i class="fas fa-envelope text-indigo-500 mr-2"></i>Email Address
                                    </label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}" 
                                           class="form-input w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                           placeholder="Enter your email address">
                                </div>
                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-medium text-gray-700">
                                        <i class="fas fa-phone text-indigo-500 mr-2"></i>Phone Number
                                    </label>
                                    <input type="tel" name="phone" value="{{ Auth::user()->phone }}" 
                                           class="form-input w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                           placeholder="Enter your phone number">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Professional Information -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Professional Information</h3>
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700">
                                    <i class="fas fa-building text-indigo-500 mr-2"></i>Company/Organization
                                </label>
                                <input type="text" name="company" value="{{ Auth::user()->company }}" 
                                       class="form-input w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                       placeholder="Enter your company or organization">
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                            <button type="button" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors duration-200 font-medium">
                                <i class="fas fa-times mr-2"></i>Cancel Changes
                            </button>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                                <i class="fas fa-save mr-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Profile Sidebar -->
            <div class="space-y-6">
                <!-- Account Summary -->
                <div class="content-card rounded-2xl p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-shield-alt text-green-600 text-lg"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Account Summary</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar text-blue-500"></i>
                                <span class="text-sm font-medium text-gray-700">Member Since</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-800">{{ Auth::user()->created_at->format('M Y') }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-user-tag text-indigo-500"></i>
                                <span class="text-sm font-medium text-gray-700">Account Type</span>
                            </div>
                            <span class="text-sm font-semibold text-indigo-600">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span class="text-sm font-medium text-gray-700">Status</span>
                            </div>
                            <span class="text-sm font-semibold text-green-600">Active</span>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="content-card rounded-2xl p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-bolt text-purple-600 text-lg"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Quick Actions</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <button class="w-full flex items-center space-x-3 p-3 text-left hover:bg-gray-50 rounded-xl transition-colors duration-200">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-key text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Change Password</p>
                                <p class="text-xs text-gray-500">Update your account password</p>
                            </div>
                        </button>
                        
                        <button class="w-full flex items-center space-x-3 p-3 text-left hover:bg-gray-50 rounded-xl transition-colors duration-200">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-download text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Download Data</p>
                                <p class="text-xs text-gray-500">Export your medical records</p>
                            </div>
                        </button>
                        
                        <button class="w-full flex items-center space-x-3 p-3 text-left hover:bg-gray-50 rounded-xl transition-colors duration-200">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-bell text-orange-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Notifications</p>
                                <p class="text-xs text-gray-500">Manage your preferences</p>
                            </div>
                        </button>
                    </div>
                </div>
                
                <!-- Security Tips -->
                <div class="content-card rounded-2xl p-6 bg-gradient-to-br from-yellow-50 to-orange-50 border border-yellow-200">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-lightbulb text-yellow-600 text-lg"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Security Tips</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <p class="text-gray-700">Use a strong, unique password</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <p class="text-gray-700">Keep your contact info updated</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <p class="text-gray-700">Review your account regularly</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Modern Footer -->
    <footer class="bg-white border-t border-gray-200 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-injured text-white text-sm"></i>
                        </div>
                        <span class="font-bold text-gray-800">RSS Citi Health Services</span>
                    </div>
                    <p class="text-gray-600 text-sm">&copy; {{ date('Y') }} RSS Citi Health Services. All rights reserved.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-indigo-100 rounded-lg flex items-center justify-center text-gray-500 hover:text-indigo-600 transition-all duration-200">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-indigo-100 rounded-lg flex items-center justify-center text-gray-500 hover:text-indigo-600 transition-all duration-200">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-indigo-100 rounded-lg flex items-center justify-center text-gray-500 hover:text-indigo-600 transition-all duration-200">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-indigo-100 rounded-lg flex items-center justify-center text-gray-500 hover:text-indigo-600 transition-all duration-200">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced navigation interactions
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('active')) {
                        this.style.backgroundColor = 'rgba(79, 70, 229, 0.1)';
                    }
                });

                item.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active')) {
                        this.style.backgroundColor = '';
                    }
                });
            });

            // Form input enhancements
            document.querySelectorAll('.form-input').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });

            // Auto-hide success messages
            setTimeout(function() {
                const alerts = document.querySelectorAll('.bg-green-50');
                alerts.forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 500);
                });
            }, 5000);

            // Form validation feedback
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
                    submitBtn.disabled = true;
                });
            }

            // Quick action buttons
            document.querySelectorAll('button[class*="w-full flex items-center"]').forEach(button => {
                button.addEventListener('click', function() {
                    // Add visual feedback
                    this.style.backgroundColor = 'rgba(79, 70, 229, 0.1)';
                    setTimeout(() => {
                        this.style.backgroundColor = '';
                    }, 200);
                });
            });

            console.log('Patient profile initialized with modern interactions');
        });
    </script>
</body>
</html> 