@extends('layouts.admin')

@section('title', 'Edit Inventory Item - RSS Citi Health Services')
@section('page-title', 'Edit Inventory Item')

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center space-x-3 mb-6">
        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
            <i class="fas fa-check text-green-600"></i>
        </div>
        <div>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center space-x-3 mb-6">
        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
            <i class="fas fa-exclamation-triangle text-red-600"></i>
        </div>
        <div class="flex-1">
            <p class="text-red-800 font-medium mb-2">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

<!-- Header Section -->
<div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200 mb-8">
    <div class="bg-emerald-600 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                    <i class="fas fa-edit text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Edit Inventory Item</h3>
                    <p class="text-emerald-100 text-sm">Update medical supply or equipment details</p>
                </div>
            </div>
            <a href="{{ route('admin.inventory.index') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 border border-white/20">
                <i class="fas fa-arrow-left text-sm"></i>
                <span>Back to Inventory</span>
            </a>
        </div>
    </div>
</div>

<!-- Edit Form -->
<div class="content-card rounded-xl shadow-lg border border-gray-200">
    <form action="{{ route('admin.inventory.update', $inventory) }}" method="POST" class="p-8">
        @csrf
        @method('PUT')
        
        <!-- Basic Information Section -->
        <div class="mb-8">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                Basic Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Item Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $inventory->name) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('name') border-red-300 @enderror"
                           placeholder="Enter item name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                        SKU (Stock Keeping Unit)
                    </label>
                    <input type="text" 
                           id="sku" 
                           name="sku" 
                           value="{{ old('sku', $inventory->sku) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('sku') border-red-300 @enderror"
                           placeholder="Unique SKU">
                    @error('sku')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('description') border-red-300 @enderror"
                          placeholder="Enter item description">{{ old('description', $inventory->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Category and Unit Section -->
        <div class="mb-8">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-tags text-emerald-600 mr-2"></i>
                Category & Unit
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select id="category" 
                            name="category" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('category') border-red-300 @enderror">
                        <option value="">Select Category</option>
                        @foreach(\App\Models\Inventory::CATEGORIES as $key => $label)
                            <option value="{{ $key }}" {{ old('category', $inventory->category) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                        Unit of Measurement <span class="text-red-500">*</span>
                    </label>
                    <select id="unit" 
                            name="unit" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('unit') border-red-300 @enderror">
                        <option value="">Select Unit</option>
                        @foreach(\App\Models\Inventory::UNITS as $key => $label)
                            <option value="{{ $key }}" {{ old('unit', $inventory->unit) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('unit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Quantity Management Section -->
        <div class="mb-8">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-cubes text-purple-600 mr-2"></i>
                Quantity Management
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="current_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        Current Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="current_quantity" 
                           name="current_quantity" 
                           value="{{ old('current_quantity', $inventory->current_quantity) }}"
                           min="0"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('current_quantity') border-red-300 @enderror"
                           placeholder="0">
                    @error('current_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="minimum_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        Minimum Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="minimum_quantity" 
                           name="minimum_quantity" 
                           value="{{ old('minimum_quantity', $inventory->minimum_quantity) }}"
                           min="0"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('minimum_quantity') border-red-300 @enderror"
                           placeholder="0">
                    @error('minimum_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Reorder threshold</p>
                </div>

                <div>
                    <label for="maximum_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        Maximum Quantity
                    </label>
                    <input type="number" 
                           id="maximum_quantity" 
                           name="maximum_quantity" 
                           value="{{ old('maximum_quantity', $inventory->maximum_quantity) }}"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('maximum_quantity') border-red-300 @enderror"
                           placeholder="Optional">
                    @error('maximum_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Storage capacity limit</p>
                </div>
            </div>
        </div>

        <!-- Cost Information Section -->
        <div class="mb-8">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-peso-sign text-emerald-600 mr-2"></i>
                Cost Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="unit_cost" class="block text-sm font-medium text-gray-700 mb-2">
                        Unit Cost (₱) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="unit_cost" 
                           name="unit_cost" 
                           value="{{ old('unit_cost', $inventory->unit_cost) }}"
                           min="0"
                           step="0.01"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('unit_cost') border-red-300 @enderror"
                           placeholder="0.00">
                    @error('unit_cost')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" 
                            name="status" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('status') border-red-300 @enderror">
                        @foreach(\App\Models\Inventory::STATUS as $key => $label)
                            <option value="{{ $key }}" {{ old('status', $inventory->status) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Supplier and Location Section -->
        <div class="mb-8">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-map-marker-alt text-amber-600 mr-2"></i>
                Supplier & Location
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="supplier" class="block text-sm font-medium text-gray-700 mb-2">
                        Supplier
                    </label>
                    <input type="text" 
                           id="supplier" 
                           name="supplier" 
                           value="{{ old('supplier', $inventory->supplier) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('supplier') border-red-300 @enderror"
                           placeholder="Enter supplier name">
                    @error('supplier')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Storage Location
                    </label>
                    <input type="text" 
                           id="location" 
                           name="location" 
                           value="{{ old('location', $inventory->location) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('location') border-red-300 @enderror"
                           placeholder="Enter storage location">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="mb-8">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-calendar-alt text-red-600 mr-2"></i>
                Additional Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Expiry Date
                    </label>
                    <input type="date" 
                           id="expiry_date" 
                           name="expiry_date" 
                           value="{{ old('expiry_date', $inventory->expiry_date ? $inventory->expiry_date->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('expiry_date') border-red-300 @enderror">
                    @error('expiry_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Leave empty if item doesn't expire</p>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Notes
                    </label>
                    <textarea id="notes" 
                              name="notes" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm @error('notes') border-red-300 @enderror"
                              placeholder="Additional notes or comments">{{ old('notes', $inventory->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.inventory.index') }}" 
               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                Cancel
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md flex items-center space-x-2">
                <i class="fas fa-save text-sm"></i>
                <span>Update Inventory Item</span>
            </button>
        </div>
    </form>
</div>

<script>
// Auto-calculate total cost when quantity or unit cost changes
document.addEventListener('DOMContentLoaded', function() {
    const currentQuantity = document.getElementById('current_quantity');
    const unitCost = document.getElementById('unit_cost');
    const minimumQuantity = document.getElementById('minimum_quantity');
    const maximumQuantity = document.getElementById('maximum_quantity');

    // Validate maximum quantity is greater than minimum
    function validateQuantities() {
        const minVal = parseInt(minimumQuantity.value) || 0;
        const maxVal = parseInt(maximumQuantity.value) || 0;
        
        if (maxVal > 0 && maxVal < minVal) {
            maximumQuantity.setCustomValidity('Maximum quantity must be greater than minimum quantity');
        } else {
            maximumQuantity.setCustomValidity('');
        }
    }

    minimumQuantity.addEventListener('input', validateQuantities);
    maximumQuantity.addEventListener('input', validateQuantities);

    // Form validation before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        validateQuantities();
        
        // Check if form is valid
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
    });
});
</script>
@endsection
