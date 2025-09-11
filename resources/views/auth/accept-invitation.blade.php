<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RSS Health Services Corp') }} - Accept Invitation</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto h-12 w-12 bg-blue-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user-plus text-white text-xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Complete Your Account
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                You've been invited to join {{ $invitation->company->full_name }}
            </p>
        </div>

                 <!-- Invitation Details -->
         <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
             <div class="flex items-center">
                 <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                 <div>
                     <p class="text-sm font-medium text-blue-900">Invitation Details</p>
                     <p class="text-sm text-blue-700">
                         Role: <strong>Patient</strong><br>
                         Expires: <strong>{{ $invitation->expires_at->format('M d, Y H:i') }}</strong>
                     </p>
                 </div>
             </div>
         </div>

        <!-- Registration Form -->
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('invitation.process', ['token' => $invitation->token]) }}" method="POST">
                @csrf
                
                                 <!-- Name Fields -->
                 <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                     <div>
                         <label for="fname" class="block text-sm font-medium text-gray-700 mb-1">
                             First Name <span class="text-red-500">*</span>
                         </label>
                         <input type="text" 
                                id="fname" 
                                name="fname" 
                                value="{{ old('fname') }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fname') border-red-500 @enderror">
                         @error('fname')
                             <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                         @enderror
                     </div>

                     <div>
                         <label for="mname" class="block text-sm font-medium text-gray-700 mb-1">
                             Middle Name
                         </label>
                         <input type="text" 
                                id="mname" 
                                name="mname" 
                                value="{{ old('mname') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mname') border-red-500 @enderror">
                         @error('mname')
                             <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                         @enderror
                     </div>

                     <div>
                         <label for="lname" class="block text-sm font-medium text-gray-700 mb-1">
                             Last Name <span class="text-red-500">*</span>
                         </label>
                         <input type="text" 
                                id="lname" 
                                name="lname" 
                                value="{{ old('lname') }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('lname') border-red-500 @enderror">
                         @error('lname')
                             <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                         @enderror
                     </div>
                 </div>

                 <!-- Email Field -->
                 <div class="mt-4">
                     <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                         Email Address <span class="text-red-500">*</span>
                     </label>
                     <input type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                            placeholder="Enter your email address">
                     @error('email')
                         <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                     @enderror
                 </div>

                <!-- Phone and Birthday -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                               placeholder="+1234567890">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="birthday" class="block text-sm font-medium text-gray-700 mb-1">
                            Birthday <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="birthday" 
                               name="birthday" 
                               value="{{ old('birthday') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('birthday') border-red-500 @enderror">
                        @error('birthday')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           minlength="8"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                           placeholder="Enter your password">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required
                           minlength="8"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Confirm your password">
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create Account
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-xs text-gray-500">
                By creating an account, you agree to our terms of service and privacy policy.
            </p>
        </div>
    </div>
</body>
</html>
