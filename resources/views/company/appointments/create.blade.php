@extends('layouts.company')

@section('title', 'New Appointment')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">New Appointment</h1>
            <p class="text-sm text-gray-600">Create appointment for <span id="selectedDate" class="font-medium"></span></p>
        </div>

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('company.appointments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
                @csrf

                <!-- Hidden Date Field -->
                <input type="hidden" name="appointment_date" id="appointmentDate" value="{{ old('appointment_date', request('date')) }}">
                @error('appointment_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Time Slot -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Time Slot</label>
                    <select name="time_slot" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Select a time slot</option>
                        @foreach($timeSlots as $slot)
                        <option value="{{ $slot }}" {{ old('time_slot') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                        @endforeach
                    </select>
                    @error('time_slot')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Appointment Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Type</label>
                    <select name="appointment_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Select appointment type</option>
                        <option value="ANNUAL MEDICAL EXAMINATION" {{ old('appointment_type') == 'ANNUAL MEDICAL EXAMINATION' ? 'selected' : '' }}>Annual Medical Examination</option>
                        <option value="ANNUAL MEDICAL WITH DRUG TEST" {{ old('appointment_type') == 'ANNUAL MEDICAL WITH DRUG TEST' ? 'selected' : '' }}>Annual Medical with Drug Test</option>
                        <option value="ANNUAL MEDICAL WITH ECG" {{ old('appointment_type') == 'ANNUAL MEDICAL WITH ECG' ? 'selected' : '' }}>Annual Medical with ECG</option>
                        <option value="ANNUAL MEDICAL COMPLETE" {{ old('appointment_type') == 'ANNUAL MEDICAL COMPLETE' ? 'selected' : '' }}>Annual Medical Complete</option>
                    </select>
                    @error('appointment_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Blood Chemistry -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tint mr-2"></i>Blood Chemistry
                    </label>
                    <div class="mt-2 space-y-2">
                        @foreach($bloodChemistry as $test)
                        <div class="flex items-center">
                            <input type="checkbox" name="blood_chemistry[]" value="{{ $test }}" id="blood{{ $loop->index + 1 }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" {{ in_array($test, old('blood_chemistry', [])) ? 'checked' : '' }}>
                            <label for="blood{{ $loop->index + 1 }}" class="ml-2 block text-sm text-gray-900">{{ $test }}</label>
                        </div>
                        @endforeach
                    </div>
                    @error('blood_chemistry')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excel File Upload (Optional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Excel File (Optional - Upload patient data)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="excel_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload a file</span>
                                    <input id="excel_file" name="excel_file" type="file" class="sr-only" accept=".xlsx,.xls">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">Excel files only</p>
                        </div>
                    </div>
                    @error('excel_file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('notes') }}</textarea>
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
                            Create Appointment
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

        // Handle file input display
        const fileInput = document.getElementById('excel_file');
        const fileLabel = fileInput.nextElementSibling;

        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                fileLabel.textContent = e.target.files[0].name;
            }
        });
    });
</script>
@endpush
@endsection