@extends('layouts.admin')

@section('title', 'Inventory Management - RSS Citi Health Services')
@section('page-title', 'Inventory Management')

@push('styles')
<style>
    .modal-active #sidebar {
        display: none !important;
    }
    
    .modal-active .flex.h-full > div:first-child {
        display: none !important;
    }
    
    .modal-active main {
        margin-left: 0 !important;
    }
</style>
@endpush

@section('content')
<div class="w-full max-w-none">
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

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center space-x-3 mb-6">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Stats Overview Cards -->
    <div class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="content-card rounded-xl p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Items</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_items'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-boxes text-blue-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="content-card rounded-xl p-6 border-l-4 border-amber-500 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Low Stock</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['low_stock_items'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-amber-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="content-card rounded-xl p-6 border-l-4 border-red-500 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Out of Stock</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['out_of_stock_items'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="content-card rounded-xl p-6 border-l-4 border-emerald-500 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Value</p>
                        <p class="text-2xl font-bold text-gray-900">₱{{ number_format($stats['total_value'] ?? 0, 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-peso-sign text-emerald-600 text-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200 mb-8">
        <div class="bg-blue-600 px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-boxes text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Medical Inventory Management</h3>
                        <p class="text-blue-100 text-sm">Manage medical supplies, equipment, and consumables</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <!-- Filters -->
                    <form method="GET" action="{{ route('admin.inventory.index') }}" class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-3">
                        <!-- Category Filter -->
                        <div class="relative">
                            <select name="category" class="bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200" onchange="this.form.submit()">
                                <option value="" class="text-gray-900">All Categories</option>
                                @foreach(\App\Models\Inventory::CATEGORIES as $key => $label)
                                    <option value="{{ $key }}" {{ ($category ?? '') === $key ? 'selected' : '' }} class="text-gray-900">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Stock Filter -->
                        <div class="relative">
                            <select name="stock_filter" class="bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200" onchange="this.form.submit()">
                                <option value="" class="text-gray-900">All Stock</option>
                                <option value="low_stock" {{ ($stockFilter ?? '') === 'low_stock' ? 'selected' : '' }} class="text-gray-900">Low Stock</option>
                                <option value="out_of_stock" {{ ($stockFilter ?? '') === 'out_of_stock' ? 'selected' : '' }} class="text-gray-900">Out of Stock</option>
                                <option value="expired" {{ ($stockFilter ?? '') === 'expired' ? 'selected' : '' }} class="text-gray-900">Expired</option>
                                <option value="expiring_soon" {{ ($stockFilter ?? '') === 'expiring_soon' ? 'selected' : '' }} class="text-gray-900">Expiring Soon</option>
                            </select>
                        </div>
                        
                        <!-- Search Bar -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-white/60 text-sm"></i>
                            </div>
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                   class="bg-white/10 backdrop-blur-sm border border-white/20 pl-12 pr-4 py-2 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 w-64 text-sm" 
                                   placeholder="Search inventory...">
                        </div>
                        
                        <button type="submit" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 border border-white/20 backdrop-blur-sm">
                            <i class="fas fa-filter text-sm"></i>
                        </button>
                        
                        @if(request()->hasAny(['category', 'stock_filter', 'search']))
                            <a href="{{ route('admin.inventory.index') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 border border-white/20 backdrop-blur-sm">
                                <i class="fas fa-times text-sm"></i>
                            </a>
                        @endif
                    </form>
                    
                    <!-- Add Item Button -->
                    <a href="{{ route('admin.inventory.create') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 border border-white/20 whitespace-nowrap">
                        <i class="fas fa-plus text-sm"></i>
                        <span>Add Item</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200 mb-8">
        <div class="overflow-x-auto">
            <table class="w-full" id="inventoryTable">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">SKU</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Item Name</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Category</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Stock</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Unit Cost</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Status</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($inventory ?? [] as $item)
                        <tr class="hover:bg-blue-50 transition-all duration-200 border-l-4 border-transparent hover:border-blue-400 inventory-card" data-inventory-id="{{ $item->id }}">
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="text-sm font-mono text-gray-700 bg-gray-100 px-2 py-1 rounded">
                                    {{ $item->sku }}
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center shadow-md">
                                        <i class="fas fa-box text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $item->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($item->description ?? '', 40) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border
                                    @if($item->category === 'diagnostic') bg-blue-100 text-blue-800 border-blue-200
                                    @elseif($item->category === 'laboratory') bg-purple-100 text-purple-800 border-purple-200
                                    @elseif($item->category === 'medical') bg-emerald-100 text-emerald-800 border-emerald-200
                                    @elseif($item->category === 'pharmaceuticals') bg-pink-100 text-pink-800 border-pink-200
                                    @else bg-gray-100 text-gray-800 border-gray-200 @endif">
                                    <i class="fas fa-circle text-xs mr-1.5"></i>
                                    {{ $item->category_name }}
                                </span>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="space-y-1">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-lg font-bold text-gray-900">{{ $item->current_quantity }}</span>
                                        <span class="text-sm text-gray-500">{{ $item->unit_name }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                            @if($item->stock_status === 'out_of_stock') bg-red-100 text-red-800
                                            @elseif($item->stock_status === 'low_stock') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800 @endif">
                                            @if($item->stock_status === 'out_of_stock')
                                                <i class="fas fa-times-circle mr-1"></i>Out of Stock
                                            @elseif($item->stock_status === 'low_stock')
                                                <i class="fas fa-exclamation-triangle mr-1"></i>Low Stock
                                            @else
                                                <i class="fas fa-check-circle mr-1"></i>In Stock
                                            @endif
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500">Min: {{ $item->minimum_quantity }}</div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="text-lg font-bold text-gray-900">
                                    ₱{{ number_format($item->unit_cost, 2) }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    Total: ₱{{ number_format($item->total_cost, 2) }}
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border
                                    @if($item->status === 'active') bg-green-100 text-green-800 border-green-200
                                    @elseif($item->status === 'inactive') bg-gray-100 text-gray-800 border-gray-200
                                    @elseif($item->status === 'expired') bg-red-100 text-red-800 border-red-200
                                    @else bg-yellow-100 text-yellow-800 border-yellow-200 @endif">
                                    <i class="fas fa-circle text-xs mr-1.5"></i>
                                    {{ $item->status_name }}
                                </span>
                            </td>
                            <td class="py-5 px-6">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.inventory.show', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-xs font-medium transition-all duration-150 border border-blue-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        View
                                    </a>
                                    <a href="{{ route('admin.inventory.edit', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg text-xs font-medium transition-all duration-150 border border-emerald-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-1.5 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-lg text-xs font-medium transition-all duration-150 border border-purple-200"
                                            onclick="openStockModal({{ $item->id }}, '{{ $item->name }}', {{ $item->current_quantity }}, '{{ $item->unit_name }}')">
                                        <i class="fas fa-plus-minus mr-1"></i>
                                        Stock
                                    </button>
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-xs font-medium transition-all duration-150 border border-red-200"
                                            onclick="openDeleteInventoryModal({{ $item->id }}, '{{ $item->name }}')">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center border-2 border-dashed border-gray-300">
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center border-4 border-blue-300">
                                        <i class="fas fa-boxes text-blue-500 text-3xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 font-semibold text-lg">No inventory items found</p>
                                        <p class="text-gray-500 text-sm mt-1">Get started by adding your first inventory item</p>
                                    </div>
                                    <a href="{{ route('admin.inventory.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 flex items-center space-x-2 shadow-lg">
                                        <i class="fas fa-plus text-sm"></i>
                                        <span>Add First Item</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if(isset($inventory) && method_exists($inventory, 'links'))
    <div class="flex justify-center">
        {{ $inventory->appends(request()->query())->links() }}
    </div>
    @endif
</div>


<!-- Modals -->
<!-- View Inventory Modal -->
<div id="viewInventoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 transform transition-all duration-300">
        <div class="bg-blue-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-eye text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Inventory Details</h3>
                </div>
                <button onclick="closeModal('viewInventoryModal')" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-semibold text-gray-900 mb-2">Item Name</h5>
                        <p id="view-name" class="text-gray-700"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-semibold text-gray-900 mb-2">SKU</h5>
                        <p id="view-sku" class="text-gray-700 font-mono"></p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-semibold text-gray-900 mb-2">Category</h5>
                        <p id="view-category" class="text-gray-700"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-semibold text-gray-900 mb-2">Current Stock</h5>
                        <p id="view-stock" class="text-gray-700 text-lg font-bold"></p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-semibold text-gray-900 mb-2">Unit Cost</h5>
                        <p id="view-cost" class="text-gray-700 text-lg font-bold"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-semibold text-gray-900 mb-2">Status</h5>
                        <p id="view-status" class="text-gray-700"></p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-semibold text-gray-900 mb-2">Supplier</h5>
                        <p id="view-supplier" class="text-gray-700"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-semibold text-gray-900 mb-2">Location</h5>
                        <p id="view-location" class="text-gray-700"></p>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal('viewInventoryModal')" 
                        class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Stock Management Modal -->
<div id="stockModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-purple-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus-minus text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Manage Stock</h3>
                </div>
                <button onclick="closeModal('stockModal')" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <h4 class="font-semibold text-gray-900 mb-2">Item: <span id="stock-item-name"></span></h4>
                <p class="text-sm text-gray-600">Current Stock: <span id="stock-current-quantity" class="font-bold"></span> <span id="stock-unit"></span></p>
            </div>
            
            <div class="space-y-4">
                <!-- Add Stock Form -->
                <div class="border border-green-200 rounded-lg p-4 bg-green-50">
                    <h5 class="font-medium text-green-800 mb-3 flex items-center">
                        <i class="fas fa-plus mr-2"></i>Add Stock
                    </h5>
                    <form id="addStockForm" class="space-y-3">
                        <input type="hidden" id="add-stock-id">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity to Add</label>
                            <input type="number" name="quantity" required min="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <input type="text" name="notes" placeholder="Reason for adding stock"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all duration-150">
                            <i class="fas fa-plus mr-2"></i>Add Stock
                        </button>
                    </form>
                </div>

                <!-- Remove Stock Form -->
                <div class="border border-red-200 rounded-lg p-4 bg-red-50">
                    <h5 class="font-medium text-red-800 mb-3 flex items-center">
                        <i class="fas fa-minus mr-2"></i>Remove Stock
                    </h5>
                    <form id="removeStockForm" class="space-y-3">
                        <input type="hidden" id="remove-stock-id">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity to Remove</label>
                            <input type="number" name="quantity" required min="1" id="remove-quantity-input"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <input type="text" name="notes" placeholder="Reason for removing stock"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all duration-150">
                            <i class="fas fa-minus mr-2"></i>Remove Stock
                        </button>
                    </form>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal('stockModal')" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Inventory Modal -->
<div id="deleteInventoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-red-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-trash text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Delete Inventory Item</h3>
                </div>
                <button onclick="closeModal('deleteInventoryModal')" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <p class="text-gray-700">Are you sure you want to delete the inventory item <span id="delete-item-name"></span>?</p>
                <p class="text-gray-600">This action is irreversible and will permanently delete the item from the inventory.</p>
            </div>
            <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal('deleteInventoryModal')" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Cancel
                </button>
                <button type="button" onclick="confirmDeleteInventory()" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all duration-150">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Global variables
let currentInventoryId = null;

// Modal functions
function openViewInventoryModal(id, name, sku, category, quantity, unit, cost, status, supplier, location) {
    document.getElementById('view-name').textContent = name;
    document.getElementById('view-sku').textContent = sku;
    document.getElementById('view-category').textContent = category;
    document.getElementById('view-stock').textContent = quantity + ' ' + unit;
    document.getElementById('view-cost').textContent = '₱' + parseFloat(cost).toFixed(2);
    document.getElementById('view-status').textContent = status;
    document.getElementById('view-supplier').textContent = supplier || 'Not specified';
    document.getElementById('view-location').textContent = location || 'Not specified';
    
    document.getElementById('viewInventoryModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function openStockModal(id, name, currentQuantity, unit) {
    currentInventoryId = id;
    document.getElementById('stock-item-name').textContent = name;
    document.getElementById('stock-current-quantity').textContent = currentQuantity;
    document.getElementById('stock-unit').textContent = unit;
    document.getElementById('add-stock-id').value = id;
    document.getElementById('remove-stock-id').value = id;
    document.getElementById('remove-quantity-input').max = currentQuantity;
    
    document.getElementById('stockModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function openDeleteInventoryModal(id, name) {
    currentInventoryId = id;
    document.getElementById('delete-item-name').textContent = name;
    document.getElementById('deleteInventoryModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentInventoryId = null;
}

function confirmDeleteInventory() {
    if (currentInventoryId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/inventory/${currentInventoryId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Stock management forms
    document.getElementById('addStockForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const id = document.getElementById('add-stock-id').value;
        
        fetch(`/admin/inventory/${id}/add-stock`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding stock.');
        });
    });

    document.getElementById('removeStockForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const id = document.getElementById('remove-stock-id').value;
        
        fetch(`/admin/inventory/${id}/remove-stock`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while removing stock.');
        });
    });

    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        const modals = ['viewInventoryModal', 'stockModal', 'deleteInventoryModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (event.target === modal) {
                closeModal(modalId);
            }
        });
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = ['viewInventoryModal', 'stockModal', 'deleteInventoryModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (!modal.classList.contains('hidden')) {
                    closeModal(modalId);
                }
            });
        }
    });

    // Make functions globally available
    window.openViewInventoryModal = openViewInventoryModal;
    window.openStockModal = openStockModal;
    window.openDeleteInventoryModal = openDeleteInventoryModal;
});
</script>
@endsection