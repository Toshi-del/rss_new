@extends('layouts.company')

@section('title', 'Edit Pre-Employment Record')
@section('page-description', 'Edit medical examination record for ' . $record->full_name)

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('company.pre-employment.show', $record->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Record
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Pre-Employment Record</h1>
                <p class="text-gray-600 mt-1">Update medical examination record for {{ $record->full_name }}</p>
            </div>
        </div>
    </div>

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl shadow-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-3 text-red-600"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Update Record Information</h2>
            <p class="text-gray-600 text-sm mt-1">Modify the medical tests and billing information</p>
        </div>

        <form action="{{ route('company.pre-employment.update', $record->id) }}" method="POST" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <!-- Employee Information (Read-only) -->
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Employee Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <p class="text-gray-900 font-medium">{{ $record->full_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Age & Gender</label>
                        <p class="text-gray-900">{{ $record->age }} years old • {{ $record->sex }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact</label>
                        <p class="text-gray-900">{{ $record->email }}</p>
                        <p class="text-gray-600 text-sm">{{ $record->phone_number }}</p>
                    </div>
                </div>
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
                    $selectedTests = $record->preEmploymentMedicalTests;
                @endphp
                @foreach($uniqueCategories as $category)
                    @php 
                        $categoryName = strtolower(trim($category->name)); 
                        $uniqueTests = $category->activeMedicalTests->unique(function($t){ return strtolower($t->name ?? ''); });
                        $selectedTestInCategory = $selectedTests->where('medical_test_category_id', $category->id)->first();
                    @endphp
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold mb-3" style="color:#1e40af;">
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
                                <label for="test_{{ $test->id }}" class="cursor-pointer block border rounded-xl p-5 hover:shadow-lg transition-all duration-200 bg-white hover:border-blue-300 h-40 flex flex-col test-card {{ $selectedTestInCategory && $selectedTestInCategory->medical_test_id == $test->id ? 'selected border-blue-500 bg-blue-50' : '' }}">
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
                                            {{ $selectedTestInCategory && $selectedTestInCategory->medical_test_id == $test->id ? 'checked' : '' }}
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
                <div id="selectedTestsSummary" class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h5 class="text-sm font-semibold text-gray-700 mb-2">Selected Tests:</h5>
                    <div id="selectedTestsList" class="space-y-1"></div>
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <p class="text-sm font-semibold text-gray-700">
                            Total Cost: <span id="totalCost" class="text-emerald-600">₱{{ number_format($record->total_price, 2) }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Package and Other Exams -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Package and Other Exams</label>
                <textarea name="package_other_exams" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('package_other_exams', $record->other_exams) }}</textarea>
                @error('package_other_exams')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Billing Information -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Billing Type</label>
                <div class="mt-2 space-y-2">
                    <div class="flex items-center">
                        <input type="radio" name="billing_type" value="Patient" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('billing_type', $record->billing_type) === 'Patient' ? 'checked' : '' }}>
                        <label class="ml-2 block text-sm text-gray-900">Bill to Patient</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="billing_type" value="Company" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('billing_type', $record->billing_type) === 'Company' ? 'checked' : '' }}>
                        <label class="ml-2 block text-sm text-gray-900">Bill to Company</label>
                    </div>
                </div>
                @error('billing_type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Company Name -->
            <div id="companyNameField" class="{{ old('billing_type', $record->billing_type) !== 'Company' ? 'hidden' : '' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                <input type="text" name="company_name" value="{{ old('company_name', $record->company_name) }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">
                @error('company_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-5">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('company.pre-employment.show', $record->id) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Record
                    </button>
                </div>
            </div>
        </form>
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

        // Medical test selection handling (same as create form)
        const testRadios = document.querySelectorAll('.test-radio');
        const selectedTestsSummary = document.getElementById('selectedTestsSummary');
        const selectedTestsList = document.getElementById('selectedTestsList');
        const totalCostElement = document.getElementById('totalCost');
        const medicalTestCategoriesInput = document.getElementById('medical_test_categories_id');
        const medicalTestIdInput = document.getElementById('medical_test_id');

        let selectedTests = [];

        function updateSelectedTestsSummary() {
            selectedTestsList.innerHTML = '';
            
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

            totalCostElement.textContent = `₱${totalCost.toFixed(2)}`;
            selectedTestsSummary.classList.toggle('hidden', selectedTests.length === 0);
            
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

            selectedTests = selectedTests.filter(test => test.categoryId !== categoryId);

            selectedTests.push({
                categoryId: categoryId,
                categoryName: categoryName,
                testId: testId,
                testName: testName,
                price: testPrice
            });

            updateCardSelectionState();
            updateSelectedTestsSummary();
        }

        function updateCardSelectionState() {
            document.querySelectorAll('.test-card').forEach(card => {
                card.classList.remove('selected', 'border-blue-500', 'bg-blue-50');
            });

            testRadios.forEach(radio => {
                if (radio.checked) {
                    const card = radio.closest('.test-card');
                    if (card) {
                        card.classList.add('selected', 'border-blue-500', 'bg-blue-50');
                    }
                }
            });
        }

        testRadios.forEach(radio => {
            radio.addEventListener('change', handleTestSelection);
        });

        // Initialize with existing selections
        function initializeExistingSelections() {
            testRadios.forEach(radio => {
                if (radio.checked) {
                    selectedTests.push({
                        categoryId: radio.getAttribute('data-category-id'),
                        categoryName: radio.getAttribute('data-category-name'),
                        testId: radio.getAttribute('data-test-id'),
                        testName: radio.getAttribute('data-test-name'),
                        price: radio.getAttribute('data-test-price') || '0'
                    });
                }
            });
            updateCardSelectionState();
            updateSelectedTestsSummary();
        }

        initializeExistingSelections();
    });
</script>
@endpush
@endsection
