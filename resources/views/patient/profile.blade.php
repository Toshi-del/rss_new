<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile - RSS Citi Health Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    },
                    animation: {
                        'fadeIn': 'fadeIn 0.5s ease-in-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: 0 },
                            '100%': { opacity: 1 },
                        }
                    },
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }
        
        .nav-hover-effect {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #4f46e5;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-white to-gray-50 shadow-sm py-4">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <a href="#" class="text-xl font-semibold text-primary-600 tracking-wide">
                    <i class="bi bi-activity me-2"></i>RSS Citi Health Services
                </a>
                <button id="mobileMenuButton" class="md:hidden text-gray-500 hover:text-primary-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <div id="navbarMenu" class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('patient.dashboard') }}" class="nav-link px-3 py-2 rounded-md text-gray-700 font-medium hover:text-primary-600 relative">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        <span class="nav-hover-effect"></span>
                    </a>
                    <a href="{{ route('patient.profile') }}" class="nav-link px-3 py-2 rounded-md text-primary-600 font-medium relative">
                        <i class="bi bi-person-circle me-1"></i> Profile
                        <span class="nav-hover-effect" style="width: 80%;"></span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="nav-link px-3 py-2 rounded-md text-gray-700 font-medium hover:text-primary-600 relative">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                            <span class="nav-hover-effect"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-6">
        @if(session('success'))
            <div id="successAlert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md relative animate-[fadeIn_0.5s_ease-in-out]" role="alert">
                <div class="flex items-center">
                    <i class="bi bi-check-circle-fill mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="absolute top-0 right-0 mt-4 mr-4" onclick="document.getElementById('successAlert').remove()">
                    <svg class="h-4 w-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif
        
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row items-start md:items-center mb-6">
                <div class="w-20 h-20 bg-primary-50 rounded-full flex items-center justify-center text-primary-600 text-3xl mr-6 mb-4 md:mb-0">
                    <i class="bi bi-person"></i>
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-primary-800 mb-1">Profile Information</h4>
                    <p class="text-gray-600">
                        <span class="bg-primary-600 text-white text-xs px-2 py-1 rounded-md">{{ ucfirst(Auth::user()->role) }}</span>
                    </p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('patient.profile.update') }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-gray-500 mb-1 block"><i class="bi bi-person me-2"></i>First Name</label>
                        <input type="text" name="fname" value="{{ Auth::user()->fname }}" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 mb-1 block"><i class="bi bi-person me-2"></i>Last Name</label>
                        <input type="text" name="lname" value="{{ Auth::user()->lname }}" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 mb-1 block"><i class="bi bi-person me-2"></i>Middle Name</label>
                        <input type="text" name="mname" value="{{ Auth::user()->mname }}" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 mb-1 block"><i class="bi bi-envelope me-2"></i>Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 mb-1 block"><i class="bi bi-telephone me-2"></i>Phone</label>
                        <input type="tel" name="phone" value="{{ Auth::user()->phone }}" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 mb-1 block"><i class="bi bi-building me-2"></i>Company</label>
                        <input type="text" name="company" value="{{ Auth::user()->company }}" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <button type="button" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors">
                        <i class="bi bi-check-circle me-2"></i>Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-white py-6 mt-auto">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-600 text-sm">&copy; 2023 RSS Citi Health Services. All rights reserved.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors duration-300">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors duration-300">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors duration-300">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors duration-300">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            const menu = document.getElementById('navbarMenu');
            menu.classList.toggle('hidden');
        });
        
        // Hover effect for nav links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.querySelector('.nav-hover-effect').style.width = '80%';
            });
            
            link.addEventListener('mouseleave', function() {
                this.querySelector('.nav-hover-effect').style.width = '0';
            });
        });
        
        // Auto-hide success alert after 5 seconds
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.classList.add('opacity-0');
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }, 5000);
        }
    </script>
</body>
</html> 