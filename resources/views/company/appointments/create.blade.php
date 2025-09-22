@extends('layouts.company')

@section('title', 'Create New Appointment')

@section('content')
<div class="min-h-screen bg-gray-50" style="font-family: 'Inter', sans-serif;">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-white border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif; color: #800000;">
                                <i class="fas fa-calendar-plus mr-3"></i>Create New Appointment
                            </h1>
                            <p class="text-sm text-gray-600">Schedule a new appointment and manage patient data</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('company.appointments.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <form action="{{ route('company.appointments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
                        @csrf

                        <!-- Appointment Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-2 text-blue-600"></i>Appointment Date
                            </label>
                            <input type="date" 
                                   name="appointment_date" 
                                   value="{{ old('appointment_date', request('date')) }}" 
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-clock mr-2 text-green-600"></i>Time Slot
                            </label>
                            <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                                <p class="text-sm text-blue-800">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    <strong>Scheduling Rules:</strong> Appointments must be scheduled at least 4 days in advance. Only one company can book per day. No weekend appointments.
                                </p>
                            </div>
                            <select name="time_slot" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                                    required>
                                <option value="">Select a time slot</option>
                                @foreach($timeSlots as $slot)
                                <option value="{{ $slot }}" {{ old('time_slot') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                                @endforeach
                            </select>
                            @error('time_slot')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Medical Tests by Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                <i class="fas fa-vials mr-2 text-red-600"></i>Medical Tests
                            </label>

                            <input type="hidden" name="medical_test_categories_id" id="medical_test_categories_id" value="{{ old('medical_test_categories_id') }}">
                            <input type="hidden" name="medical_test_id" id="medical_test_id" value="{{ old('medical_test_id') }}">
                            @error('medical_test_categories_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('medical_test_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            @php
                                $uniqueCategories = $medicalTestCategories->unique(function($c){ return strtolower($c->name ?? ''); });
                            @endphp
                            @foreach($uniqueCategories as $category)
                                @php 
                                    $categoryName = strtolower(trim($category->name)); 
                                    $uniqueTests = $category->medicalTests->unique(function($t){ return strtolower($t->name ?? ''); });
                                @endphp
                                @if($categoryName === 'appointment' || $categoryName === 'blood chemistry' || $categoryName === 'package'    )
                                    <div class="mb-8">
                                        <h4 class="text-lg font-semibold mb-3" style="color:#800000;">
                                            {{ $category->name }}
                                            @if($category->description)
                                                <span class="text-sm text-gray-500 font-normal">- {{ $category->description }}</span>
                                            @endif
                                        </h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                                            @foreach($uniqueTests as $test)
                                                @php
                                                    $isPackage = str_contains(strtolower($test->name), 'package');
                                                    $cardClass = $isPackage ? 'cursor-pointer block border-2 border-emerald-200 rounded-xl p-6 hover:shadow-lg hover:border-emerald-300 transition bg-gradient-to-br from-emerald-50 to-white' : 'cursor-pointer block border rounded-xl p-5 hover:shadow transition bg-white';
                                                @endphp
                                                <label for="appointment_test_{{ $test->id }}" class="{{ $cardClass }}">
                                                    <div class="flex items-start">
                                                        <input
                                                            id="appointment_test_{{ $test->id }}"
                                                            type="checkbox"
                                                            name="appointment_selected_test"
                                                            value="{{ $test->id }}"
                                                            data-category-id="{{ $category->id }}"
                                                            data-test-id="{{ $test->id }}"
                                                            class="mt-1 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                        >
                                                        <div class="ml-3 w-full">
                                                            <p class="text-base font-semibold text-gray-900">{{ $test->name }}</p>
                                                            @if($test->description)
                                                                @if(str_contains(strtolower($test->name), 'package'))
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
                                @endif
                            @endforeach
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-sticky-note mr-2 text-yellow-600"></i>Additional Notes
                            </label>
                            <textarea name="notes" 
                                      rows="3" 
                                      placeholder="Enter any additional notes or special instructions..."
                                      class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('notes') }}</textarea>
                            @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Excel File Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-file-excel mr-2 text-green-600"></i>Patient Data (Excel File)
                            </label>
                            <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-md">
                                <p class="text-sm text-green-800">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    <strong>Optional:</strong> Upload an Excel file with patient data. The file should contain columns: First Name, Last Name, Age, Sex, Email, Phone.
                                </p>
                            </div>
                            <input type="file" 
                                   name="excel_file" 
                                   accept=".xlsx,.xls"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('excel_file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="pt-5">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('company.appointments.index') }}" 
                                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <i class="fas fa-save mr-2"></i>
                                    Create Appointment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Instructions Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-lightbulb mr-2 text-yellow-600"></i>Instructions
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4 text-sm text-gray-600">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                <p>Select a date at least 4 days in advance</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                <p>Choose an available time slot</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                <p>Select the medical test category and specific test</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                <p>Optionally upload an Excel file with patient data</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Excel Template Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-file-download mr-2 text-blue-600"></i>Excel Template
                        </h2>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Use this format for your Excel file:</p>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="border-b border-gray-300">
                                        <th class="text-left py-1">First Name</th>
                                        <th class="text-left py-1">Last Name</th>
                                        <th class="text-left py-1">Age</th>
                                        <th class="text-left py-1">Sex</th>
                                        <th class="text-left py-1">Email</th>
                                        <th class="text-left py-1">Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-gray-600">
                                        <td class="py-1">John</td>
                                        <td class="py-1">Doe</td>
                                        <td class="py-1">30</td>
                                        <td class="py-1">Male</td>
                                        <td class="py-1">john@email.com</td>
                                        <td class="py-1">123-456-7890</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Selected Test Info Card -->
                <div id="selectedTestInfo" class="bg-white shadow rounded-lg overflow-hidden" style="display: none;">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>Selected Test
                        </h2>
                    </div>
                    <div class="p-6">
                        <div id="testDetails">
                            <!-- Test details will be populated by JavaScript -->
                        </div>
                    </div>
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

    function updateSelectedTestInfo(checkbox) {
        if (checkbox.checked) {
            const testName = checkbox.parentElement.parentElement.querySelector('.text-base.font-semibold').textContent;
            const description = checkbox.parentElement.parentElement.querySelector('.text-sm.text-gray-500')?.textContent || '';
            const priceElement = checkbox.parentElement.parentElement.querySelector('.text-emerald-600');
            const price = priceElement ? priceElement.textContent.replace('₱', '').replace(',', '') : '0';
            
            testDetails.innerHTML = `
                <div class="space-y-3">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">${testName}</h3>
                        ${description ? `<p class="text-xs text-gray-600 mt-1">${description}</p>` : ''}
                    </div>
                    <div class="flex justify-between items-center p-3 bg-green-50 border border-green-200 rounded-lg">
                        <span class="text-sm text-gray-700">Price:</span>
                        <span class="text-lg font-bold text-green-600">₱${parseFloat(price).toLocaleString('en-US', {minimumFractionDigits: 2})}</span>
                    </div>
                </div>
            `;
            selectedTestInfo.style.display = 'block';
        } else {
            selectedTestInfo.style.display = 'none';
        }
    }

    function handleTestChange(e) {
        const current = e.target;
        const currentCategoryId = current.getAttribute('data-category-id');
        const currentTestId = current.getAttribute('data-test-id');
        const selectedCategoryId = hiddenCategoryInput.value;

        // Uncheck other tests when one is selected (single test selection)
        if (current.checked) {
            Array.from(testCheckboxes).forEach(cb => {
                if (cb !== current) cb.checked = false;
            });
        }

        // If none are checked, clear hidden inputs
        if (!Array.from(testCheckboxes).some(cb => cb.checked)) {
            hiddenCategoryInput.value = '';
            hiddenTestInput.value = '';
            selectedTestInfo.style.display = 'none';
            return;
        }

        // If no category selected yet, set it
        if (!selectedCategoryId) {
            hiddenCategoryInput.value = currentCategoryId;
            hiddenTestInput.value = currentTestId;
            updateSelectedTestInfo(current);
            return;
        }

        // If different category, prevent mixing and auto-uncheck
        if (selectedCategoryId !== currentCategoryId) {
            // Uncheck the box and notify
            current.checked = false;
            alert('Please select tests from one category only.');
            return;
        }

        // Same category: set test id
        hiddenTestInput.value = currentTestId;
        updateSelectedTestInfo(current);
    }

    testCheckboxes.forEach(cb => cb.addEventListener('change', handleTestChange));
    
    // Initialize on load for old inputs
    const oldCategoryId = '{{ old("medical_test_categories_id") }}';
    const oldTestId = '{{ old("medical_test_id") }}';
    
    if (oldTestId) {
        const targetCheckbox = document.querySelector(`input[data-test-id="${oldTestId}"]`);
        if (targetCheckbox) {
            targetCheckbox.checked = true;
            hiddenCategoryInput.value = targetCheckbox.getAttribute('data-category-id');
            hiddenTestInput.value = oldTestId;
            updateSelectedTestInfo(targetCheckbox);
        }
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
        }
    });
});
</script>
@endpush
@endsection