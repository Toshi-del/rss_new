<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - RSS Health Services Corp</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-8">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-blue-600 mb-2">RSS Health Services Corp</h1>
                <h2 class="text-2xl font-semibold text-gray-800">Create Account</h2>
                <p class="text-gray-600">Join our health services platform</p>
            </div>
            
            <form method="POST" action="{{ route('register.attempt') }}" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="fname" class="block text-sm font-medium text-gray-700">First Name *</label>
                        <input type="text" name="fname" id="fname" value="{{ old('fname') }}" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('fname') border-red-500 @enderror">
                        @error('fname')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lname" class="block text-sm font-medium text-gray-700">Last Name *</label>
                        <input type="text" name="lname" id="lname" value="{{ old('lname') }}" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('lname') border-red-500 @enderror">
                        @error('lname')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="mname" class="block text-sm font-medium text-gray-700">Middle Name</label>
                    <input type="text" name="mname" id="mname" value="{{ old('mname') }}" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('mname') border-red-500 @enderror">
                    @error('mname')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number *</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="birthday" class="block text-sm font-medium text-gray-700">Birthday *</label>
                    <input type="date" name="birthday" id="birthday" value="{{ old('birthday') }}" required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('birthday') border-red-500 @enderror">
                    @error('birthday')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700">Company (Optional)</label>
                    <select name="company" id="company" 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('company') border-red-500 @enderror">
                        <option value="">Select a company</option>
                        <option value="Pasig Catholic College" {{ old('company') == 'Pasig Catholic College' ? 'selected' : '' }}>Pasig Catholic College</option>
                        <option value="AsiaPro" {{ old('company') == 'AsiaPro' ? 'selected' : '' }}>AsiaPro</option>
                        <option value="PrimeLime" {{ old('company') == 'PrimeLime' ? 'selected' : '' }}>PrimeLime</option>
                    </select>
                    @error('company')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                    <input type="password" name="password" id="password" required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="text-sm text-gray-600">
                    <p>* By registering, you will be assigned the "Patient" role by default.</p>
                    <p>* Other roles (Admin, Company, Doctor, Nurse) can be assigned by administrators.</p>
                </div>

                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html> 