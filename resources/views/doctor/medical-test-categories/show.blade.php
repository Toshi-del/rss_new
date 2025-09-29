@extends('layouts.doctor')

@section('title', 'Medical Test Category - ' . $category->name)
@section('page-title', 'Medical Test Category')
@section('page-description', 'View category details and associated medical tests')

@section('content')
<div class="space-y-8">
    
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-600">
        <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2">
                        <i class="fas fa-flask mr-3"></i>{{ $category->name }}
                    </h1>
                    <p class="text-blue-100">Medical test category details and associated tests</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-800 bg-opacity-50 rounded-lg px-4 py-2 border border-blue-500">
                        <p class="text-blue-200 text-sm font-medium">Total Tests</p>
                        <p class="text-white text-lg font-bold">{{ $category->medicalTests->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Information -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-green-600 to-green-700 border-l-4 border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">
                        <i class="fas fa-info-circle mr-3"></i>Category Information
                    </h2>
                    <p class="text-green-100 mt-1">Details about this medical test category</p>
                </div>
            </div>
        </div>
        
        <div class="p-8 bg-green-50">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg p-4 border-l-4 border-blue-500">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Category Name</label>
                    <div class="text-lg font-bold text-blue-800">{{ $category->name }}</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-green-500">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Total Tests</label>
                    <div class="text-lg font-bold text-green-800">{{ $category->medicalTests->count() }} tests</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-purple-500">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Status</label>
                    <div class="text-lg font-bold text-purple-800">
                        {{ $category->medicalTests->count() > 0 ? 'Active' : 'Empty' }}
                    </div>
                </div>
            </div>
            
            @if($category->description)
            <div class="mt-6">
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-2 text-gray-600"></i>Description
                    </label>
                    <p class="text-gray-700">{{ $category->description }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Associated Medical Tests -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-indigo-700 border-l-4 border-indigo-800">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">
                        <i class="fas fa-vials mr-3"></i>Associated Medical Tests
                    </h2>
                    <p class="text-indigo-100 mt-1">All medical tests in this category</p>
                </div>
            </div>
        </div>
        
        <div class="p-8">
            @if($category->medicalTests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Test Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($category->medicalTests as $test)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-vial text-indigo-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $test->name }}</div>
                                            <div class="text-sm text-gray-500">Test ID: #{{ $test->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $test->description ?: 'No description available' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">₱{{ number_format($test->price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('medical-tests.edit', $test->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                        <i class="fas fa-edit mr-2"></i>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-vials text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Tests Found</h3>
                    <p class="text-gray-500">This category doesn't have any medical tests yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between">
        <a href="{{ route('medical-test-categories.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Back to Categories
        </a>
        
        @if($category->medicalTests->count() > 0)
        <a href="{{ route('medical-tests.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
            <i class="fas fa-vials mr-2"></i>View All Tests
        </a>
        @endif
    </div>
</div>
@endsection
