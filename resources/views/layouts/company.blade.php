<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RSS Health Services Corp') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar {
            width: 250px;
            background-color: #004976;
            transition: all 0.3s;
        }
        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
        }
        .nav-item {
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.2s;
        }
        .nav-item:hover, .nav-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            .sidebar.active {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-100">
    @auth
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="sidebar fixed h-full shadow-xl">
            <!-- Logo Area -->
            <div class="p-4 border-b border-white/10">
                <a href="{{ route('company.dashboard') }}" class="flex items-center space-x-3 text-white">
                    <i class="fas fa-building text-xl"></i>
                    <span class="text-lg font-semibold">Company Portal</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-4">
                <a href="{{ route('company.dashboard') }}" 
                   class="nav-item flex items-center px-4 py-3 {{ request()->routeIs('company.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line w-6"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('company.appointments.index') }}" 
                   class="nav-item flex items-center px-4 py-3 {{ request()->routeIs('company.appointments.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check w-6"></i>
                    <span>Appointments</span>
                </a>

                <a href="{{ route('company.pre-employment.index') }}"
                   class="nav-item flex items-center px-4 py-3 {{ request()->routeIs('company.pre-employment.*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase w-6"></i>
                    <span>Pre-Employment</span>
                </a>

                <a href="#" 
                   class="nav-item flex items-center px-4 py-3">
                    <i class="fas fa-file-medical w-6"></i>
                    <span>Medical Reports</span>
                </a>

                <a href="{{ route('company.employees.index') }}" 
                   class="nav-item flex items-center px-4 py-3 {{ request()->routeIs('company.employees.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-6"></i>
                    <span>Employee Accounts</span>
                </a>

                <a href="{{ route('company.settings') }}" 
                   class="nav-item flex items-center px-4 py-3 {{ request()->routeIs('company.settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog w-6"></i>
                    <span>Settings</span>
                </a>
            </nav>

            <!-- User Profile -->
            <div class="absolute bottom-0 w-full p-4 border-t border-white/10 text-white/80">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-user-circle text-2xl"></i>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ Auth::user()->full_name }}</p>
                        <p class="text-xs opacity-75">Company Admin</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-white/50 hover:text-white">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content flex-1 overflow-x-hidden">
            <!-- Top Bar -->
            <div class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Company Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                            <input type="text" 
                                   placeholder="Search applicants..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
    @endauth

    @stack('scripts')
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('button.md\\:hidden');
            const sidebar = document.querySelector('.sidebar');
            
            if (menuButton && sidebar) {
                menuButton.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html> 