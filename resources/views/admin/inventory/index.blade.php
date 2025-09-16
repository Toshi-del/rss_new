@extends('layouts.admin')

@section('title', 'Inventory Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50" style="font-family: 'Inter', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Modern Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif;">Inventory Management</h1>
                    <p class="text-sm text-gray-600">Manage and track your medical supplies and equipment inventory</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('inventory.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl text-sm font-semibold text-white shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Add New Item
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-xl mr-4">
                        <i class="fas fa-boxes text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Items</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $inventories->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl mr-4">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">In Stock</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $inventories->where('status', 'in-stock')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-xl mr-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Out of Stock</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $inventories->where('status', 'out-of-stock')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-xl mr-4">
                        <i class="fas fa-chart-bar text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Quantity</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $inventories->sum('item_quantity') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Grid -->
        @if($inventories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($inventories as $inventory)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Card Header -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center">
                                    <div class="min-w-0 flex-1">
                                        <div class="item-name text-gray-900 truncate" style="font-family: 'Poppins', sans-serif;">{{ $inventory->item_name }}</div>
                                        @if($inventory->description)
                                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $inventory->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $inventory->status === 'in-stock' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ $inventory->status === 'in-stock' ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <!-- Quantity Display -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div>
                                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $inventory->item_quantity }}</p>
                                        <p class="text-xs text-gray-500">{{ Str::plural('unit', $inventory->item_quantity) }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 mb-1">Status</p>
                                    <p class="text-sm font-semibold {{ $inventory->status === 'in-stock' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $inventory->status === 'in-stock' ? 'Available' : 'Unavailable' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-6">
                                <div class="flex justify-between text-xs text-gray-500 mb-2">
                                    <span>Stock Level</span>
                                    <span>{{ $inventory->item_quantity }} units</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="{{ $inventory->status === 'in-stock' ? 'bg-green-600' : 'bg-red-600' }} h-2 rounded-full transition-all duration-1000" 
                                         style="width: {{ $inventory->item_quantity > 0 ? min(($inventory->item_quantity / 100) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('inventory.show', $inventory) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>
                                    View
                                </a>
                                <a href="{{ route('inventory.edit', $inventory) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit
                                </a>
                                <form action="{{ route('inventory.destroy', $inventory) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this inventory item?')" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full inline-flex justify-center items-center px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                        <i class="fas fa-trash mr-2"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    <span>Added {{ $inventory->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-sync-alt mr-1"></i>
                                    <span>Updated {{ $inventory->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-boxes text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3" style="font-family: 'Poppins', sans-serif;">No Inventory Items Found</h3>
                    <p class="text-gray-500 mb-8">Get started by adding your first inventory item to track your medical supplies.</p>
                    <a href="{{ route('inventory.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl text-sm font-semibold text-white shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Add Your First Item
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
/* Override browser defaults for consistent text sizing */
.item-name {
    font-size: 14px !important;
    line-height: 1.4 !important;
    font-weight: 800 !important;
    color: maroon !important;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Custom animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.inventory-card {
    animation: fadeInUp 0.6s ease-out;
}

/* Hover effects */
.hover-lift:hover {
    transform: translateY(-4px);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endsection
