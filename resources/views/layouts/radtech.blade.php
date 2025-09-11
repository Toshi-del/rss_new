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
                        'radtech': {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
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
        <div class="bg-radtech-900 text-white w-64 flex-shrink-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-radtech-100">Radtech</h1>
                <p class="text-radtech-300 text-sm">Dashboard</p>
            </div>
            
            <nav class="mt-8">
                <a href="{{ route('radtech.dashboard') }}" class="flex items-center px-6 py-3 text-radtech-100 hover:bg-radtech-800 transition-colors {{ request()->routeIs('radtech.dashboard') ? 'bg-radtech-800' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span class="{{ request()->routeIs('radtech.dashboard') ? 'text-radtech-300' : '' }}">Overview</span>
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
                            <div class="text-xs text-gray-500">Radtech</div>
                        </div>
                        <div class="w-8 h-8 bg-radtech-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
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
