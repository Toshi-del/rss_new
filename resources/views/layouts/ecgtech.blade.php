<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - RSS Health</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ecgtech': {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-ecgtech-900 text-white w-64 flex-shrink-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-ecgtech-100">ECG Tech</h1>
                <p class="text-ecgtech-300 text-sm">Dashboard</p>
            </div>
            
            <nav class="mt-8">
                <a href="{{ route('ecgtech.dashboard') }}" class="flex items-center px-6 py-3 text-ecgtech-100 hover:bg-ecgtech-800 transition-colors {{ request()->routeIs('ecgtech.dashboard') ? 'bg-ecgtech-800' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span class="{{ request()->routeIs('ecgtech.dashboard') ? 'text-ecgtech-300' : '' }}">Overview</span>
                </a>
                <a href="{{ route('ecgtech.pre-employment') }}" class="flex items-center px-6 py-3 text-ecgtech-100 hover:bg-ecgtech-800 transition-colors {{ request()->routeIs('ecgtech.pre-employment') ? 'bg-ecgtech-800' : '' }}">
                    <i class="fas fa-briefcase mr-3"></i>
                    <span class="{{ request()->routeIs('ecgtech.pre-employment') ? 'text-ecgtech-300' : '' }}">Pre-Employment</span>
                </a>
                <a href="{{ route('ecgtech.annual-physical') }}" class="flex items-center px-6 py-3 text-ecgtech-100 hover:bg-ecgtech-800 transition-colors {{ request()->routeIs('ecgtech.annual-physical') ? 'bg-ecgtech-800' : '' }}">
                    <i class="fas fa-heartbeat mr-3"></i>
                    <span class="{{ request()->routeIs('ecgtech.annual-physical') ? 'text-ecgtech-300' : '' }}">Annual Physical</span>
                </a>
                <a href="{{ route('ecgtech.opd') }}" class="flex items-center px-6 py-3 text-ecgtech-100 hover:bg-ecgtech-800 transition-colors {{ request()->routeIs('ecgtech.opd*') ? 'bg-ecgtech-800' : '' }}">
                    <i class="fas fa-walking mr-3"></i>
                    <span class="{{ request()->routeIs('ecgtech.opd*') ? 'text-ecgtech-300' : '' }}">OPD Walk-ins</span>
                </a>
                <a href="{{ route('ecgtech.messages') }}" class="flex items-center px-6 py-3 text-ecgtech-100 hover:bg-ecgtech-800 transition-colors {{ request()->routeIs('ecgtech.messages') ? 'bg-ecgtech-800' : '' }}">
                    <i class="fas fa-comments mr-3"></i>
                    <span class="{{ request()->routeIs('ecgtech.messages') ? 'text-ecgtech-300' : '' }}">Messages</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title')</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-900">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</div>
                            <div class="text-xs text-gray-500">ECG Tech</div>
                        </div>
                        <div class="w-8 h-8 bg-ecgtech-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-heartbeat text-white text-sm"></i>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
