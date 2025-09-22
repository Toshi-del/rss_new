<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pathologist Dashboard') - RSS Health Services Corp</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @yield('styles')
    <style>
        .brand-gradient { 
            background: linear-gradient(135deg, #0f766e 0%, #0ea5e9 100%); 
        }
        .sidebar-gradient {
            background: linear-gradient(180deg, #0f766e 0%, #0d9488 50%, #0f766e 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .notification-badge {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .sidebar-item {
            transition: all 0.3s ease;
            position: relative;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .sidebar-item.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-right: 3px solid #ffffff;
        }
        .sidebar-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #ffffff;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 sidebar-gradient text-white flex-shrink-0 shadow-xl">
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-microscope text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Pathologist</h1>
                        <p class="text-teal-100 text-sm">Laboratory Dashboard</p>
                    </div>
                </div>
            </div>
            
            <nav class="mt-8">
                <a href="{{ route('pathologist.dashboard') }}" 
                   class="sidebar-item flex items-center px-6 py-3 text-white hover:bg-teal-800 transition-all duration-300 {{ request()->routeIs('pathologist.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large mr-3 text-lg"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
              
                <a href="{{ route('pathologist.annual-physical') }}" 
                   class="sidebar-item flex items-center px-6 py-3 text-white hover:bg-teal-800 transition-all duration-300 {{ request()->routeIs('pathologist.annual-physical*') ? 'active' : '' }}">
                    <i class="fas fa-user-check mr-3 text-lg"></i>
                    <span class="font-medium">Annual Physical</span>
                </a>
                
                <a href="{{ route('pathologist.pre-employment') }}" 
                   class="sidebar-item flex items-center px-6 py-3 text-white hover:bg-teal-800 transition-all duration-300 {{ request()->routeIs('pathologist.pre-employment*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase mr-3 text-lg"></i>
                    <span class="font-medium">Pre-Employment</span>
                </a>
                
                <a href="{{ route('pathologist.opd') }}" 
                   class="sidebar-item flex items-center px-6 py-3 text-white hover:bg-teal-800 transition-all duration-300 {{ request()->routeIs('pathologist.opd*') ? 'active' : '' }}">
                    <i class="fas fa-walking mr-3 text-lg"></i>
                    <span class="font-medium">OPD Walk-ins</span>
                </a>
                
                <a href="{{ route('pathologist.messages') }}" 
                   class="sidebar-item flex items-center px-6 py-3 text-white hover:bg-teal-800 transition-all duration-300 {{ request()->routeIs('pathologist.messages*') ? 'active' : '' }}">
                    <i class="fas fa-comments mr-3 text-lg"></i>
                    <span class="font-medium">Messages</span>
                    <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1 notification-badge">3</span>
                </a>
            </nav>
            
            <!-- Quick Stats in Sidebar -->
            <div class="mt-8 px-6">
                <div class="bg-white bg-opacity-10 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-white mb-3">Quick Stats</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-teal-100">Pending Tests</span>
                            <span class="text-white font-semibold">12</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-teal-100">Completed Today</span>
                            <span class="text-white font-semibold">8</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-teal-100">In Progress</span>
                            <span class="text-white font-semibold">5</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Overview')</h1>
                        <div class="relative">
                            <input type="text" placeholder="Search patients, records..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent w-64">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center notification-badge">3</span>
                            </button>
                        </div>
                        
                        <!-- User Profile -->
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <p class="font-medium text-gray-800">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</p>
                                <p class="text-sm text-gray-600">Pathologist</p>
                            </div>
                            <div class="relative">
                                <button id="profileButton" class="w-10 h-10 brand-gradient rounded-full flex items-center justify-center hover:opacity-90 transition-opacity shadow-lg">
                                    <i class="fas fa-user text-white"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Profile</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-16 h-16 brand-gradient rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</h4>
                        <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                        <p class="text-sm text-gray-500">Pathologist</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-user-edit mr-3 text-gray-500"></i>
                        <span>Edit Profile</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-cog mr-3 text-gray-500"></i>
                        <span>Settings</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-chart-line mr-3 text-gray-500"></i>
                        <span>Analytics</span>
                    </a>
                    <hr class="my-2">
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
    <script>
        // Profile Modal functionality
        const profileButton = document.getElementById('profileButton');
        const profileModal = document.getElementById('profileModal');
        const closeModal = document.getElementById('closeModal');
        
        if (profileButton) {
            profileButton.addEventListener('click', function() { 
                profileModal.classList.remove('hidden'); 
            });
        }
        
        if (closeModal) {
            closeModal.addEventListener('click', function() { 
                profileModal.classList.add('hidden'); 
            });
        }
        
        if (profileModal) {
            profileModal.addEventListener('click', function(e) { 
                if (e.target === profileModal) { 
                    profileModal.classList.add('hidden'); 
                } 
            });
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) { 
            if (e.key === 'Escape' && !profileModal.classList.contains('hidden')) { 
                profileModal.classList.add('hidden'); 
            } 
        });

        // Search functionality
        const searchInput = document.querySelector('input[placeholder*="Search"]');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const searchTerm = this.value.trim();
                    if (searchTerm) {
                        // Implement search functionality
                        console.log('Searching for:', searchTerm);
                    }
                }
            });
        }

        // Auto-hide success/error messages
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>