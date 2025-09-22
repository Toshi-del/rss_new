<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OPD - RSS Citi Health Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50" style="font-family: 'Poppins', sans-serif;">
    <!-- Header -->
    <header class="bg-white/90 backdrop-blur border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('opd.dashboard') }}" class="flex items-center space-x-2 group">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center">
                        <i class="fa-solid fa-hospital-user"></i>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-gray-900 group-hover:text-blue-700 transition">OPD</div>
                        <div class="text-xs text-gray-500">RSS Citi Health Services</div>
                    </div>
                </a>

                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex items-center text-sm text-gray-600">
                        <i class="fa-regular fa-user mr-2"></i>
                        <span class="font-medium">{{ Auth::user()->lname ?? '' }}, {{ Auth::user()->fname ?? '' }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 space-y-3">
        @if(session('success'))
            <div class="flex items-start p-4 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200">
                <i class="fa-solid fa-circle-check mt-0.5 mr-3"></i>
                <div class="flex-1 text-sm">{{ session('success') }}</div>
            </div>
        @endif
        @if($errors->any())
            <div class="p-4 rounded-lg bg-red-50 text-red-800 border border-red-200">
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('opd-content')
    </main>

    <!-- Footer -->
    <footer class="border-t bg-white/80 backdrop-blur">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-xs text-gray-600 flex items-center justify-between">
            <div>&copy; {{ date('Y') }} RSS Citi Health Services</div>
            <div class="hidden sm:flex items-center space-x-4">
                <span class="inline-flex items-center space-x-1"><i class="fa-solid fa-shield-halved"></i><span>Secure</span></span>
                <span class="inline-flex items-center space-x-1"><i class="fa-solid fa-circle-info"></i><span>Help</span></span>
            </div>
        </div>
    </footer>
</body>
</html>

