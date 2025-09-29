@extends('layouts.doctor')

@section('title', 'Medical Test Categories')
@section('page-title', 'Medical Test Categories')
@section('page-description', 'View and manage medical test categories')

@section('content')
<div class="space-y-8">
    
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-600">
        <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2">
                        <i class="fas fa-list-alt mr-3"></i>Medical Test Categories
                    </h1>
                    <p class="text-blue-100">Organize and manage medical test categories</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-800 bg-opacity-50 rounded-lg px-4 py-2 border border-blue-500">
                        <p class="text-blue-200 text-sm font-medium">Total Categories</p>
                        <p class="text-white text-lg font-bold">{{ $categories->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-green-500">
        <div class="px-8 py-6 bg-gradient-to-r from-green-500 to-green-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-white font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" class="text-green-200 hover:text-white transition-colors duration-200" onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-purple-600 to-purple-700 border-l-4 border-purple-800">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">
                        <i class="fas fa-search mr-3"></i>Search Categories
                    </h2>
                    <p class="text-purple-100 mt-1">Find medical test categories by name or description</p>
                </div>
            </div>
        </div>
        
        <div class="p-8">
            <form method="GET" action="{{ route('medical-test-categories.index') }}" class="space-y-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ $search }}" 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="Search categories by name or description...">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Search
                        </button>
                        @if($search)
                        <a href="{{ route('medical-test-categories.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Clear
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-xl mr-4">
                    <i class="fas fa-layer-group text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ $search ? 'Found Categories' : 'Total Categories' }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $categories->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-xl mr-4">
                    <i class="fas fa-vials text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Tests</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $categories->sum('medical_tests_count') }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-xl mr-4">
                    <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Categories</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $categories->where('medical_tests_count', '>', 0)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-xl mr-4">
                    <i class="fas fa-microscope text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Current Page</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $categories->currentPage() }} of {{ $categories->lastPage() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-gray-600 to-gray-700 border-l-4 border-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">
                        <i class="fas fa-th-large mr-3"></i>Categories Overview
                    </h2>
                    <p class="text-gray-100 mt-1">Browse all medical test categories and their tests</p>
                </div>
            </div>
        </div>
        
        <div class="p-8">
            @if($categories->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($categories as $category)
                    <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-flask text-blue-600 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $category->medical_tests_count }} tests</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($category->description)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $category->description }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->medical_tests_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ $category->medical_tests_count > 0 ? 'Active' : 'Empty' }}
                                </span>
                            </div>
                            <a href="{{ route('medical-test-categories.show', $category->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <i class="fas fa-eye mr-2"></i>
                                View Details
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($categories->hasPages())
                <div class="mt-8 flex items-center justify-between border-t border-gray-200 pt-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if($categories->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <a href="{{ $categories->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                        @endif

                        @if($categories->hasMorePages())
                            <a href="{{ $categories->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        @else
                            <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-not-allowed">
                                Next
                            </span>
                        @endif
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ $categories->firstItem() }}</span> to <span class="font-medium">{{ $categories->lastItem() }}</span> of <span class="font-medium">{{ $categories->total() }}</span> results
                                @if($search)
                                    for "<span class="font-medium text-purple-600">{{ $search }}</span>"
                                @endif
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                {{-- Previous Page Link --}}
                                @if($categories->onFirstPage())
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $categories->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                                    @if($page == $categories->currentPage())
                                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-purple-50 text-sm font-medium text-purple-600">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if($categories->hasMorePages())
                                    <a href="{{ $categories->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                @endif
                            </nav>
                        </div>
                    </div>
                </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-{{ $search ? 'search' : 'list-alt' }} text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        {{ $search ? 'No Categories Found' : 'No Categories Available' }}
                    </h3>
                    <p class="text-gray-500">
                        @if($search)
                            No categories match your search criteria. Try adjusting your search terms.
                        @else
                            No medical test categories are currently available.
                        @endif
                    </p>
                    @if($search)
                        <div class="mt-4">
                            <a href="{{ route('medical-test-categories.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                <i class="fas fa-times mr-2"></i>
                                Clear Search
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
