@extends('layouts.company')

@section('title', 'Edit Appointment - RSS Citi Health Services')
@section('page-title', 'Edit Appointment')
@section('page-description', 'Modify medical examination appointment details and settings')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-emerald-600 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-edit text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Edit Appointment</h2>
                        <p class="text-emerald-100 text-sm">Modify appointment details and medical test selections</p>
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

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Current Appointment Info -->
            <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Current Appointment Details</h3>
                        <p class="text-gray-600 text-sm">Review and modify appointment information</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $appointment->appointment_date ? $appointment->appointment_date->format('d') : 'N/A' }}</div>
                            <div class="text-sm text-blue-500">{{ $appointment->appointment_date ? $appointment->appointment_date->format('M Y') : 'No Date' }}</div>
                            <div class="text-xs text-gray-600 mt-1">Current Date</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-emerald-600">{{ $appointment->time_slot ?? 'Not Set' }}</div>
                            <div class="text-xs text-gray-600 mt-1">Current Time</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-purple-600">{{ $appointment->patients ? $appointment->patients->count() : 0 }}</div>
                            <div class="text-xs text-gray-600 mt-1">Patients</div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('company.appointments.update', $appointment) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Appointment Date -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Appointment Date <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="date" 
                                       name="appointment_date" 
                                       value="{{ old('appointment_date', $appointment->appointment_date ? $appointment->appointment_date->format('Y-m-d') : '') }}" 
                                       min="{{ $minDate }}"
                                       id="appointment_date"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('appointment_date') border-red-500 ring-2 ring-red-200 @enderror"
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
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('time_slot') border-red-500 ring-2 ring-red-200 @enderror"
                                        required>
                                    <option value="">Choose available time</option>
                                    @foreach($timeSlots as $slot)
                                    <option value="{{ $slot }}" {{ old('time_slot', $appointment->time_slot) == $slot ? 'selected' : '' }}>{{ $slot }}</option>
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
                        <p class="text-gray-600 text-sm">Modify selected medical examination packages or tests</p>
                    </div>
                </div>

                @php
                    $selectedTests = old('medical_tests', $appointment->blood_chemistry ?? []);
                @endphp
                @foreach($medicalTestCategories as $category)
                    @php $categoryName = strtolower(trim($category->name)); @endphp
                    @if($categoryName !== 'appointment' && $categoryName !== 'blood chemistry')
                        @continue
                    @endif
                    <div class="mb-8">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-flask text-emerald-600"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">{{ $category->name }}</h4>
                                @if($category->description)
                                    <p class="text-sm text-gray-600">{{ $category->description }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($category->medicalTests as $test)
                                @php
                                    $isPackage = str_contains(strtolower($test->name), 'package');
                                @endphp
                                <label for="test{{ $test->id }}" class="cursor-pointer block border-2 border-gray-200 rounded-xl p-6 hover:shadow-lg hover:border-emerald-300 transition-all duration-200 {{ $isPackage ? 'bg-emerald-50 border-emerald-200 hover:border-emerald-300' : 'bg-white' }} {{ in_array($test->id, $selectedTests) ? 'ring-2 ring-emerald-500 border-emerald-500' : '' }}">
                                    <div class="flex items-start space-x-4">
                                        <input
                                            id="test{{ $test->id }}"
                                            type="checkbox"
                                            name="medical_tests[]"
                                            value="{{ $test->id }}"
                                            class="mt-1 h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded transition-colors"
                                            {{ in_array($test->id, $selectedTests) ? 'checked' : '' }}
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
                                                    <i class="fas fa-tag text-emerald-600"></i>
                                                    <span class="text-sm font-medium text-emerald-600">Individual Test - Contact for pricing</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                @error('medical_tests')
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
                @enderror
            </div>

            <!-- Additional Information -->
            <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sticky-note text-amber-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Additional Notes</h3>
                        <p class="text-gray-600 text-sm">Add or modify appointment notes and instructions</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Notes
                    </label>
                    <textarea name="notes" 
                              rows="4" 
                              placeholder="Enter any special instructions, requirements, or notes for this appointment..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-none @error('notes') border-red-500 ring-2 ring-red-200 @enderror">{{ old('notes', $appointment->notes) }}</textarea>
                    @error('notes')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-end pt-8 border-t border-gray-200 space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('company.appointments.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    <i class="fas fa-times mr-2"></i>Cancel Changes
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-semibold shadow-lg">
                    <i class="fas fa-save mr-2"></i>Update Appointment
                </button>
            </div>
                </form>
            </div>

        <!-- Sidebar -->
        <div class="space-y-8 sticky top-8 self-start">
            
            <!-- Appointment Status -->
            <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-emerald-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Appointment Status</h3>
                        <p class="text-gray-600 text-sm">Current appointment information</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-sm text-gray-600">Appointment ID</div>
                        <div class="font-semibold text-gray-900">#{{ $appointment->id }}</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-sm text-gray-600">Status</div>
                        <div class="font-semibold text-emerald-600">{{ ucfirst($appointment->status ?? 'Active') }}</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-sm text-gray-600">Created</div>
                        <div class="font-semibold text-gray-900">{{ $appointment->created_at ? $appointment->created_at->format('M d, Y') : 'N/A' }}</div>
                    </div>
                    @if($appointment->total_price)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-sm text-gray-600">Total Price</div>
                        <div class="font-semibold text-emerald-600">₱{{ number_format($appointment->total_price, 2) }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Edit Guidelines -->
            <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-lightbulb text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Edit Guidelines</h3>
                        <p class="text-gray-600 text-sm">Important notes when modifying appointments</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar text-blue-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Date Changes</h4>
                            <p class="text-sm text-gray-600">Must still follow 4-day advance rule</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-vials text-purple-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Test Changes</h4>
                            <p class="text-sm text-gray-600">Modify selected tests as needed</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-users text-emerald-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Patient Data</h4>
                            <p class="text-sm text-gray-600">Existing patient data will be preserved</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
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
    
    // Prevent form submission if date is not available
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const selectedDate = appointmentDateInput.value;
        if (!checkDateAvailability(selectedDate)) {
            e.preventDefault();
            alert('Please select an available date before updating the appointment.');
        }
    });
});
</script>
@endpush
@endsection