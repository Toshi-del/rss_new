@extends('layouts.opd')

@section('opd-content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="bg-gradient-to-b from-green-50 to-white border border-green-100 rounded-xl p-6 mb-6">
        <div class="flex items-center">
            <div class="w-14 h-14 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-4">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Create OPD Account</h1>
                <p class="text-gray-600">Create a new OPD staff account with default role</p>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <form method="POST" action="{{ route('opd.create-account.store') }}" class="space-y-6">
            @csrf
            
            <!-- Personal Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- First Name -->
                    <div>
                        <label for="fname" class="block text-sm font-medium text-gray-700 mb-2">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="fname" 
                               name="fname" 
                               value="{{ old('fname') }}" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('fname') border-red-500 @enderror">
                        @error('fname')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="lname" class="block text-sm font-medium text-gray-700 mb-2">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="lname" 
                               name="lname" 
                               value="{{ old('lname') }}" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('lname') border-red-500 @enderror">
                        @error('lname')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <label for="mname" class="block text-sm font-medium text-gray-700 mb-2">
                            Middle Name
                        </label>
                        <input type="text" 
                               id="mname" 
                               name="mname" 
                               value="{{ old('mname') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('mname') border-red-500 @enderror">
                        @error('mname')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Birthday -->
                    <div>
                        <label for="birthday" class="block text-sm font-medium text-gray-700 mb-2">
                            Birthday <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="birthday" 
                               name="birthday" 
                               value="{{ old('birthday') }}" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('birthday') border-red-500 @enderror">
                        @error('birthday')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Company -->
                <div class="mt-4">
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-2">
                        Company/Organization
                    </label>
                    <input type="text" 
                           id="company" 
                           name="company" 
                           value="{{ old('company') }}"
                           placeholder="Optional"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('company') border-red-500 @enderror">
                    @error('company')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Account Security -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Account Security</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               minlength="8"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required
                               minlength="8"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
            </div>

            <!-- Role Information -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-3">
                        <i class="fa-solid fa-info text-sm"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-green-800">Account Role</h4>
                        <p class="text-sm text-green-700">This account will be created with <strong>OPD</strong> role by default.</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('opd.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Back to Dashboard
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                    <i class="fa-solid fa-user-plus mr-2"></i>
                    Create Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
