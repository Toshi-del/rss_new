@extends('layouts.company')

@section('title', 'New Appointment')

@section('content')
<div class="min-h-screen bg-gray-50" style="font-family: 'Inter', sans-serif;">
    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif; color: #800000;">New Appointment</h1>
                    <p class="text-sm text-gray-600">Create appointment for <span id="selectedDate" class="font-medium text-blue-600"></span></p>
                </div>
            </div>
        </div>

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-medium">Please fix the following errors:</span>
            </div>
            <ul class="list-disc list-inside text-sm ml-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('company.appointments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Hidden Date Field -->
            <input type="hidden" name="appointment_date" id="appointmentDate" value="{{ old('appointment_date', request('date')) }}">
            @error('appointment_date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <!-- Basic Information Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">Basic Information</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Time Slot -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-clock mr-2 text-blue-600"></i>Time Slot
                        </label>
                        <select name="time_slot" class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg shadow-sm">
                            <option value="">Select a time slot</option>
                            @foreach($timeSlots as $slot)
                            <option value="{{ $slot }}" {{ old('time_slot') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                            @endforeach
                        </select>
                        @error('time_slot')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                 
            <!-- Medical Tests Selection Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-vial mr-2 text-blue-600"></i>Medical Tests Selection
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Select one category and one test for this appointment</p>
                </div>
                <div class="p-6">
                    <input type="hidden" name="medical_test_categories_id" id="medical_test_categories_id" value="{{ old('medical_test_categories_id') }}">
                    <input type="hidden" name="medical_test_id" id="medical_test_id" value="{{ old('medical_test_id') }}">
                    @error('medical_test_categories_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('medical_test_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($medicalTestCategories->count() > 0)
                        <div class="space-y-6">
                            @foreach($medicalTestCategories as $category)
                                @php $categoryName = strtolower(trim($category->name)); @endphp
                                @if($category->medicalTests->count() > 0 && $categoryName !== 'pre-employment')
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h3 class="text-md font-semibold text-gray-900 mb-3" style="font-family: 'Poppins', sans-serif; color: #800000;">
                                            {{ $category->name }}
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                            @foreach($category->medicalTests as $test)
                                                <div class="relative flex items-start space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer group"
                                                     onclick="selectTest({{ $category->id }}, {{ $test->id }})"
                                                     id="container_{{ $test->id }}">
                                                    <input type="radio" 
                                                           name="appointment_selected_test" 
                                                           value="{{ $test->id }}" 
                                                           id="test_{{ $test->id }}" 
                                                           class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded pointer-events-none"
                                                           data-category-id="{{ $category->id }}"
                                                           {{ old('medical_test_id') == $test->id ? 'checked' : '' }}>
                                                    <div class="flex-1 min-w-0">
                                                        <label for="test_{{ $test->id }}" class="block text-sm font-medium text-gray-900 cursor-pointer">
                                                            {{ $test->name }}
                                                        </label>
                                                        @if($test->description)
                                                            <p class="text-xs text-gray-500 mt-1">{{ Str::limit($test->description, 50) }}</p>
                                                        @endif
                                                        <p class="text-sm font-semibold text-green-600 mt-1">₱{{ number_format($test->price, 2) }}</p>
                                                    </div>
                                                    <!-- Selection indicator -->
                                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <i class="fas fa-check-circle text-blue-600 text-lg"></i>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <!-- Selected Test Summary -->
                        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Selected Test Price:</span>
                                <span id="totalPrice" class="text-2xl font-bold text-blue-600">₱0.00</span>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-vial text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Medical Tests Available</h3>
                            <p class="text-gray-500">Please contact the administrator to add medical tests.</p>
                        </div>
                    @endif
                    @error('medical_tests')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- File Upload Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-file-excel mr-2 text-green-600"></i>Patient Data Upload (Optional)
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Upload Excel file with patient information</p>
                </div>
                <div class="p-6">
                    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                            <div class="text-sm text-blue-800">
                                <p class="font-medium mb-1">Important Notes:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Patients with duplicate names and emails will be automatically skipped</li>
                                    <li>Only one appointment per date and time slot is allowed</li>
                                    <li>Excel file should contain: First Name, Last Name, Age, Sex, Email, Phone</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload Area -->
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors" id="uploadArea">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="excel_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload a file</span>
                                    <input id="excel_file" name="excel_file" type="file" class="sr-only" accept=".xlsx,.xls" onchange="handleFileSelect(this)">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">Excel files only (.xlsx, .xls)</p>
                        </div>
                    </div>

                    <!-- File Preview -->
                    <div id="filePreview" class="hidden mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-file-excel text-green-600 mr-3"></i>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-green-800" id="fileName"></p>
                                <p class="text-xs text-green-600" id="fileSize"></p>
                            </div>
                            <button type="button" onclick="clearFile()" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    @error('excel_file')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Notes Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-sticky-note mr-2 text-yellow-600"></i>Additional Notes
                    </h2>
                </div>
                <div class="p-6">
                    <textarea name="notes" rows="4" 
                              class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border border-gray-300 rounded-lg p-3"
                              placeholder="Enter any additional notes or special instructions...">{{ old('notes') }}</textarea>
                    @error('notes')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 pt-6">
                <a href="{{ route('company.appointments.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-sm">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Create Appointment
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Medical test prices for calculation
    const testPrices = {
        @foreach($medicalTestCategories as $category)
            @foreach($category->medicalTests as $test)
                {{ $test->id }}: {{ $test->price }},
            @endforeach
        @endforeach
    };

    document.addEventListener('DOMContentLoaded', function() {
        // Get date from URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const selectedDate = urlParams.get('date');
        
        if (selectedDate) {
            // Set the hidden date field if still empty
            const dateInput = document.getElementById('appointmentDate');
            if (!dateInput.value) {
                dateInput.value = selectedDate;
            }
            
            // Format and display the selected date
            const date = new Date(selectedDate);
            const formattedDate = date.toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            document.getElementById('selectedDate').textContent = formattedDate;
        } else {
            // If no date selected, redirect back to calendar
            window.location.href = '{{ route("company.appointments.index") }}';
        }

        // Initialize total price calculation
        updateTotalPrice();
    });

    function selectTest(categoryId, testId) {
        const previousSelected = document.querySelector('input[name="appointment_selected_test"]:checked');
        if (previousSelected && parseInt(previousSelected.value) === testId) {
            // already selected via clicking container; nothing to do
        }
        // Check the radio
        const radio = document.getElementById('test_' + testId);
        radio.checked = true;
        // Update hidden inputs
        document.getElementById('medical_test_categories_id').value = String(categoryId);
        document.getElementById('medical_test_id').value = String(testId);
        // Restyle all containers
        document.querySelectorAll('[id^="container_"]').forEach(c => c.classList.remove('bg-blue-50','border-blue-300'));
        const container = document.getElementById('container_' + testId);
        container.classList.add('bg-blue-50','border-blue-300');
        // Update price
        updateTotalPrice(testId);
    }

    function updateTotalPrice(testId) {
        const price = testPrices[testId] || 0;
        document.getElementById('totalPrice').textContent = '₱' + Number(price).toFixed(2);
    }

    // Handle file selection and preview
    function handleFileSelect(input) {
        const file = input.files[0];
        if (file) {
            const fileName = file.name;
            const fileSize = formatFileSize(file.size);
            
            document.getElementById('fileName').textContent = fileName;
            document.getElementById('fileSize').textContent = fileSize;
            document.getElementById('filePreview').classList.remove('hidden');
            document.getElementById('uploadArea').classList.add('hidden');
        }
    }

    // Clear file selection
    function clearFile() {
        document.getElementById('excel_file').value = '';
        document.getElementById('filePreview').classList.add('hidden');
        document.getElementById('uploadArea').classList.remove('hidden');
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Drag and drop functionality
    const uploadArea = document.getElementById('uploadArea');
    
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('border-blue-400', 'bg-blue-50');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const fileInput = document.getElementById('excel_file');
            fileInput.files = files;
            handleFileSelect(fileInput);
        }
    });
</script>
@endpush
@endsection