@extends('layouts.admin')

@section('title', 'Medical Test Categories')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50" style="font-family: 'Inter', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Modern Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif;">Medical Test Categories</h1>
                    <p class="text-sm text-gray-600">Organize and manage your medical test categories efficiently</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('medical-test-categories.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl text-sm font-semibold text-white shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Add New Category
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
                        <i class="fas fa-layer-group text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Categories</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $categories->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl mr-4">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Active Categories</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $categories->where('is_active', true)->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-xl mr-4">
                        <i class="fas fa-vial text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Tests</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $categories->sum('medical_tests_count') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl mr-4">
                        <i class="fas fa-chart-bar text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Avg per Category</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $categories->count() > 0 ? round($categories->sum('medical_tests_count') / $categories->count(), 1) : 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Grid -->
        @if($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $index => $category)
                    
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Card Header -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center">
                                    <div class="min-w-0 flex-1">
                                        <div class="category-name text-gray-900 truncate" style="font-family: 'Poppins', sans-serif;">{{ $category->name }}</div>
                                        @if($category->description)
                                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $category->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <!-- Test Count -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div>
                                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $category->medical_tests_count }}</p>
                                        <p class="text-xs text-gray-500">{{ Str::plural('test', $category->medical_tests_count) }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 mb-1">Sort Order</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $category->sort_order }}</p>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-6">
                                <div class="flex justify-between text-xs text-gray-500 mb-2">
                                    <span>Test Coverage</span>
                                    <span>{{ $category->medical_tests_count }} tests</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-1000" 
                                         style="width: {{ min(($category->medical_tests_count / 10) * 100, 100) }}%"></div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('medical-test-categories.show', $category) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>
                                    View
                                </a>
                                <a href="{{ route('medical-test-categories.edit', $category) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit
                                </a>
                                <button onclick="openDeleteModal({{ $category->id }}, '{{ $category->name }}')" 
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
                                    <span>Created {{ $category->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-sync-alt mr-1"></i>
                                    <span>Updated {{ $category->updated_at->diffForHumans() }}</span>
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
                        <i class="fas fa-flask text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3" style="font-family: 'Poppins', sans-serif;">No Categories Found</h3>
                    <p class="text-gray-500 mb-8">Get started by creating your first medical test category to organize your examinations.</p>
                    <a href="{{ route('medical-test-categories.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl text-sm font-semibold text-white shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Create Your First Category
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
                <h3 class="text-lg font-bold text-white">Delete Medical Test Category</h3>
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
                        You are about to delete the category "<span id="categoryName" class="font-semibold text-gray-900"></span>".
                    </p>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-sm mt-0.5"></i>
                            <div class="text-sm text-yellow-800">
                                <p class="font-medium">Warning:</p>
                                <p>This action will permanently delete the category and all associated medical tests. This cannot be undone.</p>
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
                    Delete Category
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
let currentCategoryId = null;

function openDeleteModal(categoryId, categoryName) {
    currentCategoryId = categoryId;
    document.getElementById('categoryName').textContent = categoryName;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentCategoryId = null;
}

function confirmDelete() {
    if (currentCategoryId) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/medical-test-categories/${currentCategoryId}`;
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
.category-name {
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

.medical-card {
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
