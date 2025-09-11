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
        .brand-gradient { background: linear-gradient(135deg, #0f766e 0%, #0ea5e9 100%); }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-teal-900 text-white">
            <div class="p-6">
                <h1 class="text-xl font-bold mb-2">Pathologist</h1>
                <p class="text-teal-200 text-sm">Dashboard</p>
            </div>
            <nav class="mt-8">
                <a href="{{ route('pathologist.dashboard') }}" class="flex items-center px-6 py-3 text-teal-100 hover:bg-teal-800 transition-colors {{ request()->routeIs('pathologist.dashboard') ? 'bg-teal-800' : '' }}">
                    <i class="fas fa-th-large mr-3"></i>
                    <span class="{{ request()->routeIs('pathologist.dashboard') ? 'text-teal-300' : '' }}">Overview</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-teal-100 hover:bg-teal-800 transition-colors">
                    <i class="fas fa-vials mr-3"></i>
                    <span>Lab Requests</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-teal-100 hover:bg-teal-800 transition-colors">
                    <i class="fas fa-flask mr-3"></i>
                    <span>Blood Chemistry</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-teal-100 hover:bg-teal-800 transition-colors">
                    <i class="fas fa-comments mr-3"></i>
                    <span>Messages</span>
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
                            <input type="text" placeholder="Search" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="font-medium text-gray-800">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</p>
                            <p class="text-sm text-gray-600">Pathologist</p>
                        </div>
                        <div class="relative">
                            <button id="profileButton" class="w-10 h-10 brand-gradient rounded-full flex items-center justify-center hover:opacity-90 transition-opacity">
                                <i class="fas fa-user text-white"></i>
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
        const profileButton = document.getElementById('profileButton');
        const profileModal = document.getElementById('profileModal');
        const closeModal = document.getElementById('closeModal');
        if (profileButton) {
            profileButton.addEventListener('click', function() { profileModal.classList.remove('hidden'); });
        }
        if (closeModal) {
            closeModal.addEventListener('click', function() { profileModal.classList.add('hidden'); });
        }
        if (profileModal) {
            profileModal.addEventListener('click', function(e) { if (e.target === profileModal) { profileModal.classList.add('hidden'); } });
        }
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape' && !profileModal.classList.contains('hidden')) { profileModal.classList.add('hidden'); } });
    </script>
</body>
</html>


