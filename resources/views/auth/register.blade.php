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
            
            <!-- Duplicate Prevention Notice -->
            <div class="mb-6 p-3 bg-blue-50 border border-blue-200 rounded-md">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-1"></i>
                    <strong>Account Security:</strong> We prevent duplicate accounts with the same name and contact information to protect your data.
                </p>
            </div>
            
            @php $isCorporate = request('corporate') == 1; @endphp
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
                <div class="mb-4">
    <label for="birthday" class="block text-sm font-medium text-gray-700">Birthday *</label>
    <input type="date" name="birthday" id="birthday" required
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
           value="{{ old('birthday') }}">
    @error('birthday')
        <span class="text-red-500 text-xs">{{ $message }}</span>
    @enderror
</div>

               

                @if($isCorporate)
                    <input type="hidden" name="role" value="company">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name *</label>
                        <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('company_name') border-red-500 @enderror">
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                   
                    <div class="text-sm text-gray-600">
                        <p>* By registering, you will be assigned the "Company" role and can manage your organization's health records.</p>
                    </div>
                @else
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
                    <div class="text-sm text-gray-600">
                        <p>* By registering, you will be assigned the "Patient" role by default.</p>
                        <p>* Other roles (Admin, Company, Doctor, Med Technician) can be assigned by administrators.</p>
                    </div>
                @endif

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