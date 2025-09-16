@extends('layouts.admin')

@section('title', 'Edit Medical Test')
@section('page-title', 'Edit Medical Test')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-6">
    <div class="max-w-5xl mx-auto space-y-8">
        
        <!-- Enhanced Header Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <a href="{{ route('medical-test-categories.show', $medicalTest->medical_test_category_id) }}" 
                       class="inline-flex items-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl border border-gray-200 transition-all duration-150 shadow-sm font-medium">
                        <i class="fas fa-arrow-left mr-2 text-sm"></i>
                        Back to Category
                    </a>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-edit text-orange-600 text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Edit Medical Test</h1>
                            <p class="text-sm text-gray-600 mt-1">Update medical test information and settings</p>
                        </div>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                    <i class="fas fa-clock"></i>
                    <span>Last updated {{ $medicalTest->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Test Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Test Info -->
            <div class="lg:col-span-2 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-vial text-orange-600 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $medicalTest->name }}</h3>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $medicalTest->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas fa-{{ $medicalTest->is_active ? 'check-circle' : 'times-circle' }} mr-1.5 text-xs"></i>
                                {{ $medicalTest->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <div class="flex items-center space-x-1 text-sm text-gray-600">
                                <i class="fas fa-peso-sign text-gray-400"></i>
                                <span>₱{{ number_format($medicalTest->price, 2) }}</span>
                            </div>
                            <div class="flex items-center space-x-1 text-sm text-gray-600">
                                <i class="fas fa-sort-numeric-down text-gray-400"></i>
                                <span>Order: {{ $medicalTest->sort_order }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @if($medicalTest->description)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ $medicalTest->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Quick Stats -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Test Details</h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Category</span>
                        <span class="text-sm font-medium text-gray-900">{{ $medicalTest->category->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Created</span>
                        <span class="text-sm font-medium text-gray-900">{{ $medicalTest->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $medicalTest->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-orange-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-edit text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Update Test Information</h2>
                            <p class="text-orange-100 text-sm mt-1">Modify the details and settings for this medical test</p>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center space-x-2 text-orange-200 text-sm">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure Form</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('medical-tests.update', $medicalTest) }}" method="POST" class="p-8 space-y-8">
                @csrf
                @method('PUT')

                <!-- Category Selection -->
                <div class="space-y-2">
                    <label for="medical_test_category_id" class="flex items-center text-sm font-semibold text-gray-700">
                        <i class="fas fa-layer-group text-gray-400 mr-2"></i>
                        Category
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <select name="medical_test_category_id" id="medical_test_category_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-150 @error('medical_test_category_id') border-red-500 ring-2 ring-red-200 @enderror" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('medical_test_category_id', $medicalTest->medical_test_category_id) == $category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('medical_test_category_id')
                        <div class="flex items-center space-x-2 mt-2">
                            <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <!-- Test Name -->
                <div class="space-y-2">
                    <label for="name" class="flex items-center text-sm font-semibold text-gray-700">
                        <i class="fas fa-vial text-gray-400 mr-2"></i>
                        Test Name
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $medicalTest->name) }}" 
                           placeholder="Enter test name (e.g., Complete Blood Count, Chest X-Ray)"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-150 @error('name') border-red-500 ring-2 ring-red-200 @enderror" 
                           required>
                    @error('name')
                        <div class="flex items-center space-x-2 mt-2">
                            <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label for="description" class="flex items-center text-sm font-semibold text-gray-700">
                        <i class="fas fa-align-left text-gray-400 mr-2"></i>
                        Description
                        <span class="text-gray-500 text-xs ml-2">(Optional)</span>
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4" 
                              placeholder="Provide a brief description of this test, what it measures, and any special instructions..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-150 resize-none @error('description') border-red-500 ring-2 ring-red-200 @enderror">{{ old('description', $medicalTest->description) }}</textarea>
                    @error('description')
                        <div class="flex items-center space-x-2 mt-2">
                            <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <!-- Settings Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Price -->
                    <div class="space-y-2">
                        <label for="price" class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-peso-sign text-gray-400 mr-2"></i>
                            Price
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">₱</span>
                            </div>
                            <input type="number" 
                                   name="price" 
                                   id="price" 
                                   value="{{ old('price', $medicalTest->price) }}" 
                                   step="0.01" 
                                   min="0" 
                                   placeholder="0.00"
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-150 @error('price') border-red-500 ring-2 ring-red-200 @enderror" 
                                   required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Enter the test price in Philippine Pesos</p>
                        @error('price')
                            <div class="flex items-center space-x-2 mt-2">
                                <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div class="space-y-2">
                        <label for="sort_order" class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-sort-numeric-up text-gray-400 mr-2"></i>
                            Sort Order
                        </label>
                        <input type="number" 
                               name="sort_order" 
                               id="sort_order" 
                               value="{{ old('sort_order', $medicalTest->sort_order) }}" 
                               min="0"
                               placeholder="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-150 @error('sort_order') border-red-500 ring-2 ring-red-200 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Lower numbers appear first in the list</p>
                        @error('sort_order')
                            <div class="flex items-center space-x-2 mt-2">
                                <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Active Status -->
                <div class="space-y-2">
                    <label class="flex items-center text-sm font-semibold text-gray-700">
                        <i class="fas fa-toggle-on text-gray-400 mr-2"></i>
                        Status
                    </label>
                    <div class="flex items-center space-x-4 mt-3">
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   value="1" 
                                   {{ old('is_active', $medicalTest->is_active) ? 'checked' : '' }}
                                   class="w-5 h-5 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2 transition-all duration-150">
                            <span class="ml-3 text-sm font-medium text-gray-700">Active Test</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Active tests are available for booking and appointments</p>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('medical-test-categories.show', $medicalTest->medical_test_category_id) }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-all duration-150 border border-gray-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-xl font-medium transition-all duration-150 shadow-md hover:shadow-lg">
                        <i class="fas fa-save mr-2"></i>
                        Update Test
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="bg-white/60 backdrop-blur-sm rounded-xl border border-white/20 p-6">
            <div class="flex items-start space-x-4">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-lightbulb text-orange-600"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Editing Tips</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-green-500 text-xs"></i>
                            <span>Changes will affect how this test appears in listings</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-green-500 text-xs"></i>
                            <span>Price updates apply to future bookings only</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-green-500 text-xs"></i>
                            <span>Sort order changes will reorder tests in category</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-xs"></i>
                            <span>Deactivating will hide test from new bookings</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
