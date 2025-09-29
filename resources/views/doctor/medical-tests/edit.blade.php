@extends('layouts.doctor')

@section('title', 'Edit Reference Ranges - ' . $test->name)
@section('page-title', 'Edit Reference Ranges')
@section('page-description', 'Update reference ranges for medical test')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-8">
            
            <!-- Header Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-600 mb-8">
        <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2">
                        <i class="fas fa-chart-line mr-3"></i>Edit Reference Ranges
                    </h1>
                    <p class="text-blue-100">Update reference ranges for medical test</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-800 bg-opacity-50 rounded-lg px-4 py-2 border border-blue-500">
                        <p class="text-blue-200 text-sm font-medium">Test ID</p>
                        <p class="text-white text-lg font-bold">#{{ $test->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

            <!-- Current Test Information -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="px-8 py-6 bg-gradient-to-r from-green-600 to-green-700 border-l-4 border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">
                        <i class="fas fa-info-circle mr-3"></i>Current Test Information
                    </h2>
                    <p class="text-green-100 mt-1">Current details of the medical test</p>
                </div>
            </div>
        </div>
        
        <div class="p-8 bg-green-50">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg p-6 border-l-4 border-blue-500 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">Test Name</label>
                    <div class="text-lg font-bold text-blue-800">{{ $test->name }}</div>
                </div>
                <div class="bg-white rounded-lg p-6 border-l-4 border-green-500 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">Category</label>
                    <div class="text-lg font-bold text-green-800">{{ $test->category->name ?? 'No Category' }}</div>
                </div>
                <div class="bg-white rounded-lg p-6 border-l-4 border-yellow-500 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">Current Price</label>
                    <div class="text-lg font-bold text-yellow-800">₱{{ number_format($test->price, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

            <!-- Edit Form -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="px-8 py-6 bg-gradient-to-r from-purple-600 to-purple-700 border-l-4 border-purple-800">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">
                        <i class="fas fa-chart-line mr-3"></i>Reference Ranges Management
                    </h2>
                    <p class="text-purple-100 mt-1">Doctors can only edit reference ranges for medical tests</p>
                </div>
            </div>
        </div>
        
        <div class="p-8">
            <form action="{{ route('medical-tests.update', $test->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PATCH')
                
                <!-- Read-only Fields Section -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-lock mr-2 text-gray-600"></i>
                        Read-Only Test Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Test Name (Read-only) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-vial mr-2 text-indigo-600"></i>Test Name
                            </label>
                            <div class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white text-gray-700 shadow-sm">
                                {{ $test->name }}
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>This field is read-only for doctors
                            </p>
                        </div>

                        <!-- Category (Read-only) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-list-alt mr-2 text-green-600"></i>Test Category
                            </label>
                            <div class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white text-gray-700 shadow-sm">
                                {{ $test->category->name ?? 'No Category' }}
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>This field is read-only for doctors
                            </p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Test Description (Read-only) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-align-left mr-2 text-blue-600"></i>Description
                            </label>
                            <div class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white text-gray-700 min-h-[100px] shadow-sm">
                                {{ $test->description ?: 'No description provided' }}
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>This field is read-only for doctors
                            </p>
                        </div>

                        <!-- Test Price (Read-only) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-dollar-sign mr-2 text-yellow-600"></i>Test Price
                            </label>
                            <div class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white text-gray-700 shadow-sm">
                                ₱{{ number_format($test->price, 2) }}
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>This field is read-only for doctors
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reference Ranges Section -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-chart-line mr-2 text-purple-600"></i>Reference Ranges
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Define normal ranges for test parameters</p>
                        </div>
                        <button type="button" id="addReferenceRange" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-purple-700 bg-purple-100 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i>
                            Add Reference Range
                        </button>
                    </div>
                    
                    <div id="referenceRangesContainer" class="space-y-4">
                        @if($test->referenceRanges->count() > 0)
                            @foreach($test->referenceRanges as $index => $range)
                            <div class="reference-range-item bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-sm font-semibold text-gray-800 flex items-center">
                                        <i class="fas fa-ruler mr-2 text-purple-500"></i>
                                        Reference Range #{{ $index + 1 }}
                                    </h4>
                                    <button type="button" class="remove-reference-range text-red-500 hover:text-red-700 focus:outline-none p-2 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Reference Name</label>
                                        <input type="text" name="reference_ranges[{{ $index }}][reference_name]" 
                                               value="{{ old('reference_ranges.'.$index.'.reference_name', $range->reference_name) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm"
                                               placeholder="e.g., Color, Protein, Albumin">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Reference Range</label>
                                        <input type="text" name="reference_ranges[{{ $index }}][reference_range]" 
                                               value="{{ old('reference_ranges.'.$index.'.reference_range', $range->reference_range) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm"
                                               placeholder="e.g., Yellowish = Normal, 66-83, 35-52">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-chart-line text-3xl mb-3"></i>
                                <p>No reference ranges defined yet.</p>
                                <p class="text-sm">Click "Add Reference Range" to add reference values for this test.</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Reference Range Examples</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p><strong>Color:</strong> Yellowish = Normal</p>
                                    <p><strong>Protein:</strong> 66-83 g/L</p>
                                    <p><strong>Albumin:</strong> 35-52 g/L</p>
                                    <p><strong>Glucose:</strong> 70-100 mg/dL (Fasting)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                    <a href="{{ route('medical-tests.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Cancel
                    </a>
                    
                    <div class="flex items-center space-x-4">
                        @if($test->category)
                        <a href="{{ route('medical-test-categories.show', $test->category->id) }}" 
                           class="inline-flex items-center px-6 py-3 border border-blue-300 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <i class="fas fa-eye mr-2"></i>
                            View Category
                        </a>
                        @endif
                        
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                            <i class="fas fa-save mr-2"></i>
                            Update Reference Ranges
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

            <!-- Doctor Permissions Information -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="px-8 py-6 bg-gradient-to-r from-blue-500 to-blue-600 border-l-4 border-blue-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">
                        <i class="fas fa-user-md mr-3"></i>Doctor Permissions
                    </h2>
                    <p class="text-blue-100 mt-1">Information about what doctors can edit</p>
                </div>
            </div>
        </div>
        
        <div class="p-8 bg-blue-50">
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chart-line text-purple-600 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-purple-800">Reference Ranges</h3>
                        <p class="text-sm text-purple-700">Doctors can add, edit, and remove reference ranges for medical tests to help with result interpretation.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lock text-gray-600 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-800">Read-Only Fields</h3>
                        <p class="text-sm text-gray-700">Test name, description, price, and category can only be modified by administrators.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Reference Range Usage</h3>
                        <p class="text-sm text-blue-700">Reference ranges will be displayed in pre-employment examinations to help doctors interpret test results.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let referenceRangeIndex = {{ $test->referenceRanges->count() }};
    const container = document.getElementById('referenceRangesContainer');
    const addButton = document.getElementById('addReferenceRange');

    // Add new reference range
    addButton.addEventListener('click', function() {
        const newReferenceRange = createReferenceRangeElement(referenceRangeIndex);
        
        // Remove empty state if it exists
        const emptyState = container.querySelector('.text-center.py-8');
        if (emptyState) {
            emptyState.remove();
        }
        
        container.appendChild(newReferenceRange);
        referenceRangeIndex++;
        
        // Focus on the first input of the new range
        newReferenceRange.querySelector('input[type="text"]').focus();
    });

    // Handle remove buttons for existing ranges
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-reference-range')) {
            const rangeItem = e.target.closest('.reference-range-item');
            rangeItem.remove();
            
            // Update numbering
            updateReferenceRangeNumbers();
            
            // Show empty state if no ranges left
            if (container.children.length === 0) {
                showEmptyState();
            }
        }
    });

    function createReferenceRangeElement(index) {
        const div = document.createElement('div');
        div.className = 'reference-range-item bg-gray-50 p-4 rounded-lg border border-gray-200';
        div.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-medium text-gray-700">Reference Range #${index + 1}</h4>
                <button type="button" class="remove-reference-range text-red-600 hover:text-red-800 focus:outline-none">
                    <i class="fas fa-trash text-sm"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Reference Name</label>
                    <input type="text" name="reference_ranges[${index}][reference_name]" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm"
                           placeholder="e.g., Color, Protein, Albumin">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Reference Range</label>
                    <input type="text" name="reference_ranges[${index}][reference_range]" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm"
                           placeholder="e.g., Yellowish = Normal, 66-83, 35-52">
                </div>
            </div>
        `;
        return div;
    }

    function updateReferenceRangeNumbers() {
        const ranges = container.querySelectorAll('.reference-range-item');
        ranges.forEach((range, index) => {
            const header = range.querySelector('h4');
            header.textContent = `Reference Range #${index + 1}`;
            
            // Update input names to maintain proper indexing
            const inputs = range.querySelectorAll('input');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(/\[\d+\]/, `[${index}]`);
                    input.setAttribute('name', newName);
                }
            });
        });
    }

    function showEmptyState() {
        const emptyState = document.createElement('div');
        emptyState.className = 'text-center py-8 text-gray-500';
        emptyState.innerHTML = `
            <i class="fas fa-chart-line text-3xl mb-3"></i>
            <p>No reference ranges defined yet.</p>
            <p class="text-sm">Click "Add Reference Range" to add reference values for this test.</p>
        `;
        container.appendChild(emptyState);
    }
});
</script>
@endsection
