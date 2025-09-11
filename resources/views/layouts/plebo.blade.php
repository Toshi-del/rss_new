<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Plebo Dashboard') - RSS Health Services Corp</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @yield('styles')
    <style>
        .active-link{background-color:#1f2937;color:#93c5fd}
    </style>
    @php use Illuminate\Support\Facades\Auth; @endphp
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <div class="w-64 bg-blue-900 text-white">
            <div class="p-6">
                <h1 class="text-xl font-bold mb-2">Phlebotomy</h1>
                <p class="text-blue-200 text-sm">Dashboard</p>
            </div>
            <nav class="mt-8">
                <a href="{{ route('plebo.dashboard') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-800 transition-colors {{ request()->routeIs('plebo.dashboard') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-th-large mr-3"></i>
                    <span class="{{ request()->routeIs('plebo.dashboard') ? 'text-blue-300' : '' }}">Overview</span>
                </a>
                <a href="{{ route('plebo.pre-employment') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-800 transition-colors {{ request()->routeIs('plebo.pre-employment') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-user-md mr-3"></i>
                    <span class="{{ request()->routeIs('plebo.pre-employment') ? 'text-blue-300' : '' }}">Pre-Employment</span>
                </a>
                <a href="{{ route('plebo.annual-physical') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-800 transition-colors {{ request()->routeIs('plebo.annual-physical') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-file-medical mr-3"></i>
                    <span class="{{ request()->routeIs('plebo.annual-physical') ? 'text-blue-300' : '' }}">Annual Physical</span>
                </a>
            </nav>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm border-b">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Overview')</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="font-medium text-gray-800">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</p>
                            <p class="text-sm text-gray-600">Phlebotomist</p>
                        </div>
                        <div class="relative">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white text-sm">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>


