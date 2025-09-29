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
                    <p class="text-sm text-gray-600">Manage your medical supplies and equipment inventory efficiently</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('admin.inventory.create') }}" 
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
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $totalItems }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl mr-4">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Active Items</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $activeItems }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-xl mr-4">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Low Stock</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $lowStockItems }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-xl mr-4">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Out of Stock</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $outOfStockItems }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Critical Stock Alert Section -->
        @php
            $criticalItems = $inventories->filter(function($item) {
                return $item->item_quantity <= $item->minimum_stock && $item->item_status === 'active';
            });
        @endphp
        
        @if($criticalItems->count() > 0)
            <div class="mb-8">
                <div class="bg-red-50 border border-red-200 rounded-2xl overflow-hidden">
                    <div class="bg-red-600 px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-white text-lg animate-pulse"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white">Critical Stock Alert</h3>
                                <p class="text-red-100 text-sm">{{ $criticalItems->count() }} {{ Str::plural('item', $criticalItems->count()) }} need immediate restocking</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($criticalItems->take(6) as $item)
                                <div class="bg-white border-2 border-red-300 rounded-xl p-4 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-bold text-gray-900 text-sm truncate">{{ $item->item_name }}</h4>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 animate-pulse">
                                            <i class="fas fa-circle mr-1 text-xs"></i>
                                            CRITICAL
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 mb-3">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Current Stock:</span>
                                            <span class="font-bold text-red-600">{{ $item->item_quantity }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Minimum Required:</span>
                                            <span class="font-bold text-gray-900">{{ $item->minimum_stock }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Units Needed:</span>
                                            <span class="font-bold text-red-600">{{ max(0, $item->minimum_stock - $item->item_quantity) }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                                            <span>Stock Level</span>
                                            <span>{{ $item->minimum_stock > 0 ? round(($item->item_quantity / $item->minimum_stock) * 100) : 0 }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            @php
                                                $percentage = $item->minimum_stock > 0 ? min(($item->item_quantity / $item->minimum_stock) * 100, 100) : 0;
                                            @endphp
                                            <div class="bg-red-500 h-3 rounded-full transition-all duration-1000 animate-pulse" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.inventory.edit', $item) }}" 
                                           class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                            <i class="fas fa-edit mr-2"></i>
                                            Restock
                                        </a>
                                        <a href="{{ route('admin.inventory.show', $item) }}" 
                                           class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                            <i class="fas fa-eye mr-2"></i>
                                            View
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($criticalItems->count() > 6)
                            <div class="mt-4 text-center">
                                <p class="text-red-600 font-medium text-sm">
                                    Showing 6 of {{ $criticalItems->count() }} critical items. Scroll down to see all inventory items.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Inventory Grid -->
        @if($inventories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($inventories as $index => $item)
                    <div class="bg-white rounded-2xl shadow-lg border {{ $item->is_low_stock && $item->item_status === 'active' ? 'border-red-300 ring-2 ring-red-100' : 'border-gray-100' }} overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Card Header -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center">
                                    <div class="min-w-0 flex-1">
                                        <div class="item-name text-gray-900 truncate" style="font-family: 'Poppins', sans-serif;">{{ $item->item_name }}</div>
                                        @if($item->category)
                                            <p class="text-xs text-gray-500 mt-1">{{ $item->category }}</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $item->status_badge }}">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ ucfirst(str_replace('_', ' ', $item->item_status)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <!-- Quantity and Price -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div>
                                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $item->item_quantity }}</p>
                                        <p class="text-xs text-gray-500">{{ Str::plural('unit', $item->item_quantity) }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($item->unit_price)
                                        <p class="text-xs text-gray-500 mb-1">Unit Price</p>
                                        <p class="text-sm font-semibold text-gray-900">₱{{ number_format($item->unit_price, 2) }}</p>
                                    @else
                                        <p class="text-xs text-gray-500">No price set</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Stock Level Progress Bar -->
                            <div class="mb-6">
                                <div class="flex justify-between text-xs text-gray-500 mb-2">
                                    <span>Stock Level</span>
                                    <span>Min: {{ $item->minimum_stock }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    @php
                                        $percentage = $item->minimum_stock > 0 ? min(($item->item_quantity / ($item->minimum_stock * 2)) * 100, 100) : 50;
                                        $color = $item->item_quantity <= $item->minimum_stock ? 'bg-red-500' : ($item->item_quantity <= $item->minimum_stock * 1.5 ? 'bg-yellow-500' : 'bg-green-500');
                                    @endphp
                                    <div class="{{ $color }} h-2 rounded-full transition-all duration-1000" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                                @if($item->is_low_stock)
                                    <p class="text-xs text-red-600 mt-1 font-bold animate-pulse">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        {{ $item->item_quantity <= $item->minimum_stock ? 'CRITICAL STOCK ALERT' : 'Low Stock Alert' }}
                                    </p>
                                @endif
                            </div>

                            <!-- Additional Info -->
                            @if($item->supplier || $item->expiry_date)
                                <div class="mb-4 space-y-1">
                                    @if($item->supplier)
                                        <div class="flex items-center text-xs text-gray-600">
                                            <i class="fas fa-truck mr-2"></i>
                                            <span>{{ $item->supplier }}</span>
                                        </div>
                                    @endif
                                    @if($item->expiry_date)
                                        <div class="flex items-center text-xs text-gray-600">
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            <span>Expires: {{ $item->expiry_date->format('M d, Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.inventory.show', $item) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>
                                    View
                                </a>
                                <a href="{{ route('admin.inventory.edit', $item) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit
                                </a>
                                <button onclick="openDeleteModal({{ $item->id }}, '{{ $item->item_name }}')" 
                                        class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                    <i class="fas fa-trash mr-2"></i>
                                    Delete
                                </button>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    <span>Added {{ $item->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-sync-alt mr-1"></i>
                                    <span>Updated {{ $item->updated_at->diffForHumans() }}</span>
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
                    <p class="text-gray-500 mb-8">Get started by adding your first inventory item to track your medical supplies and equipment.</p>
                    <a href="{{ route('admin.inventory.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl text-sm font-semibold text-white shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Add Your First Item
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-red-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-trash text-white text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Delete Inventory Item</h3>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-start space-x-4 mb-6">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Are you sure?</h4>
                    <p class="text-gray-600 text-sm mb-3">
                        You are about to delete the item "<span id="itemName" class="font-semibold text-gray-900"></span>".
                    </p>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-sm mt-0.5"></i>
                            <div class="text-sm text-yellow-800">
                                <p class="font-medium">Warning:</p>
                                <p>This action will permanently delete the inventory item and all its data. This cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end space-x-3">
                <button type="button" 
                        onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Cancel
                </button>
                <button type="button" 
                        onclick="confirmDelete()" 
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                    <i class="fas fa-trash mr-2"></i>
                    Delete Item
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for deletion -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
let currentItemId = null;

function openDeleteModal(itemId, itemName) {
    currentItemId = itemId;
    document.getElementById('itemName').textContent = itemName;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentItemId = null;
}

function confirmDelete() {
    if (currentItemId) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/inventory/${currentItemId}`;
        form.submit();
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('deleteModal');
        if (!modal.classList.contains('hidden')) {
            closeDeleteModal();
        }
    }
});
</script>

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
