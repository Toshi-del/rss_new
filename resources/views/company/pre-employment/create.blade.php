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


                <!-- Medical Tests by Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-4">
                        <i class="fas fa-flask mr-2"></i>Medical Tests
                        <span class="text-sm text-gray-500 font-normal">(Select one test per category)</span>
                    </label>

                    <input type="hidden" name="medical_test_categories_id" id="medical_test_categories_id" value="{{ is_array(old('medical_test_categories_id')) ? json_encode(old('medical_test_categories_id')) : old('medical_test_categories_id') }}">
                    <input type="hidden" name="medical_test_id" id="medical_test_id" value="{{ is_array(old('medical_test_id')) ? json_encode(old('medical_test_id')) : old('medical_test_id') }}">
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
                            $uniqueTests = $category->activeMedicalTests->unique(function($t){ return strtolower($t->name ?? ''); });
                        @endphp
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold mb-3" style="color:#800000;">
                                {{ $category->name }}
                                @if($category->description)
                                    <span class="text-sm text-gray-500 font-normal">- {{ $category->description }}</span>
                                @endif
                                <span class="text-xs text-blue-600 font-normal">(Select one)</span>
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                                @foreach($uniqueTests as $test)
                                    @if($categoryName === 'appointment')
                                        @continue
                                    @endif
                                    <label for="test_{{ $test->id }}" class="cursor-pointer block border rounded-xl p-5 hover:shadow-lg transition-all duration-200 bg-white hover:border-blue-300 h-40 flex flex-col test-card">
                                        <div class="flex items-start mb-3">
                                            <input
                                                id="test_{{ $test->id }}"
                                                type="radio"
                                                name="category_{{ $category->id }}_test"
                                                value="{{ $test->id }}"
                                                data-category-id="{{ $category->id }}"
                                                data-category-name="{{ $category->name }}"
                                                data-test-id="{{ $test->id }}"
                                                data-test-name="{{ $test->name }}"
                                                data-test-price="{{ $test->price ?? 0 }}"
                                                class="mt-1 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 test-radio flex-shrink-0"
                                            >
                                            <div class="ml-3 flex-1 min-w-0">
                                                <p class="text-base font-semibold text-gray-900 line-clamp-2 leading-tight">{{ $test->name }}</p>
                                            </div>
                                        </div>
                                        <div class="flex-1 flex flex-col justify-between">
                                            @if($test->description)
                                                <p class="text-sm text-gray-500 line-clamp-3 mb-2">{{ $test->description }}</p>
                                            @else
                                                <div class="flex-1"></div>
                                            @endif
                                            @if(!is_null($test->price))
                                                <div class="mt-auto">
                                                    <p class="text-lg font-bold text-emerald-600">₱{{ number_format((float)$test->price, 2) }}</p>
                                                </div>
                                            @else
                                                <div class="mt-auto">
                                                    <p class="text-sm text-gray-400 italic">Price not set</p>
                                                </div>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <!-- Selected Tests Summary -->
                    <div id="selectedTestsSummary" class="mt-6 p-4 bg-gray-50 rounded-lg hidden">
                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Selected Tests:</h5>
                        <div id="selectedTestsList" class="space-y-1"></div>
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <p class="text-sm font-semibold text-gray-700">
                                Total Cost: <span id="totalCost" class="text-emerald-600">₱0.00</span>
                            </p>
                        </div>
                    </div>
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
        const fileLabel = fileInput.parentElement.querySelector('span');

        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                fileLabel.textContent = e.target.files[0].name;
            }
        });

        // Medical test selection handling (multiple tests, one per category)
        const testRadios = document.querySelectorAll('.test-radio');
        const selectedTestsSummary = document.getElementById('selectedTestsSummary');
        const selectedTestsList = document.getElementById('selectedTestsList');
        const totalCostElement = document.getElementById('totalCost');
        const medicalTestCategoriesInput = document.getElementById('medical_test_categories_id');
        const medicalTestIdInput = document.getElementById('medical_test_id');

        let selectedTests = [];

        function updateSelectedTestsSummary() {
            // Clear the list
            selectedTestsList.innerHTML = '';
            
            // Add each selected test
            let totalCost = 0;
            selectedTests.forEach(test => {
                const testElement = document.createElement('div');
                testElement.className = 'flex justify-between items-center text-sm';
                testElement.innerHTML = `
                    <span class="text-gray-700">${test.categoryName}: <strong>${test.testName}</strong></span>
                    <span class="text-emerald-600 font-semibold">₱${parseFloat(test.price).toFixed(2)}</span>
                `;
                selectedTestsList.appendChild(testElement);
                totalCost += parseFloat(test.price);
            });

            // Update total cost
            totalCostElement.textContent = `₱${totalCost.toFixed(2)}`;
            
            // Show/hide summary
            selectedTestsSummary.classList.toggle('hidden', selectedTests.length === 0);
            
            // Update hidden inputs with arrays of selected category and test IDs
            if (selectedTests.length > 0) {
                const categoryIds = selectedTests.map(test => test.categoryId);
                const testIds = selectedTests.map(test => test.testId);
                medicalTestCategoriesInput.value = JSON.stringify(categoryIds);
                medicalTestIdInput.value = JSON.stringify(testIds);
            } else {
                medicalTestCategoriesInput.value = '';
                medicalTestIdInput.value = '';
            }
        }

        function handleTestSelection(e) {
            const current = e.target;
            if (!current.checked) return;

            const categoryId = current.getAttribute('data-category-id');
            const categoryName = current.getAttribute('data-category-name');
            const testId = current.getAttribute('data-test-id');
            const testName = current.getAttribute('data-test-name');
            const testPrice = current.getAttribute('data-test-price') || '0';

            // Remove any existing test from the same category
            selectedTests = selectedTests.filter(test => test.categoryId !== categoryId);

            // Add the new test
            selectedTests.push({
                categoryId: categoryId,
                categoryName: categoryName,
                testId: testId,
                testName: testName,
                price: testPrice
            });

            // Update visual selection state
            updateCardSelectionState();
            updateSelectedTestsSummary();
        }

        function updateCardSelectionState() {
            // Remove selected class from all cards
            document.querySelectorAll('.test-card').forEach(card => {
                card.classList.remove('selected');
            });

            // Add selected class to checked cards
            testRadios.forEach(radio => {
                if (radio.checked) {
                    const card = radio.closest('.test-card');
                    if (card) {
                        card.classList.add('selected');
                    }
                }
            });
        }

        // Add event listeners to all test radio buttons
        testRadios.forEach(radio => {
            radio.addEventListener('change', handleTestSelection);
        });
    });
</script>
@endpush
@endsection 