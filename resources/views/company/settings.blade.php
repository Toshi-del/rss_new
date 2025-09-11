@extends('layouts.company')

@section('title', 'Company Settings')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Settings Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Company Settings</h2>
        <p class="text-gray-600 mt-2">Manage your company profile and preferences</p>
    </div>

    <!-- Settings Tabs -->
    <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button class="border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600" id="profile-tab">
                    Company Profile
                </button>
                <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700" id="notifications-tab">
                    Notifications
                </button>
                <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700" id="security-tab">
                    Security
                </button>
                <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700" id="billing-tab">
                    Billing
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Company Profile Tab -->
            <div id="profile-content" class="tab-content">
                <form action="{{ route('company.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Company Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Company Information</h3>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                                    <input type="text" name="company_name" id="company_name" 
                                           value="{{ auth()->user()->company_name ?? '' }}"
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="company_email" class="block text-sm font-medium text-gray-700">Company Email</label>
                                    <input type="email" name="company_email" id="company_email" 
                                           value="{{ auth()->user()->email }}"
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="tel" name="phone_number" id="phone_number" 
                                           value="{{ auth()->user()->phone_number ?? '' }}"
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                                    <input type="url" name="website" id="website" 
                                           value="{{ auth()->user()->website ?? '' }}"
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Address Information</h3>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700">Street Address</label>
                                    <input type="text" name="address" id="address" 
                                           value="{{ auth()->user()->address ?? '' }}"
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" name="city" id="city" 
                                           value="{{ auth()->user()->city ?? '' }}"
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700">State/Province</label>
                                    <input type="text" name="state" id="state" 
                                           value="{{ auth()->user()->state ?? '' }}"
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700">ZIP/Postal Code</label>
                                    <input type="text" name="zip_code" id="zip_code" 
                                           value="{{ auth()->user()->zip_code ?? '' }}"
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                    <input type="text" name="country" id="country" 
                                           value="{{ auth()->user()->country ?? '' }}"
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Business Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Business Information</h3>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                                    <select name="industry" id="industry" 
                                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Industry</option>
                                        <option value="healthcare" {{ auth()->user()->industry == 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                                        <option value="manufacturing" {{ auth()->user()->industry == 'manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                        <option value="technology" {{ auth()->user()->industry == 'technology' ? 'selected' : '' }}>Technology</option>
                                        <option value="finance" {{ auth()->user()->industry == 'finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="retail" {{ auth()->user()->industry == 'retail' ? 'selected' : '' }}>Retail</option>
                                        <option value="construction" {{ auth()->user()->industry == 'construction' ? 'selected' : '' }}>Construction</option>
                                        <option value="other" {{ auth()->user()->industry == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="employee_count" class="block text-sm font-medium text-gray-700">Number of Employees</label>
                                    <select name="employee_count" id="employee_count" 
                                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Range</option>
                                        <option value="1-10" {{ auth()->user()->employee_count == '1-10' ? 'selected' : '' }}>1-10</option>
                                        <option value="11-50" {{ auth()->user()->employee_count == '11-50' ? 'selected' : '' }}>11-50</option>
                                        <option value="51-200" {{ auth()->user()->employee_count == '51-200' ? 'selected' : '' }}>51-200</option>
                                        <option value="201-500" {{ auth()->user()->employee_count == '201-500' ? 'selected' : '' }}>201-500</option>
                                        <option value="500+" {{ auth()->user()->employee_count == '500+' ? 'selected' : '' }}>500+</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Notifications Tab -->
            <div id="notifications-content" class="tab-content hidden">
                <div class="space-y-6">
                    <h3 class="text-lg font-medium text-gray-900">Notification Preferences</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Email Notifications</h4>
                                <p class="text-sm text-gray-500">Receive email notifications for new appointments and updates</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">SMS Notifications</h4>
                                <p class="text-sm text-gray-500">Receive SMS notifications for urgent updates</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Appointment Reminders</h4>
                                <p class="text-sm text-gray-500">Get reminded about upcoming appointments</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Tab -->
            <div id="security-content" class="tab-content hidden">
                <div class="space-y-6">
                    <h3 class="text-lg font-medium text-gray-900">Security Settings</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Change Password</h4>
                            <form class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                    <input type="password" id="current_password" 
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                    <input type="password" id="new_password" 
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                    <input type="password" id="confirm_password" 
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                    Update Password
                                </button>
                            </form>
                        </div>

                        <div class="border-t pt-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Two-Factor Authentication</h4>
                            <p class="text-sm text-gray-500 mb-4">Add an extra layer of security to your account</p>
                            <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Enable 2FA
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing Tab -->
            <div id="billing-content" class="tab-content hidden">
                <div class="space-y-6">
                    <h3 class="text-lg font-medium text-gray-900">Billing Information</h3>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Current Plan</h4>
                                <p class="text-sm text-gray-500">Professional Plan - $99/month</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-900">Payment Method</h4>
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-credit-card text-gray-400"></i>
                                    <span class="text-sm font-medium text-gray-900">•••• •••• •••• 4242</span>
                                </div>
                                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Billing History</h4>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <span>December 2024</span>
                                <span class="font-medium">$99.00</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span>November 2024</span>
                                <span class="font-medium">$99.00</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span>October 2024</span>
                                <span class="font-medium">$99.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('[id$="-tab"]');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabs.forEach(t => {
                t.classList.remove('border-blue-500', 'text-blue-600');
                t.classList.add('border-transparent', 'text-gray-500');
            });

            // Add active class to clicked tab
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-blue-500', 'text-blue-600');

            // Hide all content
            contents.forEach(content => {
                content.classList.add('hidden');
            });

            // Show corresponding content
            const contentId = this.id.replace('-tab', '-content');
            document.getElementById(contentId).classList.remove('hidden');
        });
    });
});
</script>
@endsection 