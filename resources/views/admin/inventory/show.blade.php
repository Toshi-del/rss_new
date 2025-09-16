@extends('layouts.admin')

@section('title', 'Inventory Item Details')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Inventory Item Details</h1>
            <div class="flex space-x-3">
                <a href="{{ route('inventory.edit', $inventory) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-edit mr-2"></i>Edit Item
                </a>
                <a href="{{ route('inventory.index') }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Inventory
                </a>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $inventory->item_name }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Complete details about this inventory item</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Item Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $inventory->item_name }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Quantity</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="text-2xl font-bold">{{ $inventory->item_quantity }}</span>
                            <span class="text-gray-500 ml-2">{{ Str::plural('unit', $inventory->item_quantity) }}</span>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $inventory->status === 'in-stock' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas fa-circle mr-2 text-xs"></i>
                                {{ $inventory->status === 'in-stock' ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if($inventory->description)
                                {{ $inventory->description }}
                            @else
                                <span class="text-gray-400 italic">No description provided</span>
                            @endif
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $inventory->created_at->format('F j, Y \a\t g:i A') }}
                            <span class="text-gray-500">({{ $inventory->created_at->diffForHumans() }})</span>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $inventory->updated_at->format('F j, Y \a\t g:i A') }}
                            <span class="text-gray-500">({{ $inventory->updated_at->diffForHumans() }})</span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Stock Level Visualization -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Stock Level</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Visual representation of current stock level</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <div class="flex justify-between text-sm text-gray-500 mb-2">
                    <span>Current Stock</span>
                    <span>{{ $inventory->item_quantity }} units</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="{{ $inventory->status === 'in-stock' ? 'bg-green-600' : 'bg-red-600' }} h-4 rounded-full transition-all duration-1000 flex items-center justify-end pr-2" 
                         style="width: {{ $inventory->item_quantity > 0 ? min(($inventory->item_quantity / 100) * 100, 100) : 5 }}%">
                        @if($inventory->item_quantity > 10)
                            <span class="text-white text-xs font-medium">{{ $inventory->item_quantity }}</span>
                        @endif
                    </div>
                </div>
                <div class="mt-2 text-center">
                    @if($inventory->status === 'in-stock')
                        <p class="text-green-600 font-medium">✓ Item is currently available</p>
                    @else
                        <p class="text-red-600 font-medium">⚠ Item is out of stock</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Actions</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Manage this inventory item</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <div class="flex space-x-3">
                    <a href="{{ route('inventory.edit', $inventory) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Item
                    </a>
                    <form action="{{ route('inventory.destroy', $inventory) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this inventory item? This action cannot be undone.')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Item
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
