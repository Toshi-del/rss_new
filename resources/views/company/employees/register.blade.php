<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employee Registration - RSS Citi Health Services</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f7ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    },
                    boxShadow: {
                        'card': '0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03)',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #e4ecfb 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }
        
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 0 20px;
        }
        
        .form-input-container {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .form-input-container:focus-within {
            transform: translateY(-2px);
        }
        
        /* Button styling */
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(to right, #0284c7, #0369a1);
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(to right, #0369a1, #075985);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2);
        }
        
        .btn-outline-primary {
            background-color: transparent;
            border: 1px solid #0284c7;
            color: #0284c7;
        }
        
        .btn-outline-primary:hover {
            background-color: #f0f7ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mb-8">
            <div class="w-20 h-20 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-building text-primary-600 text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Employee Registration</h1>
            <p class="text-gray-600">Complete your account registration for {{ $creator->company ?? 'the company' }}</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-card overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white p-6">
                <h5 class="text-xl font-bold flex items-center">
                    <i class="bi bi-person-plus-fill mr-3"></i>Create Your Account
                </h5>
                <p class="text-primary-100 mt-1">Please fill in your information to complete the registration</p>
            </div>
            <div class="p-6">
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-exclamation-triangle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('company.employees.register.store') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="created_by" value="{{ $createdBy }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="fname" class="block font-medium text-gray-700 mb-2">First Name *</label>
                            <input type="text" id="fname" name="fname" value="{{ old('fname') }}" required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            @error('fname')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="mname" class="block font-medium text-gray-700 mb-2">Middle Name</label>
                            <input type="text" id="mname" name="mname" value="{{ old('mname') }}"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            @error('mname')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="lname" class="block font-medium text-gray-700 mb-2">Last Name *</label>
                            <input type="text" id="lname" name="lname" value="{{ old('lname') }}" required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            @error('lname')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="block font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="birthday" class="block font-medium text-gray-700 mb-2">Date of Birth *</label>
                            <input type="date" id="birthday" name="birthday" value="{{ old('birthday') }}" required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            @error('birthday')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="company" class="block font-medium text-gray-700 mb-2">Are you a company employee? *</label>
                            <select id="company" name="company" required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Select an option</option>
                                <option value="yes" {{ old('company') === 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('company') === 'no' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('company')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block font-medium text-gray-700 mb-2">Password *</label>
                            <input type="password" id="password" name="password" required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block font-medium text-gray-700 mb-2">Confirm Password *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-8">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i>Complete Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-gray-600 text-sm">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium">Sign in here</a>
            </p>
        </div>
    </div>
</body>
</html> 