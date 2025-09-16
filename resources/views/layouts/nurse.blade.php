<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Med Tech Dashboard') - RSS Health Services Corp</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @yield('styles')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-green-900 text-white">
            <div class="p-6">
                <h1 class="text-xl font-bold mb-2">Med Tech</h1>
                <p class="text-green-200 text-sm">Dashboard</p>
            </div>
            <nav class="mt-8">
                <a href="{{ route('nurse.dashboard') }}" class="flex items-center px-6 py-3 text-green-100 hover:bg-green-800 transition-colors {{ request()->routeIs('nurse.dashboard') ? 'bg-green-800' : '' }}">
                    <i class="fas fa-th-large mr-3"></i>
                    <span class="{{ request()->routeIs('nurse.dashboard') ? 'text-green-300' : '' }}">Overview</span>
                </a>
                <a href="{{ route('nurse.pre-employment') }}" class="flex items-center px-6 py-3 text-green-100 hover:bg-green-800 transition-colors {{ request()->routeIs('nurse.pre-employment') ? 'bg-green-800' : '' }}">
                    <i class="fas fa-user-md mr-3"></i>
                    <span class="{{ request()->routeIs('nurse.pre-employment') ? 'text-green-300' : '' }}">Pre-Employment</span>
                </a>
                <a href="{{ route('nurse.annual-physical') }}" class="flex items-center px-6 py-3 text-green-100 hover:bg-green-800 transition-colors {{ request()->routeIs('nurse.annual-physical') ? 'bg-green-800' : '' }}">
                    <i class="fas fa-file-medical mr-3"></i>
                    <span class="{{ request()->routeIs('nurse.annual-physical') ? 'text-green-300' : '' }}">Annual Physical</span>
                </a>
                <a href="{{ route('nurse.opd-examinations') }}" class="flex items-center px-6 py-3 text-green-100 hover:bg-green-800 transition-colors {{ request()->routeIs('nurse.opd-examinations*') ? 'bg-green-800' : '' }}">
                    <i class="fas fa-stethoscope mr-3"></i>
                    <span class="{{ request()->routeIs('nurse.opd-examinations*') ? 'text-green-300' : '' }}">OPD Examinations</span>
                </a>
                <a href="{{ route('nurse.messages') }}" class="flex items-center px-6 py-3 text-green-100 hover:bg-green-800 transition-colors {{ request()->routeIs('nurse.messages') ? 'bg-green-800' : '' }}">
                    <i class="fas fa-comments mr-3"></i>
                    <span class="{{ request()->routeIs('nurse.messages') ? 'text-green-300' : '' }}">Messages</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Overview')</h1>
                        <div class="relative">
                            <input type="text" placeholder="Search" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="font-medium text-gray-800">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</p>
                            <p class="text-sm text-gray-600">Med Tech</p>
                        </div>
                        <div class="relative">
                            <button id="profileButton" class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                                <i class="fas fa-user-nurse text-white"></i>
                            </button>
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
                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Profile</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Profile Info -->
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-nurse text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900"> {{ Auth::user()->fname }} {{ Auth::user()->lname }}</h4>
                        <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                        <p class="text-sm text-gray-500">Med Tech</p>
                    </div>
                </div>

                <!-- Menu Items -->
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
                        <i class="fas fa-question-circle mr-3 text-gray-500"></i>
                        <span>Help & Support</span>
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
        // Profile Modal Functionality
        const profileButton = document.getElementById('profileButton');
        const profileModal = document.getElementById('profileModal');
        const closeModal = document.getElementById('closeModal');

        // Open modal
        profileButton.addEventListener('click', function() {
            profileModal.classList.remove('hidden');
        });

        // Close modal
        closeModal.addEventListener('click', function() {
            profileModal.classList.add('hidden');
        });

        // Close modal when clicking outside
        profileModal.addEventListener('click', function(e) {
            if (e.target === profileModal) {
                profileModal.classList.add('hidden');
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !profileModal.classList.contains('hidden')) {
                profileModal.classList.add('hidden');
            }
        });
    </script>
</body>
</html> 