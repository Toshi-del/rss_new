@extends('layouts.company')

@section('title', 'Edit Appointment')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Edit Appointment</h1>
        </div>

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('company.appointments.update', $appointment) }}" method="POST" class="space-y-6 p-6">
                @csrf
                @method('PUT')

                <!-- Appointment Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-2 text-blue-600"></i>Appointment Date
                    </label>
                    <input type="date" 
                           name="appointment_date" 
                           value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" 
                           min="{{ $minDate }}"
                           id="appointment_date"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           required>
                    <div id="date-availability-message" class="mt-2 text-sm" style="display: none;"></div>
                    @error('appointment_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time Slot -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Time Slot</label>
                    <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>Scheduling Rules:</strong> Appointments must be scheduled at least 4 days in advance. Only one company can book per day. No weekend appointments.
                        </p>
                    </div>
                    <select name="time_slot" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Select a time slot</option>
                        @foreach($timeSlots as $slot)
                        <option value="{{ $slot }}" {{ old('time_slot', $appointment->time_slot) == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                        @endforeach
                    </select>
                    @error('time_slot')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

             

                <!-- Medical Tests -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-vials mr-2"></i>Medical Tests
                    </label>
                    <div class="mt-4 space-y-8">
                        @php
                            $selectedTests = old('medical_tests', $appointment->blood_chemistry ?? []);
                        @endphp
                        @foreach($medicalTestCategories as $category)
                            @php $categoryName = strtolower(trim($category->name)); @endphp
                            @if($categoryName !== 'appointment' && $categoryName !== 'blood chemistry')
                                @continue
                            @endif
                            <div>
                                <h3 class="text-lg font-semibold text-red-800 mb-3">{{ $category->name }}</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                                    @foreach($category->medicalTests as $test)
                                        @php
                                            $isPackage = str_contains(strtolower($test->name), 'package');
                                            $cardClass = $isPackage ? 'cursor-pointer block border-2 border-emerald-200 rounded-xl p-6 hover:shadow-lg hover:border-emerald-300 transition bg-gradient-to-br from-emerald-50 to-white' : 'cursor-pointer block border rounded-xl p-5 hover:shadow transition bg-white';
                                        @endphp
                                        <label for="test{{ $test->id }}" class="{{ $cardClass }}">
                                            <div class="flex items-start">
                                                <input
                                                    id="test{{ $test->id }}"
                                                    type="checkbox"
                                                    name="medical_tests[]"
                                                    value="{{ $test->id }}"
                                                    class="mt-1 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                    {{ in_array($test->id, $selectedTests) ? 'checked' : '' }}
                                                >
                                                <div class="ml-3 w-full">
                                                    <p class="text-base font-semibold text-gray-900">{{ $test->name }}</p>
                                                    @if($test->description)
                                                        @if($isPackage)
                                                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $test->description }}</p>
                                                        @else
                                                            <p class="text-sm text-gray-500">{{ Str::limit($test->description, 50) }}</p>
                                                        @endif
                                                    @endif
                                                    @if(!is_null($test->price) && $test->price > 0)
                                                        <div class="mt-3 flex items-center justify-between">
                                                            <p class="text-xl font-bold text-emerald-600">₱{{ number_format((float)$test->price, 2) }}</p>
                                                            @if($isPackage)
                                                                <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Package</span>
                                                            @endif
                                                        </div>
                                                    @elseif(!is_null($test->price) && $test->price == 0)
                                                        <p class="mt-2 text-sm font-medium text-blue-600">Individual Test</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('medical_tests')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('notes', $appointment->notes) }}</textarea>
                    @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-5">
                    <div class="flex justify-end">
                        <a href="{{ route('company.appointments.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>
                            Update Appointment
                        </button>
                    </div>
                </div>
            </form>
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