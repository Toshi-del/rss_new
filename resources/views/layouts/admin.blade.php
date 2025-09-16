<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - RSS Citi Health Services')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #059669;
            --accent-color: #d97706;
            --info-color: #0891b2;
            --warning-color: #ca8a04;
            --danger-color: #dc2626;
            --success-color: #16a34a;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #1f2937;
            min-height: 100vh;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        
        .sidebar-glass {
            background: rgba(31, 41, 55, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .nav-item {
            transition: all 0.2s ease;
        }
        
        .nav-item:hover {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
        }
        
        .nav-item.active {
            background: var(--primary-color);
            box-shadow: 0 2px 8px rgba(31, 41, 55, 0.3);
        }
        
        .stat-card {
            transition: all 0.2s ease;
        }
        
        .content-card {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }
        
        .glass-morphism {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .gradient-text {
            color: var(--primary-color);
        }
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
    </style>
    @stack('styles')
</head>
<body class="h-full overflow-hidden">
    <div class="flex h-full">
        <!-- Mobile sidebar overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm transition-all duration-500 opacity-0 pointer-events-none lg:hidden"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 sidebar-glass transform -translate-x-full transition-all duration-500 ease-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col custom-scrollbar">
            <!-- Sidebar header -->
            <div class="flex items-center justify-between h-20 px-6 border-b border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-2xl glass-morphism flex items-center justify-center floating-icon">
                        <i class="fas fa-heartbeat text-white text-xl"></i>
                    </div>
                    <div>
                        <span class="text-white font-bold text-lg gradient-text">RSS Citi Health</span>
                        <p class="text-white/60 text-xs font-medium">Admin Portal</p>
                    </div>
                </div>
                <button id="sidebar-close" class="lg:hidden text-white/80 hover:text-white glass-morphism p-2 rounded-xl transition-all duration-300 hover:scale-110">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto custom-scrollbar">
                <div class="text-white/40 text-xs font-semibold uppercase tracking-wider px-4 mb-4">Main Menu</div>
                
                <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center px-4 py-4 text-white/90 rounded-2xl font-medium {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt text-lg mr-4 floating-icon"></i>
                    <span>Dashboard</span>
                    <i class="fas fa-chevron-right ml-auto text-xs opacity-60"></i>
                </a>
                
                <a href="{{ route('admin.patients') }}" class="nav-item flex items-center px-4 py-4 text-white/90 rounded-2xl font-medium {{ request()->routeIs('admin.patients*') ? 'active' : '' }}">
                    <i class="fas fa-users text-lg mr-4"></i>
                    <span>Patients</span>
                    <i class="fas fa-chevron-right ml-auto text-xs opacity-60"></i>
                </a>
                
                <a href="{{ route('admin.appointments') }}" class="nav-item flex items-center px-4 py-4 text-white/90 rounded-2xl font-medium {{ request()->routeIs('admin.appointments*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check text-lg mr-4"></i>
                    <span>Appointments</span>
                    <i class="fas fa-chevron-right ml-auto text-xs opacity-60"></i>
                </a>
                
                <a href="{{ route('admin.pre-employment') }}" class="nav-item flex items-center px-4 py-4 text-white/90 rounded-2xl font-medium {{ request()->routeIs('admin.pre-employment*') ? 'active' : '' }}">
                    <i class="fas fa-file-medical text-lg mr-4"></i>
                    <span>Pre-Employment</span>
                    <i class="fas fa-chevron-right ml-auto text-xs opacity-60"></i>
                </a>
                
                <a href="{{ route('admin.tests') }}" class="nav-item flex items-center px-4 py-4 text-white/90 rounded-2xl font-medium {{ request()->routeIs('admin.tests*') ? 'active' : '' }}">
                    <i class="fas fa-vial text-lg mr-4"></i>
                    <span>Medical Tests</span>
                    <i class="fas fa-chevron-right ml-auto text-xs opacity-60"></i>
                </a>
                
                <a href="{{ route('medical-test-categories.index') }}" class="nav-item flex items-center px-4 py-4 text-white/90 rounded-2xl font-medium {{ request()->routeIs('medical-test-categories*') ? 'active' : '' }}">
                    <i class="fas fa-list-alt text-lg mr-4"></i>
                    <span>Test Categories</span>
                    <i class="fas fa-chevron-right ml-auto text-xs opacity-60"></i>
                </a>
<<<<<<< Updated upstream
                
                <div class="text-white/40 text-xs font-semibold uppercase tracking-wider px-4 mt-8 mb-4">Communication</div>
                
                <a href="{{ route('admin.messages') }}" class="nav-item flex items-center px-4 py-4 text-white/90 rounded-2xl font-medium {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
                    <i class="fas fa-comments text-lg mr-4"></i>
=======
            </li>
            <li class="sidebar-item">
                <a href="{{ route('inventory.index') }}" class="sidebar-link {{ request()->routeIs('inventory*') ? 'active' : '' }}">
                    <i class="bi bi-boxes"></i>
                    <span>Inventory</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.messages') }}" class="sidebar-link {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots"></i>
>>>>>>> Stashed changes
                    <span>Messages</span>
                    <div class="ml-auto flex items-center space-x-2">
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">3</span>
                        <i class="fas fa-chevron-right text-xs opacity-60"></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.report') }}" class="nav-item flex items-center px-4 py-4 text-white/90 rounded-2xl font-medium {{ request()->routeIs('admin.report*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line text-lg mr-4"></i>
                    <span>Reports</span>
                    <i class="fas fa-chevron-right ml-auto text-xs opacity-60"></i>
                </a>
                
                <div class="text-white/40 text-xs font-semibold uppercase tracking-wider px-4 mt-8 mb-4">Management</div>
                
                <a href="{{ route('admin.accounts-and-patients') }}" class="nav-item flex items-center px-4 py-4 text-white/90 rounded-2xl font-medium {{ request()->routeIs('admin.accounts-and-patients') ? 'active' : '' }}">
                    <i class="fas fa-building text-lg mr-4"></i>
                    <span>Company Accounts</span>
                    <i class="fas fa-chevron-right ml-auto text-xs opacity-60"></i>
                </a>
                
                <a href="{{ route('admin.opd', ['filter' => request('filter','pending')]) }}" class="nav-item flex items-center px-4 py-4 text-white/90 rounded-2xl font-medium {{ request()->routeIs('admin.opd*') ? 'active' : '' }}">
                    <i class="fas fa-hospital text-lg mr-4"></i>
                    <span>OPD Entries</span>
                    <i class="fas fa-chevron-right ml-auto text-xs opacity-60"></i>
                </a>
                
                <a href="{{ route('admin.medical-staff') }}" class="nav-item flex items-center px-4 py-4 text-white/90 rounded-2xl font-medium {{ request()->routeIs('admin.medical-staff*') ? 'active' : '' }}">
                    <i class="fas fa-user-md text-lg mr-4"></i>
                    <span>Medical Staff</span>
                    <i class="fas fa-chevron-right ml-auto text-xs opacity-60"></i>
                </a>
            </nav>
            
            <!-- User profile section -->
            <div class="p-6 border-t border-white/10">
                <div class="glass-morphism rounded-2xl p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-2xl bg-purple-500 flex items-center justify-center text-white font-bold text-lg pulse-icon">
                            {{ substr(Auth::user()->fname ?? 'A', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-semibold text-sm truncate">
                                {{ Auth::user()->fname ?? 'Admin' }} {{ Auth::user()->lname ?? 'User' }}
                            </p>
                            <p class="text-white/60 text-xs">System Administrator</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-white/80 hover:text-white glass-morphism p-2 rounded-xl transition-all duration-300 hover:scale-110">
                                <i class="fas fa-sign-out-alt text-lg"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top header -->
            <header class="glass-morphism border-b border-white/20 backdrop-blur-xl">
                <div class="flex items-center justify-between px-6 py-5">
                    <div class="flex items-center space-x-4">
                        <button id="sidebar-toggle" class="lg:hidden text-white/80 hover:text-white glass-morphism p-3 rounded-2xl transition-all duration-300 hover:scale-110">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div>
                            <h1 class="text-2xl font-bold text-white">
                                @yield('page-title', 'Dashboard')
                            </h1>
                            <p class="text-white/60 text-sm font-medium">Welcome back, {{ Auth::user()->fname ?? 'Admin' }}!</p>
                        </div>
                    </div>
                    
                    <!-- Header actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Search bar -->
                        <div class="hidden md:block">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-white/60"></i>
                                </div>
                                <input type="text" 
                                       class="glass-morphism pl-12 pr-4 py-3 rounded-2xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all duration-300 w-80" 
                                       placeholder="Search patients, appointments...">
                            </div>
                        </div>
                        
                        <!-- Notifications -->
                        <button class="relative glass-morphism p-3 rounded-2xl text-white/80 hover:text-white transition-all duration-300 hover:scale-110">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-xs flex items-center justify-center text-white font-bold">5</span>
                        </button>
                        
                        <!-- Settings -->
                        <button class="glass-morphism p-3 rounded-2xl text-white/80 hover:text-white transition-all duration-300 hover:scale-110">
                            <i class="fas fa-cog text-lg"></i>
                        </button>
                    </div>
                </div>
            </header>
            
            <!-- Page content -->
            <main class="flex-1 overflow-y-auto custom-scrollbar p-6 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarClose = document.getElementById('sidebar-close');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                overlay.classList.add('opacity-100');
                document.body.classList.add('overflow-hidden');
            }
            
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0', 'pointer-events-none');
                overlay.classList.remove('opacity-100');
                document.body.classList.remove('overflow-hidden');
            }
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', openSidebar);
            }
            
            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }
            
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }
            
            // Close sidebar on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });
            
            // Navigation items are now ready without stagger animation
        });
    </script>
    @stack('scripts')
</body>
</html> 