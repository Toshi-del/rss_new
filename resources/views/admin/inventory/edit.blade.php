@extends('layouts.admin')

@section('title', 'Edit Inventory Item')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Edit Inventory Item</h1>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('inventory.update', $inventory) }}" method="POST" class="space-y-6 p-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name <span class="text-red-500">*</span></label>
                    <input type="text" name="item_name" id="item_name" value="{{ old('item_name', $inventory->item_name) }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('item_name') border-red-500 @enderror" required>
                    @error('item_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="item_quantity" class="block text-sm font-medium text-gray-700">Quantity <span class="text-red-500">*</span></label>
                    <input type="number" name="item_quantity" id="item_quantity" value="{{ old('item_quantity', $inventory->item_quantity) }}" min="0"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('item_quantity') border-red-500 @enderror" required>
                    @error('item_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $inventory->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-50 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Current Status:</strong> {{ $inventory->status === 'in-stock' ? 'In Stock' : 'Out of Stock' }}
                            </p>
                            <p class="text-sm text-blue-700 mt-1">
                                <strong>Note:</strong> The status will be automatically updated based on the quantity. Items with quantity greater than 0 will be marked as "In Stock", while items with 0 quantity will be marked as "Out of Stock".
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('inventory.index') }}" 
                       class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
