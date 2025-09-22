@extends('layouts.company')

@section('title', 'New Pre-Employment File')

@section('content')
<div class="min-h-screen" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-user-plus mr-3"></i>New Pre-Employment File
                        </h1>
                        <p class="text-blue-100">Create a new pre-employment medical record</p>
                    </div>
                    <div>
                        <a href="{{ route('company.pre-employment.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 transition-all duration-200 shadow-sm">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        @if(session('error'))
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-red-600 to-red-700">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-white text-xl mr-3"></i>
                    <span class="text-white font-medium">{{ session('error') }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Main Form -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <form action="{{ route('company.pre-employment.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf

                <!-- Excel File Upload Section -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-green-600">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">
                            <i class="fas fa-file-excel mr-2 text-green-600"></i>Excel File Upload
                        </h3>
                        <p class="text-sm text-gray-600">Required Format: First Name, Last Name, Age, Sex, Email, Phone Number</p>
                    </div>
                    
                    <!-- Info Alert -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-600 text-lg mr-3 mt-0.5"></i>
                            <div>
                                <h4 class="text-sm font-semibold text-blue-800 mb-1">Duplicate Prevention</h4>
                                <p class="text-sm text-blue-700">Records with the same first name, last name, and email will be automatically skipped to prevent duplicates.</p>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload Area -->
                    <div id="upload-area" class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-green-400 transition-colors duration-200">
                        <div class="space-y-4">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                                <i class="fas fa-cloud-upload-alt text-green-600 text-2xl"></i>
                            </div>
                            <div>
                                <label for="excel_file" class="cursor-pointer">
                                    <span class="text-lg font-semibold text-green-600 hover:text-green-700">Choose Excel File</span>
                                    <input id="excel_file" name="excel_file" type="file" class="sr-only" accept=".xlsx,.xls">
                                </label>
                                <p class="text-gray-500 mt-1">or drag and drop your file here</p>
                            </div>
                            <p class="text-sm text-gray-400">Supports: .xlsx, .xls files only</p>
                        </div>
                    </div>

                    <!-- File Preview Area -->
                    <div id="file-preview" class="hidden mt-6">
                        <div class="bg-white rounded-lg border border-green-200 overflow-hidden">
                            <div class="bg-green-50 px-4 py-3 border-b border-green-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-excel text-green-600 text-lg mr-2"></i>
                                        <span id="file-name" class="font-semibold text-green-800"></span>
                                    </div>
                                    <button type="button" onclick="removeFile()" class="text-red-600 hover:text-red-800 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="mb-4">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">File Preview:</h4>
                                    <div id="preview-stats" class="text-sm text-gray-600 mb-3"></div>
                                </div>
                                <div class="overflow-x-auto">
                                    <table id="preview-table" class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr id="preview-headers"></tr>
                                        </thead>
                                        <tbody id="preview-body" class="bg-white divide-y divide-gray-200"></tbody>
                                    </table>
                                </div>
                                <div id="preview-more" class="mt-3 text-center hidden">
                                    <p class="text-sm text-gray-500">... and more rows</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @error('excel_file')
                    <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    </div>
                    @enderror
                </div>


                <!-- Medical Tests Selection -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-purple-600">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">
                            <i class="fas fa-flask mr-2 text-purple-600"></i>Medical Tests Selection
                        </h3>
                        <p class="text-sm text-gray-600">Choose the medical tests required for this pre-employment examination</p>
                    </div>

                    <input type="hidden" name="medical_test_categories_id" id="medical_test_categories_id" value="{{ old('medical_test_categories_id') }}">
                    <input type="hidden" name="medical_test_id" id="medical_test_id" value="{{ old('medical_test_id') }}">
                    
                    <!-- Error Messages -->
                    @error('medical_test_categories_id')
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    </div>
                    @enderror
                    @error('medical_test_id')
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    </div>
                    @enderror

                    @php
                        $uniqueCategories = $medicalTestCategories->unique(function($c){ return strtolower($c->name ?? ''); });
                    @endphp
                    @foreach($uniqueCategories as $index => $category)
                        @php 
                            $categoryName = strtolower(trim($category->name)); 
                            $uniqueTests = $category->activeMedicalTests->unique(function($t){ return strtolower($t->name ?? ''); });
                        @endphp
                        <div class="mb-6 last:mb-0">
                            <!-- Collapsible Category Header -->
                            <div class="bg-white rounded-lg border-l-4 border-indigo-600 overflow-hidden">
                                <button type="button" 
                                        class="w-full p-4 text-left hover:bg-indigo-50 transition-colors duration-200 focus:outline-none focus:bg-indigo-50"
                                        onclick="toggleCategory('category-{{ $category->id }}')">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-xl font-bold text-indigo-900 mb-1">
                                                <i class="fas fa-vial mr-2"></i>{{ $category->name }}
                                            </h4>
                                            @if($category->description)
                                                <p class="text-sm text-indigo-700">{{ $category->description }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span id="selected-count-{{ $category->id }}" class="text-sm font-medium text-indigo-600 bg-indigo-100 px-2 py-1 rounded-full hidden">
                                                0 selected
                                            </span>
                                            <i id="chevron-{{ $category->id }}" class="fas fa-chevron-down text-indigo-600 transform transition-transform duration-200"></i>
                                        </div>
                                    </div>
                                </button>
                                
                                <!-- Collapsible Content -->
                                <div id="category-{{ $category->id }}" class="hidden border-t border-indigo-100">
                                    <div class="p-4 bg-indigo-50">
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach($uniqueTests as $test)
                                                @if($categoryName === 'appointment')
                                                    @continue
                                                @endif
                                                <label for="pe_test_{{ $test->id }}" class="cursor-pointer block">
                                                    <div class="bg-white rounded-lg p-5 border-2 border-gray-200 hover:border-blue-400 hover:shadow-md transition-all duration-200">
                                                        <div class="flex items-start">
                                                            <input
                                                                id="pe_test_{{ $test->id }}"
                                                                type="checkbox"
                                                                name="pe_selected_test"
                                                                value="{{ $test->id }}"
                                                                data-category-id="{{ $category->id }}"
                                                                data-test-id="{{ $test->id }}"
                                                                class="mt-1 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded category-checkbox"
                                                            >
                                                            <div class="ml-3 flex-1">
                                                                <h5 class="text-base font-bold text-gray-900 mb-1">{{ $test->name }}</h5>
                                                                @if($test->description)
                                                                    <p class="text-sm text-gray-600 mb-2">{{ Str::limit($test->description, 60) }}</p>
                                                                @endif
                                                                @if(!is_null($test->price))
                                                                    <div class="bg-emerald-50 rounded-lg px-3 py-1 inline-block">
                                                                        <p class="text-sm font-bold text-emerald-700">₱{{ number_format((float)$test->price, 2) }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @error('blood_tests')
                    <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    </div>
                    @enderror
                </div>

                <!-- Package and Other Exams -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-amber-600">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">
                            <i class="fas fa-clipboard-list mr-2 text-amber-600"></i>Package and Other Exams
                        </h3>
                        <p class="text-sm text-gray-600">Specify any additional examination packages or special requirements</p>
                    </div>
                    <textarea name="package_other_exams" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 resize-none"
                              placeholder="Enter additional examination packages or requirements..."></textarea>
                    @error('package_other_exams')
                    <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    </div>
                    @enderror
                </div>

                <!-- Billing Information -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-blue-600">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">
                            <i class="fas fa-credit-card mr-2 text-blue-600"></i>Billing Information
                        </h3>
                        <p class="text-sm text-gray-600">Select who will be responsible for the medical examination fees</p>
                    </div>
                    <div class="space-y-4">
                        <label class="flex items-center p-4 bg-white rounded-lg border-2 border-gray-200 cursor-pointer hover:border-blue-400 transition-colors duration-200">
                            <input type="radio" name="billing_type" value="Patient" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <div class="ml-4">
                                <span class="text-base font-semibold text-gray-900">Bill to Patient</span>
                                <p class="text-sm text-gray-600">Patient will pay directly for the examination</p>
                            </div>
                        </label>
                        <label class="flex items-center p-4 bg-white rounded-lg border-2 border-blue-400 cursor-pointer bg-blue-50">
                            <input type="radio" name="billing_type" value="Company" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                            <div class="ml-4">
                                <span class="text-base font-semibold text-blue-900">Bill to Company</span>
                                <p class="text-sm text-blue-700">Company will be invoiced for the examination</p>
                            </div>
                        </label>
                    </div>
                    @error('billing_type')
                    <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    </div>
                    @enderror
                </div>

                <!-- Company Name -->
                <div id="companyNameField" class="bg-gray-50 rounded-xl p-6 border-l-4 border-indigo-600">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">
                            <i class="fas fa-building mr-2 text-indigo-600"></i>Company Information
                        </h3>
                        <p class="text-sm text-gray-600">Enter the company name for billing purposes</p>
                    </div>
                    <input type="text" name="company_name" value="{{ Auth::user()->company }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           placeholder="Enter company name">
                    @error('company_name')
                    <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    </div>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('company.pre-employment.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Create Pre-Employment File
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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

        // Handle file input and preview
        const fileInput = document.getElementById('excel_file');
        const uploadArea = document.getElementById('upload-area');
        const filePreview = document.getElementById('file-preview');

        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                previewExcelFile(file);
            }
        });

        function previewExcelFile(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array' });
                    const firstSheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[firstSheetName];
                    const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
                    
                    displayPreview(file.name, jsonData);
                } catch (error) {
                    console.error('Error reading Excel file:', error);
                    alert('Error reading Excel file. Please make sure it\'s a valid Excel file.');
                }
            };
            reader.readAsArrayBuffer(file);
        }

        function displayPreview(fileName, data) {
            // Show file name
            document.getElementById('file-name').textContent = fileName;
            
            // Show stats
            const totalRows = data.length - 1; // Exclude header
            document.getElementById('preview-stats').textContent = `${totalRows} record(s) found`;
            
            // Clear previous preview
            const headersRow = document.getElementById('preview-headers');
            const bodyElement = document.getElementById('preview-body');
            headersRow.innerHTML = '';
            bodyElement.innerHTML = '';
            
            if (data.length > 0) {
                // Add headers
                const headers = data[0];
                headers.forEach(header => {
                    const th = document.createElement('th');
                    th.className = 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider';
                    th.textContent = header || 'Column';
                    headersRow.appendChild(th);
                });
                
                // Add data rows (limit to first 5 rows for preview)
                const previewRows = data.slice(1, 6);
                previewRows.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-gray-50';
                    
                    headers.forEach((header, index) => {
                        const td = document.createElement('td');
                        td.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-900';
                        td.textContent = row[index] || '';
                        tr.appendChild(td);
                    });
                    
                    bodyElement.appendChild(tr);
                });
                
                // Show "more rows" indicator if there are more than 5 rows
                const moreIndicator = document.getElementById('preview-more');
                if (data.length > 6) {
                    moreIndicator.classList.remove('hidden');
                } else {
                    moreIndicator.classList.add('hidden');
                }
            }
            
            // Hide upload area and show preview
            uploadArea.classList.add('hidden');
            filePreview.classList.remove('hidden');
        }

        // Medical test category selection handling - Allow one test per category
        const hiddenCategoryInput = document.getElementById('medical_test_categories_id');
        const hiddenTestInput = document.getElementById('medical_test_id');
        const testCheckboxes = document.querySelectorAll('input[name="pe_selected_test"][data-category-id]');

        function updateHiddenInputs() {
            const checkedTests = Array.from(testCheckboxes).filter(cb => cb.checked);
            if (checkedTests.length > 0) {
                // For multiple tests, we'll send arrays to the backend
                const categoryIds = checkedTests.map(cb => cb.getAttribute('data-category-id'));
                const testIds = checkedTests.map(cb => cb.getAttribute('data-test-id'));
                
                // Store as JSON arrays for the backend to process
                hiddenCategoryInput.value = JSON.stringify(categoryIds);
                hiddenTestInput.value = JSON.stringify(testIds);
            } else {
                hiddenCategoryInput.value = '';
                hiddenTestInput.value = '';
            }
        }

        function handleTestChange(e) {
            const current = e.target;
            const currentCategoryId = current.getAttribute('data-category-id');

            if (current.checked) {
                // If checking a test, uncheck other tests in the same category (one per category rule)
                Array.from(testCheckboxes).forEach(cb => {
                    if (cb !== current && cb.getAttribute('data-category-id') === currentCategoryId) {
                        cb.checked = false;
                    }
                });
            }

            // Update hidden inputs with current selections
            updateHiddenInputs();
            
            // Update the category counter after the selection logic
            updateCategoryCount(currentCategoryId);
        }

        testCheckboxes.forEach(cb => cb.addEventListener('change', handleTestChange));
        
        // Initialize on page load
        updateHiddenInputs();

        // Add form submission debugging
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            console.log('=== PRE-EMPLOYMENT FORM SUBMISSION DEBUG ===');
            
            // Check Excel file
            const excelFile = document.getElementById('excel_file').files[0];
            console.log('Excel file selected:', excelFile ? excelFile.name : 'None');
            
            // Check medical tests selection
            const checkedTests = Array.from(testCheckboxes).filter(cb => cb.checked);
            console.log('Selected tests count:', checkedTests.length);
            
            if (checkedTests.length === 0) {
                console.log('ERROR: No medical tests selected');
                e.preventDefault();
                alert('Please select at least one medical test before submitting.');
                return;
            }
            
            // Check hidden inputs
            const categoryInput = document.getElementById('medical_test_categories_id');
            const testInput = document.getElementById('medical_test_id');
            console.log('Hidden category input value:', categoryInput.value);
            console.log('Hidden test input value:', testInput.value);
            
            // Check billing type
            const billingType = document.querySelector('input[name="billing_type"]:checked');
            console.log('Billing type selected:', billingType ? billingType.value : 'None');
            
            // Check company name if billing to company
            if (billingType && billingType.value === 'Company') {
                const companyName = document.querySelector('input[name="company_name"]').value;
                console.log('Company name:', companyName);
                if (!companyName.trim()) {
                    console.log('ERROR: Company name is required when billing to company');
                    e.preventDefault();
                    alert('Please enter a company name when billing to company.');
                    return;
                }
            }
            
            // Log all form data
            const formData = new FormData(form);
            console.log('Form data being submitted:');
            for (let [key, value] of formData.entries()) {
                console.log(`  ${key}:`, value);
            }
            
            console.log('Form validation passed - submitting form');
            console.log('=== END PRE-EMPLOYMENT FORM DEBUG ===');
        });
    });

    // Collapsible category functions
    function toggleCategory(categoryId) {
        const content = document.getElementById(categoryId);
        const chevron = document.getElementById('chevron-' + categoryId.replace('category-', ''));
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            chevron.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            chevron.classList.remove('rotate-180');
        }
    }

    function updateCategoryCount(categoryId) {
        const categoryCheckboxes = document.querySelectorAll(`input[data-category-id="${categoryId}"]`);
        const checkedCount = Array.from(categoryCheckboxes).filter(cb => cb.checked).length;
        const countElement = document.getElementById(`selected-count-${categoryId}`);
        
        if (checkedCount > 0) {
            countElement.textContent = `${checkedCount} selected`;
            countElement.classList.remove('hidden');
        } else {
            countElement.classList.add('hidden');
        }
    }

    // Remove file function
    function removeFile() {
        const fileInput = document.getElementById('excel_file');
        const uploadArea = document.getElementById('upload-area');
        const filePreview = document.getElementById('file-preview');
        
        // Clear file input
        fileInput.value = '';
        
        // Show upload area and hide preview
        uploadArea.classList.remove('hidden');
        filePreview.classList.add('hidden');
    }
</script>
@endpush
@endsection 