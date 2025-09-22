@extends('layouts.company')

@section('title', 'Create New Appointment - RSS Citi Health Services')
@section('page-title', 'Create New Appointment')
@section('page-description', 'Schedule a new medical examination appointment for your employees')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-blue-600 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-calendar-plus text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Schedule New Appointment</h2>
                        <p class="text-blue-100 text-sm">Create a medical examination appointment with patient data</p>
                    </div>
                </div>
                <a href="{{ route('company.appointments.index') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg transition-all duration-200 backdrop-blur-sm border border-white/20 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Calendar
                </a>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if(session('error'))
    <div class="content-card rounded-xl p-4 shadow-lg border border-red-200 bg-red-50">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="content-card rounded-xl p-4 shadow-lg border border-red-200 bg-red-50">
        <div class="flex items-start space-x-3">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-red-800 font-semibold mb-2">Please correct the following errors:</h3>
                <ul class="text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-circle text-xs text-red-500"></i>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Appointment Details -->
            <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Appointment Details</h3>
                        <p class="text-gray-600 text-sm">Select date and time for the medical examination</p>
                    </div>
                </div>

                <form action="{{ route('company.appointments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Appointment Date -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Appointment Date <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="date" 
                                       name="appointment_date" 
                                       value="{{ old('appointment_date', request('date')) }}" 
                                       min="{{ $minDate }}"
                                       id="appointment_date"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('appointment_date') border-red-500 ring-2 ring-red-200 @enderror"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                </div>
                            </div>
                            <div id="date-availability-message" class="text-sm" style="display: none;"></div>
                            @error('appointment_date')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Time Slot -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Time Slot <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="time_slot" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('time_slot') border-red-500 ring-2 ring-red-200 @enderror"
                                        required>
                                    <option value="">Choose available time</option>
                                    @foreach($timeSlots as $slot)
                                    <option value="{{ $slot }}" {{ old('time_slot') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-clock text-gray-400"></i>
                                </div>
                            </div>
                            @error('time_slot')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Scheduling Rules Info -->
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-blue-800 mb-2">Scheduling Guidelines</h4>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li class="flex items-center space-x-2">
                                        <i class="fas fa-check text-blue-500 text-xs"></i>
                                        <span>Appointments must be scheduled at least 4 days in advance</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <i class="fas fa-check text-blue-500 text-xs"></i>
                                        <span>Only one company can book per day</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <i class="fas fa-check text-blue-500 text-xs"></i>
                                        <span>No weekend appointments available</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

            </div>

            <!-- Medical Tests Selection -->
            <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-vials text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Medical Tests</h3>
                        <p class="text-gray-600 text-sm">Choose the medical examination package or individual tests</p>
                    </div>
                </div>

                <input type="hidden" name="medical_test_categories_id" id="medical_test_categories_id" value="{{ old('medical_test_categories_id') }}">
                <input type="hidden" name="medical_test_id" id="medical_test_id" value="{{ old('medical_test_id') }}">
                <div id="selected_tests_container">
                    <!-- Selected tests will be added here as hidden inputs -->
                </div>
                <input type="hidden" name="total_price" id="total_price" value="0">
                @error('medical_test_categories_id')
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
                @enderror
                @error('medical_test_id')
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
                @enderror

                @php
                    $uniqueCategories = $medicalTestCategories->unique(function($c){ return strtolower($c->name ?? ''); });
                @endphp
                @foreach($uniqueCategories as $category)
                    @php 
                        $categoryName = strtolower(trim($category->name)); 
                        $uniqueTests = $category->medicalTests->unique(function($t){ return strtolower($t->name ?? ''); });
                    @endphp
                    @if($categoryName === 'appointment' || $categoryName === 'blood chemistry' || $categoryName === 'package')
                        <div class="mb-8">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-flask text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ $category->name }}</h4>
                                    @if($category->description)
                                        <p class="text-sm text-gray-600">{{ $category->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($uniqueTests as $test)
                                    @php
                                        $isPackage = str_contains(strtolower($test->name), 'package');
                                    @endphp
                                    <label for="appointment_test_{{ $test->id }}" class="cursor-pointer block border-2 border-gray-200 rounded-xl p-6 hover:shadow-lg hover:border-blue-300 transition-all duration-200 {{ $isPackage ? 'bg-emerald-50 border-emerald-200 hover:border-emerald-300' : 'bg-white' }}">
                                        <div class="flex items-start space-x-4">
                                            <input
                                                id="appointment_test_{{ $test->id }}"
                                                type="checkbox"
                                                name="appointment_selected_test"
                                                value="{{ $test->id }}"
                                                data-category-id="{{ $category->id }}"
                                                data-test-id="{{ $test->id }}"
                                                class="mt-1 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-colors"
                                            >
                                            <div class="flex-1">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <h5 class="text-lg font-semibold text-gray-900">{{ $test->name }}</h5>
                                                        @if($test->description)
                                                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $test->description }}</p>
                                                        @endif
                                                    </div>
                                                    @if($isPackage)
                                                        <span class="bg-emerald-100 text-emerald-700 text-xs font-medium px-3 py-1 rounded-full ml-3">
                                                            <i class="fas fa-box mr-1"></i>Package
                                                        </span>
                                                    @endif
                                                </div>
                                                @if(!is_null($test->price) && $test->price > 0)
                                                    <div class="mt-4 flex items-center justify-between">
                                                        <div class="flex items-center space-x-2">
                                                            <i class="fas fa-peso-sign text-emerald-600"></i>
                                                            <span class="text-2xl font-bold text-emerald-600">{{ number_format((float)$test->price, 2) }}</span>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            <i class="fas fa-info-circle mr-1"></i>
                                                            Comprehensive examination
                                                        </div>
                                                    </div>
                                                @elseif(!is_null($test->price) && $test->price == 0)
                                                    <div class="mt-3 flex items-center space-x-2">
                                                        <i class="fas fa-tag text-blue-600"></i>
                                                        <span class="text-sm font-medium text-blue-600">Individual Test - Contact for pricing</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Additional Information -->
            <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-amber-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Additional Information</h3>
                        <p class="text-gray-600 text-sm">Notes and patient data upload</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Notes -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            Additional Notes
                        </label>
                        <textarea name="notes" 
                                  rows="4" 
                                  placeholder="Enter any special instructions, requirements, or notes for this appointment..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none @error('notes') border-red-500 ring-2 ring-red-200 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Excel File Upload -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            Patient Data (Excel File)
                        </label>
                        <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-200 mb-4">
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-info-circle text-emerald-600"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-emerald-800 mb-1">Optional Upload</h4>
                                    <p class="text-sm text-emerald-700">Upload an Excel file with patient data. Required columns: First Name, Last Name, Age, Sex, Email, Phone.</p>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <input type="file" 
                                   name="excel_file" 
                                   accept=".xlsx,.xls"
                                   id="excel_file"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('excel_file') border-red-500 ring-2 ring-red-200 @enderror">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-file-excel text-gray-400"></i>
                            </div>
                        </div>
                        @error('excel_file')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-end pt-8 border-t border-gray-200 space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('company.appointments.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-lg">
                    <i class="fas fa-calendar-plus mr-2"></i>Create Appointment
                </button>
            </div>
                </form>
            </div>

        <!-- Sidebar -->
        <div class="space-y-8 sticky top-8 self-start">
            
            <!-- Instructions Card -->
            <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-lightbulb text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Quick Guide</h3>
                        <p class="text-gray-600 text-sm">Follow these steps to create an appointment</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-600 font-bold text-sm">1</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Select Date & Time</h4>
                            <p class="text-sm text-gray-600">Choose a date at least 4 days in advance</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-purple-600 font-bold text-sm">2</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Choose Medical Test</h4>
                            <p class="text-sm text-gray-600">Select examination package or individual test</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-emerald-600 font-bold text-sm">3</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Add Patient Data</h4>
                            <p class="text-sm text-gray-600">Upload Excel file or add manually later</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Excel Template Card -->
            <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-excel text-emerald-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Excel Template</h3>
                        <p class="text-gray-600 text-sm">Required format for patient data upload</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs">
                            <thead>
                                <tr class="border-b border-gray-300">
                                    <th class="text-left py-2 px-2 font-semibold text-gray-700">First Name</th>
                                    <th class="text-left py-2 px-2 font-semibold text-gray-700">Last Name</th>
                                    <th class="text-left py-2 px-2 font-semibold text-gray-700">Age</th>
                                    <th class="text-left py-2 px-2 font-semibold text-gray-700">Sex</th>
                                    <th class="text-left py-2 px-2 font-semibold text-gray-700">Email</th>
                                    <th class="text-left py-2 px-2 font-semibold text-gray-700">Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-gray-600">
                                    <td class="py-2 px-2">John</td>
                                    <td class="py-2 px-2">Doe</td>
                                    <td class="py-2 px-2">30</td>
                                    <td class="py-2 px-2">Male</td>
                                    <td class="py-2 px-2">john@email.com</td>
                                    <td class="py-2 px-2">123-456-7890</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm text-blue-700">
                        <i class="fas fa-info-circle mr-1"></i>
                        Make sure your Excel file follows this exact format for successful import.
                    </p>
                </div>
            </div>

            <!-- Selected Test Info Card -->
            <div id="selectedTestInfo" class="content-card rounded-xl p-8 shadow-lg border border-gray-200" style="display: none;">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Selected Test</h3>
                        <p class="text-gray-600 text-sm">Your chosen medical examination</p>
                    </div>
                </div>
                <div id="testDetails">
                    <!-- Test details will be populated by JavaScript -->
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Booked dates and minimum date from backend
    const bookedDates = @json($bookedDates);
    const minDate = '{{ $minDate }}';
    const appointmentDateInput = document.getElementById('appointment_date');
    const dateAvailabilityMessage = document.getElementById('date-availability-message');
    
    // Function to check date availability
    function checkDateAvailability(selectedDate) {
        if (!selectedDate) {
            dateAvailabilityMessage.style.display = 'none';
            return;
        }
        
        const today = new Date().toISOString().split('T')[0];
        
        // Check if selected date is today or in the past
        if (selectedDate <= today) {
            dateAvailabilityMessage.innerHTML = '<i class="fas fa-ban text-gray-500 mr-1"></i><span class="text-gray-600">Cannot schedule appointments for today or past dates.</span>';
            dateAvailabilityMessage.style.display = 'block';
            return false;
        }
        
        // Check if selected date is a weekend
        const selectedDateObj = new Date(selectedDate);
        const dayOfWeek = selectedDateObj.getDay(); // 0 = Sunday, 6 = Saturday
        if (dayOfWeek === 0 || dayOfWeek === 6) {
            const dayName = dayOfWeek === 0 ? 'Sunday' : 'Saturday';
            dateAvailabilityMessage.innerHTML = '<i class="fas fa-calendar-times text-gray-500 mr-1"></i><span class="text-gray-600">Appointments cannot be scheduled on weekends (' + dayName + '). Please select a weekday.</span>';
            dateAvailabilityMessage.style.display = 'block';
            return false;
        }
        
        if (selectedDate < minDate) {
            dateAvailabilityMessage.innerHTML = '<i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i><span class="text-yellow-600">Appointments must be scheduled at least 4 days in advance.</span>';
            dateAvailabilityMessage.style.display = 'block';
            return false;
        }
        
        if (bookedDates.includes(selectedDate)) {
            dateAvailabilityMessage.innerHTML = '<i class="fas fa-times-circle text-red-500 mr-1"></i><span class="text-red-600">Date not available - Another company has already booked this date.</span>';
            dateAvailabilityMessage.style.display = 'block';
            return false;
        }
        
        dateAvailabilityMessage.innerHTML = '<i class="fas fa-check-circle text-green-500 mr-1"></i><span class="text-green-600">Date is available for booking.</span>';
        dateAvailabilityMessage.style.display = 'block';
        return true;
    }
    
    // Check date availability when date changes
    appointmentDateInput.addEventListener('change', function() {
        checkDateAvailability(this.value);
    });
    
    // Check initial date if pre-filled
    if (appointmentDateInput.value) {
        checkDateAvailability(appointmentDateInput.value);
    }
    
    // Disable dates that are too early (today and next 3 days) and weekends
    function disableInvalidDates() {
        // Add CSS to grey out disabled dates and weekends
        const style = document.createElement('style');
        style.textContent = `
            input[type="date"]::-webkit-calendar-picker-indicator {
                filter: invert(0.8);
            }
            input[type="date"] {
                position: relative;
            }
            /* Hide weekend dates in some browsers */
            input[type="date"]::-webkit-datetime-edit-day-field[disabled],
            input[type="date"]::-webkit-datetime-edit-month-field[disabled],
            input[type="date"]::-webkit-datetime-edit-year-field[disabled] {
                color: #9ca3af;
                background-color: #f3f4f6;
            }
        `;
        document.head.appendChild(style);
        
        // Add event listener to prevent weekend selection
        appointmentDateInput.addEventListener('input', function(e) {
            const selectedDate = e.target.value;
            if (selectedDate) {
                const selectedDateObj = new Date(selectedDate);
                const dayOfWeek = selectedDateObj.getDay();
                
                // If weekend is selected, clear the input and show message
                if (dayOfWeek === 0 || dayOfWeek === 6) {
                    e.target.value = '';
                    const dayName = dayOfWeek === 0 ? 'Sunday' : 'Saturday';
                    dateAvailabilityMessage.innerHTML = '<i class="fas fa-calendar-times text-gray-500 mr-1"></i><span class="text-gray-600">Weekends (' + dayName + ') are not available for appointments. Please select a weekday.</span>';
                    dateAvailabilityMessage.style.display = 'block';
                }
            }
        });
    }
    
    disableInvalidDates();
    const selectedTestInfo = document.getElementById('selectedTestInfo');
    const testDetails = document.getElementById('testDetails');
    
    // Helper function to extract price from test card
    function extractPrice(checkbox) {
        const testCard = checkbox.parentElement.parentElement;
        
        // Try different selectors for price
        let priceElement = testCard.querySelector('.text-2xl.font-bold.text-emerald-600');
        if (!priceElement) {
            priceElement = testCard.querySelector('.text-emerald-600');
        }
        if (!priceElement) {
            priceElement = testCard.querySelector('[class*="emerald-600"]');
        }
        
        if (priceElement) {
            const priceText = priceElement.textContent;
            
            // Extract number from text (handle ₱, commas, etc.)
            const priceMatch = priceText.match(/[\d,]+\.?\d*/);
            if (priceMatch) {
                const price = parseFloat(priceMatch[0].replace(',', ''));
                return price;
            }
        }
        
        return 0;
    }
    
    // Medical test category selection handling
    const hiddenCategoryInput = document.getElementById('medical_test_categories_id');
    const hiddenTestInput = document.getElementById('medical_test_id');
    const testCheckboxes = document.querySelectorAll('input[name="appointment_selected_test"][data-category-id]');

    function syncHiddenFromChecked() {
        const firstChecked = Array.from(testCheckboxes).find(cb => cb.checked);
        if (firstChecked) {
            hiddenCategoryInput.value = firstChecked.getAttribute('data-category-id');
        }
    }


    function handleTestChange(e) {
        const current = e.target;
        const currentCategoryId = current.getAttribute('data-category-id');
        const currentTestId = current.getAttribute('data-test-id');

        if (current.checked) {
            // When checking a test, uncheck other tests in the SAME category only
            Array.from(testCheckboxes).forEach(cb => {
                if (cb !== current && cb.getAttribute('data-category-id') === currentCategoryId) {
                    cb.checked = false;
                }
            });
        }

        // Update the selected test info display
        updateSelectedTestsInfo();
        
        // Update hidden inputs with selected tests
        updateHiddenInputs();
    }

    function updateSelectedTestsInfo() {
        const checkedBoxes = Array.from(testCheckboxes).filter(cb => cb.checked);
        
        if (checkedBoxes.length === 0) {
            selectedTestInfo.style.display = 'none';
            return;
        }

        let totalPrice = 0;
        let testsHtml = '<div class="space-y-4">';
        
        checkedBoxes.forEach(checkbox => {
            const testName = checkbox.parentElement.parentElement.querySelector('.text-lg.font-semibold').textContent;
            const description = checkbox.parentElement.parentElement.querySelector('.text-sm.text-gray-600')?.textContent || '';
            const price = extractPrice(checkbox);
            
            totalPrice += price;
            
            testsHtml += `
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-900">${testName}</h4>
                    ${description ? `<p class="text-xs text-gray-600 mt-1">${description}</p>` : ''}
                    ${price > 0 ? `<p class="text-sm font-bold text-emerald-600 mt-2">₱${price.toLocaleString('en-US', {minimumFractionDigits: 2})}</p>` : ''}
                </div>
            `;
        });
        
        testsHtml += '</div>';
        
        if (totalPrice > 0) {
            testsHtml += `
                <div class="mt-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-emerald-800">Total Price:</span>
                        <span class="text-xl font-bold text-emerald-600">₱${totalPrice.toLocaleString('en-US', {minimumFractionDigits: 2})}</span>
                    </div>
                </div>
            `;
        }
        
        testDetails.innerHTML = testsHtml;
        selectedTestInfo.style.display = 'block';
    }

    function updateHiddenInputs() {
        const checkedBoxes = Array.from(testCheckboxes).filter(cb => cb.checked);
        const selectedTestsContainer = document.getElementById('selected_tests_container');
        const totalPriceInput = document.getElementById('total_price');
        
        // Clear existing hidden inputs
        selectedTestsContainer.innerHTML = '';
        
        if (checkedBoxes.length === 0) {
            hiddenCategoryInput.value = '';
            hiddenTestInput.value = '';
            totalPriceInput.value = '0';
            return;
        }

        // For backward compatibility, set the first selected test in the original fields
        const firstChecked = checkedBoxes[0];
        hiddenCategoryInput.value = firstChecked.getAttribute('data-category-id');
        hiddenTestInput.value = firstChecked.getAttribute('data-test-id');

        // Calculate total price and create hidden inputs for all selected tests
        let totalPrice = 0;
        checkedBoxes.forEach((checkbox, index) => {
            const categoryId = checkbox.getAttribute('data-category-id');
            const testId = checkbox.getAttribute('data-test-id');
            
            // Get price from the test card
            const price = extractPrice(checkbox);
            totalPrice += price;
            
            // Create hidden inputs for selected tests array
            const categoryInput = document.createElement('input');
            categoryInput.type = 'hidden';
            categoryInput.name = `selected_tests[${index}][category_id]`;
            categoryInput.value = categoryId;
            selectedTestsContainer.appendChild(categoryInput);
            
            const testInput = document.createElement('input');
            testInput.type = 'hidden';
            testInput.name = `selected_tests[${index}][test_id]`;
            testInput.value = testId;
            selectedTestsContainer.appendChild(testInput);
            
            const priceInput = document.createElement('input');
            priceInput.type = 'hidden';
            priceInput.name = `selected_tests[${index}][price]`;
            priceInput.value = price;
            selectedTestsContainer.appendChild(priceInput);
        });
        
        // Set the total price
        totalPriceInput.value = totalPrice.toFixed(2);
    }

    testCheckboxes.forEach(cb => cb.addEventListener('change', handleTestChange));
    
    // Initialize on load for old inputs
    const oldCategoryId = '{{ old("medical_test_categories_id") }}';
    const oldTestId = '{{ old("medical_test_id") }}';
    
    if (oldTestId) {
        // Handle single test ID (for backward compatibility)
        const targetCheckbox = document.querySelector(`input[data-test-id="${oldTestId}"]`);
        if (targetCheckbox) {
            targetCheckbox.checked = true;
        }
        
        // Update displays
        updateSelectedTestsInfo();
        updateHiddenInputs();
    } else if (!hiddenCategoryInput.value) {
        syncHiddenFromChecked();
    }
    
    // Prevent form submission if date is not available
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const selectedDate = appointmentDateInput.value;
        if (!checkDateAvailability(selectedDate)) {
            e.preventDefault();
            alert('Please select an available date before submitting the appointment.');
            return;
        }
        
    });
});
</script>
@endpush
@endsection