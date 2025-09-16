@extends('layouts.admin')

@section('title', 'Inventory Details - RSS Citi Health Services')
@section('page-title', 'Inventory Details')

@section('content')
<!-- Header Section -->
<div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200 mb-6">
    <div class="bg-blue-600 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">{{ $inventory->name }}</h3>
                    <p class="text-blue-100 text-sm">SKU: {{ $inventory->sku }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.inventory.edit', $inventory) }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 border border-white/20">
                    <i class="fas fa-edit text-sm"></i>
                    <span>Edit</span>
                </a>
                <a href="{{ route('admin.inventory.index') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 border border-white/20">
                    <i class="fas fa-arrow-left text-sm"></i>
                    <span>Back to Inventory</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Information Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Basic Info -->
    <div class="lg:col-span-2">
        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                Item Details
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h5 class="font-medium text-gray-700 text-sm">Item Name</h5>
                    <p class="text-gray-900 font-semibold">{{ $inventory->name }}</p>
                </div>
                <div>
                    <h5 class="font-medium text-gray-700 text-sm">SKU</h5>
                    <p class="text-gray-900 font-mono">{{ $inventory->sku }}</p>
                </div>
                <div>
                    <h5 class="font-medium text-gray-700 text-sm">Category</h5>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold border
                        @if($inventory->category === 'diagnostic') bg-blue-100 text-blue-800 border-blue-200
                        @elseif($inventory->category === 'laboratory') bg-purple-100 text-purple-800 border-purple-200
                        @elseif($inventory->category === 'medical') bg-emerald-100 text-emerald-800 border-emerald-200
                        @elseif($inventory->category === 'pharmaceuticals') bg-pink-100 text-pink-800 border-pink-200
                        @else bg-gray-100 text-gray-800 border-gray-200 @endif">
                        {{ $inventory->category_name }}
                    </span>
                </div>
                <div>
                    <h5 class="font-medium text-gray-700 text-sm">Unit</h5>
                    <p class="text-gray-900">{{ $inventory->unit_name }}</p>
                </div>
                <div>
                    <h5 class="font-medium text-gray-700 text-sm">Status</h5>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold border
                        @if($inventory->status === 'active') bg-green-100 text-green-800 border-green-200
                        @elseif($inventory->status === 'inactive') bg-gray-100 text-gray-800 border-gray-200
                        @elseif($inventory->status === 'expired') bg-red-100 text-red-800 border-red-200
                        @else bg-yellow-100 text-yellow-800 border-yellow-200 @endif">
                        {{ $inventory->status_name }}
                    </span>
                </div>
                <div>
                    <h5 class="font-medium text-gray-700 text-sm">Unit Cost</h5>
                    <p class="text-gray-900 font-bold text-lg">₱{{ number_format($inventory->unit_cost, 2) }}</p>
                </div>
            </div>
            @if($inventory->description)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <h5 class="font-medium text-gray-700 text-sm mb-2">Description</h5>
                <p class="text-gray-900">{{ $inventory->description }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Stock Info -->
    <div>
        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-cubes text-purple-600 mr-2"></i>
                Stock
            </h4>
            <div class="text-center mb-4">
                <p class="text-4xl font-bold text-gray-900">{{ $inventory->current_quantity }}</p>
                <p class="text-sm text-gray-500">{{ $inventory->unit_name }}</p>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold mt-2
                    @if($inventory->stock_status === 'out_of_stock') bg-red-100 text-red-800
                    @elseif($inventory->stock_status === 'low_stock') bg-yellow-100 text-yellow-800
                    @else bg-green-100 text-green-800 @endif">
                    @if($inventory->stock_status === 'out_of_stock')
                        <i class="fas fa-times-circle mr-1"></i>Out of Stock
                    @elseif($inventory->stock_status === 'low_stock')
                        <i class="fas fa-exclamation-triangle mr-1"></i>Low Stock
                    @else
                        <i class="fas fa-check-circle mr-1"></i>In Stock
                    @endif
                </span>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Minimum:</span>
                    <span class="font-medium">{{ $inventory->minimum_quantity }}</span>
                </div>
                @if($inventory->maximum_quantity)
                <div class="flex justify-between">
                    <span class="text-gray-600">Maximum:</span>
                    <span class="font-medium">{{ $inventory->maximum_quantity }}</span>
                </div>
                @endif
                <div class="flex justify-between border-t pt-2">
                    <span class="text-gray-600">Total Value:</span>
                    <span class="font-bold text-emerald-600">₱{{ number_format($inventory->total_cost, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Information -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Location & Supplier -->
    @if($inventory->supplier || $inventory->location)
    <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-map-marker-alt text-amber-600 mr-2"></i>
            Location & Supplier
        </h4>
        <div class="space-y-3">
            @if($inventory->supplier)
            <div>
                <h5 class="font-medium text-gray-700 text-sm">Supplier</h5>
                <p class="text-gray-900">{{ $inventory->supplier }}</p>
            </div>
            @endif
            @if($inventory->location)
            <div>
                <h5 class="font-medium text-gray-700 text-sm">Storage Location</h5>
                <p class="text-gray-900">{{ $inventory->location }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Expiry & Notes -->
    @if($inventory->expiry_date || $inventory->notes)
    <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-calendar-alt text-red-600 mr-2"></i>
            Additional Info
        </h4>
        <div class="space-y-3">
            @if($inventory->expiry_date)
            <div>
                <h5 class="font-medium text-gray-700 text-sm">Expiry Date</h5>
                <p class="text-gray-900">{{ $inventory->expiry_date->format('M j, Y') }}</p>
                @if($inventory->expiry_date->isPast())
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 mt-1">
                        <i class="fas fa-exclamation-triangle mr-1"></i>Expired
                    </span>
                @elseif($inventory->expiry_date->diffInDays() <= 30)
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 mt-1">
                        <i class="fas fa-clock mr-1"></i>Expiring Soon
                    </span>
                @endif
            </div>
            @endif
            @if($inventory->notes)
            <div>
                <h5 class="font-medium text-gray-700 text-sm">Notes</h5>
                <p class="text-gray-900 text-sm">{{ $inventory->notes }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Audit Information -->
<div class="content-card rounded-xl shadow-lg border border-gray-200 p-6 mb-6">
    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
        <i class="fas fa-history text-gray-600 mr-2"></i>
        Audit Trail
    </h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h5 class="font-medium text-gray-700 text-sm mb-2">Created</h5>
            <div class="space-y-1">
                <p class="text-gray-900 font-medium">
                    <i class="fas fa-user text-blue-600 mr-1"></i>
                    {{ $inventory->created_by ? $inventory->creator->name : 'System' }}
                </p>
                <p class="text-gray-600 text-sm">
                    <i class="fas fa-clock text-gray-500 mr-1"></i>
                    {{ $inventory->created_at->format('M j, Y \a\t g:i A') }}
                </p>
                <p class="text-gray-500 text-xs">{{ $inventory->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <h5 class="font-medium text-gray-700 text-sm mb-2">Last Updated</h5>
            <div class="space-y-1">
                <p class="text-gray-900 font-medium">
                    <i class="fas fa-user text-emerald-600 mr-1"></i>
                    {{ $inventory->updated_by ? $inventory->updater->name : 'System' }}
                </p>
                <p class="text-gray-600 text-sm">
                    <i class="fas fa-clock text-gray-500 mr-1"></i>
                    {{ $inventory->updated_at->format('M j, Y \a\t g:i A') }}
                </p>
                <p class="text-gray-500 text-xs">{{ $inventory->updated_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
    @if($inventory->created_at->ne($inventory->updated_at))
    <div class="mt-4 pt-4 border-t border-gray-200">
        <div class="flex items-center text-sm text-gray-600">
            <i class="fas fa-info-circle mr-2"></i>
            <span>This item has been modified {{ $inventory->updated_at->diffInDays($inventory->created_at) }} day(s) after creation</span>
        </div>
    </div>
    @endif
</div>

<!-- Action Buttons -->
<div class="flex items-center justify-between">
    <a href="{{ route('admin.inventory.index') }}" 
       class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200 flex items-center space-x-2">
        <i class="fas fa-arrow-left text-sm"></i>
        <span>Back to Inventory</span>
    </a>
    <div class="flex items-center space-x-3">
        <button onclick="window.print()" class="px-4 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg font-medium transition-all duration-150 border border-blue-200 flex items-center space-x-2">
            <i class="fas fa-print text-sm"></i>
            <span>Print</span>
        </button>
        <a href="{{ route('admin.inventory.edit', $inventory) }}" 
           class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md flex items-center space-x-2">
            <i class="fas fa-edit text-sm"></i>
            <span>Edit Item</span>
        </a>
    </div>
</div>
@endsection
