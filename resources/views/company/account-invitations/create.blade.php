@extends('layouts.company')

@section('title', 'Create Account Invitation')

@section('content')
<div class="min-h-screen" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('company.account-invitations.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 transition-all duration-200 shadow-sm mr-6">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to List
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-plus-circle mr-3"></i>Create Account Invitation
                            </h1>
                            <p class="text-blue-100">Generate a secure invitation link for patient registration</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-indigo-700 border-l-4 border-indigo-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-cog mr-3"></i>Invitation Settings
                </h2>
                <p class="text-indigo-100 mt-1">Configure your invitation link preferences</p>
            </div>
            
            <form action="{{ route('company.account-invitations.store') }}" method="POST" class="p-8">
                @csrf
                
                <!-- Expiration Field -->
                <div class="mb-8">
                    <label for="expiration_hours" class="block text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-clock mr-2 text-indigo-600"></i>
                        Link Expiration Time <span class="text-red-500">*</span>
                    </label>
                    <p class="text-gray-600 mb-4">Choose how long the invitation link will remain active</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Quick Options -->
                        <div class="md:col-span-2">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @php
                                    $options = [
                                        ['value' => '1', 'label' => '1 Hour', 'desc' => 'Quick access', 'icon' => 'fa-bolt'],
                                        ['value' => '4', 'label' => '4 Hours', 'desc' => 'Same day', 'icon' => 'fa-sun'],
                                        ['value' => '12', 'label' => '12 Hours', 'desc' => 'Half day', 'icon' => 'fa-moon'],
                                        ['value' => '24', 'label' => '1 Day', 'desc' => 'Recommended', 'icon' => 'fa-calendar-day'],
                                        ['value' => '72', 'label' => '3 Days', 'desc' => 'Extended', 'icon' => 'fa-calendar-week'],
                                        ['value' => '168', 'label' => '1 Week', 'desc' => 'Maximum', 'icon' => 'fa-calendar']
                                    ];
                                @endphp
                                
                                @foreach($options as $option)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="expiration_hours" value="{{ $option['value'] }}" 
                                           class="sr-only peer" {{ old('expiration_hours') == $option['value'] ? 'checked' : '' }}>
                                    <div class="p-4 border-2 border-gray-200 rounded-lg hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all duration-200">
                                        <div class="flex items-center justify-center mb-2">
                                            <i class="fas {{ $option['icon'] }} text-2xl text-indigo-600"></i>
                                        </div>
                                        <h3 class="text-sm font-bold text-gray-900 text-center">{{ $option['label'] }}</h3>
                                        <p class="text-xs text-gray-600 text-center mt-1">{{ $option['desc'] }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Custom Option -->
                        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-gray-400">
                            <h3 class="text-sm font-bold text-gray-900 mb-2">
                                <i class="fas fa-sliders-h mr-2"></i>Custom Duration
                            </h3>
                            <select id="expiration_hours_custom" 
                                    name="expiration_hours_custom" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="">Select custom time</option>
                                <option value="2" {{ old('expiration_hours') == '2' ? 'selected' : '' }}>2 hours</option>
                                <option value="6" {{ old('expiration_hours') == '6' ? 'selected' : '' }}>6 hours</option>
                                <option value="48" {{ old('expiration_hours') == '48' ? 'selected' : '' }}>2 days</option>
                                <option value="120" {{ old('expiration_hours') == '120' ? 'selected' : '' }}>5 days</option>
                            </select>
                        </div>
                    </div>
                    
                    @error('expiration_hours')
                        <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                        </div>
                    @enderror
                </div>

                <!-- Information Section -->
                <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-blue-600 mb-8">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-lightbulb text-white text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-blue-900 mb-3">How Invitation Links Work</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-3">
                                    <div class="flex items-start">
                                        <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                            <span class="text-white text-xs font-bold">1</span>
                                        </div>
                                        <p class="text-blue-800 text-sm">A secure invitation link will be generated</p>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                            <span class="text-white text-xs font-bold">2</span>
                                        </div>
                                        <p class="text-blue-800 text-sm">Share the link with patients who need accounts</p>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                            <span class="text-white text-xs font-bold">3</span>
                                        </div>
                                        <p class="text-blue-800 text-sm">Patients enter their details to register</p>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-start">
                                        <div class="w-6 h-6 bg-amber-500 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                            <i class="fas fa-clock text-white text-xs"></i>
                                        </div>
                                        <p class="text-blue-800 text-sm">Link expires after the selected time</p>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                        <p class="text-blue-800 text-sm">One-time use for security</p>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                            <i class="fas fa-shield-alt text-white text-xs"></i>
                                        </div>
                                        <p class="text-blue-800 text-sm">Secure and encrypted process</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('company.account-invitations.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-3 border border-transparent rounded-lg text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                        <i class="fas fa-plus-circle mr-2"></i>
                        <span>Generate Invitation Link</span>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Security Notice -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-green-600 to-green-700 border-l-4 border-green-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-shield-alt mr-3"></i>Security & Privacy
                </h2>
                <p class="text-green-100 mt-1">Your invitation links are secure and protected</p>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-lock text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Encrypted Links</h3>
                        <p class="text-gray-600 text-sm">All invitation links are encrypted and secure against unauthorized access.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user-shield text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Privacy Protected</h3>
                        <p class="text-gray-600 text-sm">Patient information is protected and only accessible to authorized users.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-history text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Audit Trail</h3>
                        <p class="text-gray-600 text-sm">All invitation activities are logged and monitored for security.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle custom duration selection
    const customSelect = document.getElementById('expiration_hours_custom');
    const radioButtons = document.querySelectorAll('input[name="expiration_hours"]');
    
    customSelect.addEventListener('change', function() {
        if (this.value) {
            // Uncheck all radio buttons
            radioButtons.forEach(radio => radio.checked = false);
            // Set the custom value to the main field
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'expiration_hours';
            hiddenInput.value = this.value;
            this.form.appendChild(hiddenInput);
        }
    });
    
    // Handle radio button selection
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                customSelect.value = '';
                // Remove any hidden custom input
                const existingHidden = document.querySelector('input[name="expiration_hours"][type="hidden"]');
                if (existingHidden) {
                    existingHidden.remove();
                }
            }
        });
    });
    
    // Add hover animations to cards
    const cards = document.querySelectorAll('[class*="hover:border-indigo-300"]');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endpush
@endsection
