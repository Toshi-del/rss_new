@extends('layouts.company')

@section('title', 'Create Account Link')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center space-x-3 mb-2">
            <a href="{{ route('company.account-invitations.index') }}" 
               class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Create New Account Link</h2>
        </div>
        <p class="text-gray-600">Generate an invitation link for patient registration</p>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('company.account-invitations.store') }}" method="POST">
            @csrf
            


            <!-- Expiration Field -->
            <div class="mb-6">
                <label for="expiration_hours" class="block text-sm font-medium text-gray-700 mb-2">
                    Link Expiration <span class="text-red-500">*</span>
                </label>
                <select id="expiration_hours" 
                        name="expiration_hours" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('expiration_hours') border-red-500 @enderror">
                    <option value="">Select expiration time</option>
                    <option value="1" {{ old('expiration_hours') == '1' ? 'selected' : '' }}>1 hour</option>
                    <option value="2" {{ old('expiration_hours') == '2' ? 'selected' : '' }}>2 hours</option>
                    <option value="4" {{ old('expiration_hours') == '4' ? 'selected' : '' }}>4 hours</option>
                    <option value="6" {{ old('expiration_hours') == '6' ? 'selected' : '' }}>6 hours</option>
                    <option value="12" {{ old('expiration_hours') == '12' ? 'selected' : '' }}>12 hours</option>
                    <option value="24" {{ old('expiration_hours') == '24' ? 'selected' : '' }}>24 hours (1 day)</option>
                </select>
                @error('expiration_hours')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">The link will expire after the selected time period</p>
            </div>

            <!-- Information Box -->
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900 mb-1">How it works</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• An invitation link will be generated for patient registration</li>
                            <li>• Share the link with anyone who needs to create a patient account</li>
                            <li>• The invited person will enter their email during registration</li>
                            <li>• The link will expire after the selected time period</li>
                            <li>• Once used, the link cannot be used again</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('company.account-invitations.index') }}" 
                   class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center space-x-2">
                    <i class="fas fa-link"></i>
                    <span>Create Invitation Link</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
