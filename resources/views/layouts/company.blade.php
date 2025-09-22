<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Company Portal') - RSS Citi Health Services</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .glass-sidebar {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(37, 99, 235, 0.25));
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .nav-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }
        
        .nav-item:hover::before {
            left: 100%;
        }
        
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }
        
        .nav-item.active {
            background: rgba(59, 130, 246, 0.2);
            border-right: 3px solid #3b82f6;
            color: #3b82f6;
        }
        
        .nav-section {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
            padding-bottom: 1rem;
        }
        
        .nav-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .nav-section-title {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            padding: 0 1rem;
        }
        
        .notification-badge {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .search-bar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .search-bar:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .profile-modal {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .modal-active .glass-sidebar {
            filter: blur(2px);
        }
        
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .mobile-menu-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        
        @media (max-width: 768px) {
            .glass-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .glass-sidebar.mobile-open {
                transform: translateX(0);
            }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen">
    @auth
    <!-- Mobile Menu Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 mobile-menu-overlay z-40 hidden md:hidden"></div>
    
    <div class="flex h-screen overflow-hidden">
        <!-- Glass Morphism Sidebar -->
        <aside id="sidebar" class="glass-sidebar fixed md:relative w-80 h-full z-50 shadow-2xl">
            <!-- Logo Area -->
            <div class="p-6 border-b border-white/10">
                <a href="{{ route('company.dashboard') }}" class="flex items-center space-x-4 text-white group">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20 group-hover:bg-white/20 transition-all duration-300">
                        <i class="fas fa-building text-xl"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold">Company Portal</span>
                        <p class="text-xs text-white/70 mt-1">RSS Citi Health Services</p>
                    </div>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="p-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-white/50"></i>
                    </div>
                    <input type="text" 
                           placeholder="Search employees..." 
                           class="search-bar w-full pl-10 pr-4 py-3 rounded-xl text-white placeholder-white/50 focus:outline-none">
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="px-4 pb-20 overflow-y-auto">
                <!-- Main Menu Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Main Menu</div>
                    <a href="{{ route('company.dashboard') }}" 
                       class="nav-item flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white mb-2 {{ request()->routeIs('company.dashboard') ? 'active' : '' }}">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <i class="fas fa-chart-line text-lg"></i>
                        </div>
                        <span class="ml-3 font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('company.appointments.index') }}" 
                       class="nav-item flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white mb-2 {{ request()->routeIs('company.appointments.*') ? 'active' : '' }}">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <i class="fas fa-calendar-check text-lg"></i>
                        </div>
                        <span class="ml-3 font-medium">Appointments</span>
                        <div class="ml-auto">
                            <span class="notification-badge w-2 h-2 rounded-full"></span>
                        </div>
                    </a>

                    <a href="{{ route('company.pre-employment.index') }}"
                       class="nav-item flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white mb-2 {{ request()->routeIs('company.pre-employment.*') ? 'active' : '' }}">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <i class="fas fa-briefcase text-lg"></i>
                        </div>
                        <span class="ml-3 font-medium">Pre-Employment</span>
                    </a>

                    <a href="{{ route('company.medical-results') }}" 
                       class="nav-item flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white mb-2 {{ request()->routeIs('company.medical-results*') ? 'active' : '' }}">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <i class="fas fa-file-medical text-lg"></i>
                        </div>
                        <span class="ml-3 font-medium">Medical Results</span>
                    </a>
                </div>

                <!-- Employee Management Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Employee Management</div>
                    <a href="{{ route('company.account-invitations.index') }}" 
                       class="nav-item flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white mb-2 {{ request()->routeIs('company.account-invitations*') ? 'active' : '' }}">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <i class="fas fa-user-plus text-lg"></i>
                        </div>
                        <span class="ml-3 font-medium">Account Invitations</span>
                    </a>
                </div>

                <!-- Communication Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Communication</div>
                    <a href="{{ route('company.messages') }}" 
                       class="nav-item flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white mb-2 {{ request()->routeIs('company.messages') ? 'active' : '' }}">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <i class="fas fa-comments text-lg"></i>
                        </div>
                        <span class="ml-3 font-medium">Messages</span>
                        <div class="ml-auto">
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">3</span>
                        </div>
                    </a>

                    <a href="{{ route('company.settings') }}" 
                       class="nav-item flex items-center px-4 py-3 rounded-xl text-white/80 hover:text-white mb-2 {{ request()->routeIs('company.settings*') ? 'active' : '' }}">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <i class="fas fa-cog text-lg"></i>
                        </div>
                        <span class="ml-3 font-medium">Settings</span>
                    </a>
                </div>
            </nav>

            <!-- User Profile -->
            <div class="absolute bottom-0 w-full p-4 border-t border-white/10">
                <div class="flex items-center space-x-3 p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                        {{ substr(Auth::user()->full_name ?? 'C', 0, 1) }}
                    </div>
                    <div class="flex-1 text-white">
                        <p class="text-sm font-semibold">{{ Auth::user()->full_name ?? 'Company Admin' }}</p>
                        <p class="text-xs text-white/70">Company Administrator</p>
                    </div>
                    <div class="relative">
                        <button id="profile-menu-btn" class="text-white/70 hover:text-white p-2 rounded-lg hover:bg-white/10 transition-colors">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        
                        <!-- Profile Dropdown -->
                        <div id="profile-dropdown" class="profile-modal absolute bottom-full right-0 mb-2 w-48 rounded-xl shadow-xl border hidden animate-slide-in">
                            <div class="p-2">
                                <a href="#" class="flex items-center px-3 py-2 text-gray-700 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i class="fas fa-user-circle mr-3"></i>
                                    Profile Settings
                                </a>
                                <a href="#" class="flex items-center px-3 py-2 text-gray-700 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i class="fas fa-bell mr-3"></i>
                                    Notifications
                                </a>
                                <hr class="my-2 border-gray-200">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden md:ml-0">
            <!-- Top Header Bar -->
            <header class="content-card shadow-lg border-b border-white/20 backdrop-blur-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <!-- Mobile Menu Button -->
                        <button id="mobile-menu-btn" class="md:hidden text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Company Dashboard')</h1>
                            <p class="text-sm text-gray-600 mt-1">@yield('page-description', 'Manage your company\'s medical examinations and employee health records')</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-3 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-colors">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                        </button>
                        
                        <!-- Current Time -->
                        <div class="hidden md:block text-right">
                            <div class="text-sm font-medium text-gray-900" id="current-time"></div>
                            <div class="text-xs text-gray-500">Current Time</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gradient-to-br from-slate-50/50 via-blue-50/50 to-indigo-100/50 p-6">
                @yield('content')
            </main>
        </div>
    </div>
    @endauth

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu functionality
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobile-overlay');
            
            if (mobileMenuBtn && sidebar && mobileOverlay) {
                mobileMenuBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('mobile-open');
                    mobileOverlay.classList.toggle('hidden');
                    document.body.classList.toggle('modal-active');
                });
                
                mobileOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-open');
                    mobileOverlay.classList.add('hidden');
                    document.body.classList.remove('modal-active');
                });
            }
            
            // Profile dropdown functionality
            const profileMenuBtn = document.getElementById('profile-menu-btn');
            const profileDropdown = document.getElementById('profile-dropdown');
            
            if (profileMenuBtn && profileDropdown) {
                profileMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                });
                
                document.addEventListener('click', function() {
                    profileDropdown.classList.add('hidden');
                });
                
                profileDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
            
            // Update current time
            function updateTime() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('en-US', { 
                    hour: 'numeric', 
                    minute: '2-digit',
                    hour12: true 
                });
                const timeElement = document.getElementById('current-time');
                if (timeElement) {
                    timeElement.textContent = timeString;
                }
            }
            
            // Update time immediately and then every minute
            updateTime();
            setInterval(updateTime, 60000);
            
            // Add smooth animations to navigation items
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
                item.classList.add('animate-slide-in');
            });
            
            // Search functionality
            const searchInput = document.querySelector('.search-bar');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const query = e.target.value.toLowerCase();
                    // Add search functionality here if needed
                    console.log('Searching for:', query);
                });
            }
            
            // Notification click handler
            const notificationBtn = document.querySelector('button[class*="fas fa-bell"]');
            if (notificationBtn) {
                notificationBtn.addEventListener('click', function() {
                    // Add notification panel functionality here
                    console.log('Notifications clicked');
                });
            }
        });
    </script>
</body>
</html> 