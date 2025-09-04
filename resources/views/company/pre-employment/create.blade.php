@extends('layouts.company')

@section('title', 'New Pre-Employment File')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">New Pre-Employment File</h1>
        </div>

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif



        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('company.pre-employment.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
                @csrf

                <!-- Excel File Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Excel File (Required Format: First Name, Last Name, Age, Sex, Email, Phone Number)
                    </label>
                    <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>Duplicate Prevention:</strong> Records with the same first name, last name, and email will be automatically skipped to prevent duplicates.
                        </p>
                    </div>
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

                <!-- Medical Examination Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Medical Examination Type</label>
                    <select name="medical_exam_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="Pre-Employment Medical Examination">Pre-Employment Medical Examination</option>
                        <option value="Pre-Employment with Drug Test">Pre-Employment with Drug Test</option>
                        <option value="Pre-Employment with ECG & Drug Test">Pre-Employment with ECG & Drug Test</option>
                        <option value="Pre-Employment with Drug Test Audio and Ishihara">Pre-Employment with Drug Test Audio and Ishihara</option>
                        <option value="X-ray Only">X-ray Only</option>
                    </select>
                    @error('medical_exam_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Blood Chemistry -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tint mr-2"></i>Blood Chemistry
                    </label>
                    <div class="mt-2 space-y-2">
                        @foreach($bloodTests as $test)
                        <div class="flex items-center">
                            <input type="checkbox" name="blood_tests[]" value="{{ $test }}" id="blood{{ $loop->index + 1 }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="blood{{ $loop->index + 1 }}" class="ml-2 block text-sm text-gray-900">{{ $test }}</label>
                        </div>
                        @endforeach
                    </div>
                    @error('blood_tests')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Package and Other Exams -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Package and Other Exams</label>
                    <textarea name="package_other_exams" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                    @error('package_other_exams')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Billing Information -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Billing Type</label>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center">
                            <input type="radio" name="billing_type" value="Patient" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <label class="ml-2 block text-sm text-gray-900">Bill to Patient</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="billing_type" value="Company" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                            <label class="ml-2 block text-sm text-gray-900">Bill to Company</label>
                        </div>
                    </div>
                    @error('billing_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company Name -->
                <div id="companyNameField">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                    <input type="text" name="company_name" value="{{ Auth::user()->company }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">
                    @error('company_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-5">
                    <div class="flex justify-end">
                        <a href="{{ route('company.pre-employment.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create
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
        const billingTypeInputs = document.querySelectorAll('input[name="billing_type"]');
        const companyNameField = document.getElementById('companyNameField');

        function toggleCompanyName() {
            const selectedValue = document.querySelector('input[name="billing_type"]:checked').value;
            companyNameField.classList.toggle('hidden', selectedValue !== 'Company');
        }

        billingTypeInputs.forEach(input => {
            input.addEventListener('change', toggleCompanyName);
        });

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