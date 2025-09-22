@extends('layouts.admin')

@section('title', 'View Inventory Item')
@section('page-title', 'View Inventory Item')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-6">
    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.inventory.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-lg border border-gray-200 transition-all duration-150 shadow-sm">
                    <i class="fas fa-arrow-left mr-2 text-sm"></i>
                    Back to Inventory
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $inventory->item_name }}</h1>
                    <p class="text-sm text-gray-600 mt-1">Detailed view of inventory item</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.inventory.edit', $inventory) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg border border-transparent transition-all duration-150 shadow-sm">
                    <i class="fas fa-edit mr-2 text-sm"></i>
                    Edit Item
                </a>
                <button onclick="openDeleteModal({{ $inventory->id }}, '{{ $inventory->item_name }}')" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg border border-transparent transition-all duration-150 shadow-sm">
                    <i class="fas fa-trash mr-2 text-sm"></i>
                    Delete
                </button>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column - Main Details -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Basic Information Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                    <div class="bg-blue-600 px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-info-circle text-white text-lg"></i>
                            </div>
                            <h2 class="text-lg font-bold text-white">Basic Information</h2>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Item Name</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $inventory->item_name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Category</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $inventory->category ?: 'Not specified' }}</p>
                            </div>
                        </div>
                        
                        @if($inventory->description)
                            <div>
                                <label class="text-sm font-medium text-gray-500">Description</label>
                                <p class="text-gray-900 mt-1 leading-relaxed">{{ $inventory->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Stock Information Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                    <div class="bg-green-600 px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-cubes text-white text-lg"></i>
                            </div>
                            <h2 class="text-lg font-bold text-white">Stock Information</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $inventory->item_quantity }}</div>
                                <div class="text-sm text-gray-500">Current Stock</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $inventory->minimum_stock }}</div>
                                <div class="text-sm text-gray-500">Minimum Stock</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold {{ $inventory->is_low_stock ? 'text-red-600' : 'text-green-600' }} mb-2">
                                    {{ $inventory->item_quantity - $inventory->minimum_stock }}
                                </div>
                                <div class="text-sm text-gray-500">Above/Below Min</div>
                            </div>
                        </div>
                        
                        <!-- Stock Level Progress -->
                        <div class="mt-6">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Stock Level</span>
                                <span>{{ $inventory->item_quantity }} / {{ $inventory->minimum_stock * 2 }} (Target)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                @php
                                    $percentage = $inventory->minimum_stock > 0 ? min(($inventory->item_quantity / ($inventory->minimum_stock * 2)) * 100, 100) : 50;
                                    $color = $inventory->item_quantity <= $inventory->minimum_stock ? 'bg-red-500' : ($inventory->item_quantity <= $inventory->minimum_stock * 1.5 ? 'bg-yellow-500' : 'bg-green-500');
                                @endphp
                                <div class="{{ $color }} h-3 rounded-full transition-all duration-1000" 
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                            @if($inventory->is_low_stock)
                                <div class="flex items-center space-x-2 mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                                    <span class="text-red-800 font-medium">Low Stock Alert - Reorder Soon!</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Financial Information Card -->
                @if($inventory->unit_price)
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                        <div class="bg-purple-600 px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-peso-sign text-white text-lg"></i>
                                </div>
                                <h2 class="text-lg font-bold text-white">Financial Information</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900 mb-2">₱{{ number_format($inventory->unit_price, 2) }}</div>
                                    <div class="text-sm text-gray-500">Unit Price</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900 mb-2">₱{{ number_format($inventory->unit_price * $inventory->item_quantity, 2) }}</div>
                                    <div class="text-sm text-gray-500">Total Value</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900 mb-2">₱{{ number_format($inventory->unit_price * $inventory->minimum_stock, 2) }}</div>
                                    <div class="text-sm text-gray-500">Min Stock Value</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Status & Additional Info -->
            <div class="space-y-6">
                
                <!-- Status Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Status</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-center">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $inventory->status_badge }}">
                                <i class="fas fa-circle mr-2 text-xs"></i>
                                {{ ucfirst(str_replace('_', ' ', $inventory->item_status)) }}
                            </span>
                        </div>
                        
                        @if($inventory->expiry_date)
                            <div class="text-center pt-4 border-t border-gray-100">
                                <div class="text-sm text-gray-500 mb-1">Expiry Date</div>
                                <div class="text-lg font-semibold text-gray-900">{{ $inventory->expiry_date->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $inventory->expiry_date->diffForHumans() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Supplier Information -->
                @if($inventory->supplier)
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">Supplier</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-truck text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $inventory->supplier }}</div>
                                    <div class="text-sm text-gray-500">Primary Supplier</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Timestamps -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Timeline</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-plus text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Added</div>
                                <div class="text-xs text-gray-500">{{ $inventory->created_at->format('M d, Y \a\t g:i A') }}</div>
                                <div class="text-xs text-gray-400">{{ $inventory->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        
                        @if($inventory->updated_at != $inventory->created_at)
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-edit text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Last Updated</div>
                                    <div class="text-xs text-gray-500">{{ $inventory->updated_at->format('M d, Y \a\t g:i A') }}</div>
                                    <div class="text-xs text-gray-400">{{ $inventory->updated_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.inventory.edit', $inventory) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-150">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Item
                        </a>
                        
                        @if($inventory->item_status == 'active')
                            <button class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-all duration-150">
                                <i class="fas fa-pause mr-2"></i>
                                Mark Inactive
                            </button>
                        @else
                            <button class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-150">
                                <i class="fas fa-play mr-2"></i>
                                Mark Active
                            </button>
                        @endif
                        
                        <button onclick="openDeleteModal({{ $inventory->id }}, '{{ $inventory->item_name }}')" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-150">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Item
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
@endsection
