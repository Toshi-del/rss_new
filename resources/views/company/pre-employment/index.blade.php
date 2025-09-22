@extends('layouts.company')

@section('title', 'Pre-Employment Files')

@section('content')
<div class="min-h-screen" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-user-tie mr-3"></i>Pre-Employment Files
                        </h1>
                        <p class="text-blue-100">Manage pre-employment medical records and examinations</p>
                    </div>
                    <div>
                        <a href="{{ route('company.pre-employment.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-lg text-sm font-bold hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 transition-all duration-200 shadow-sm">
                            <i class="fas fa-plus mr-2"></i>
                            New Pre-Employment File
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-emerald-600 to-emerald-700">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-white text-xl mr-3"></i>
                    <span class="text-white font-medium">{{ session('success') }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Pre-Employment Records -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-indigo-700 border-l-4 border-indigo-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-list mr-3"></i>Pre-Employment Records
                </h2>
                <p class="text-indigo-100 mt-1">{{ isset($files) ? $files->count() : 0 }} record(s) found</p>
            </div>
            
            <div class="p-8">
                @forelse($files as $file)
                <div class="mb-6 last:mb-0 bg-gray-50 rounded-xl p-6 border-l-4 border-blue-600 hover:shadow-md transition-shadow duration-200">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        
                        <!-- Personal Information -->
                        <div class="lg:col-span-1">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-white font-bold text-lg">
                                        {{ strtoupper(substr($file->first_name, 0, 1) . substr($file->last_name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $file->full_name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $file->age }} years old • {{ $file->sex }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="lg:col-span-1">
                            <div class="space-y-2">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-envelope text-blue-600 w-4 mr-2"></i>
                                    <span class="text-gray-900">{{ $file->email }}</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-phone text-green-600 w-4 mr-2"></i>
                                    <span class="text-gray-900">{{ $file->phone_number }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Medical Tests & Billing Information -->
                        <div class="lg:col-span-1">
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Medical Tests</p>
                                    @php
                                        $allTests = $file->all_selected_tests;
                                    @endphp
                                    @if($allTests->count() > 0)
                                        <div class="space-y-1">
                                            @foreach($allTests->take(2) as $test)
                                                <div class="flex items-center">
                                                    <span class="text-sm font-semibold text-gray-900">{{ $test['test_name'] }}</span>
                                                    @if($test['is_primary'])
                                                        <span class="ml-1 inline-flex items-center px-1 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                            <i class="fas fa-star mr-1"></i>Primary
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-gray-600">{{ $test['category_name'] }} • ₱{{ number_format($test['price'], 2) }}</p>
                                            @endforeach
                                            @if($allTests->count() > 2)
                                                <p class="text-xs text-blue-600 font-medium">+{{ $allTests->count() - 2 }} more test(s)</p>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500">No tests selected</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Billing</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        {{ $file->billing_type === 'Company' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $file->billing_type }}
                                    </span>
                                    @if($file->company_name)
                                        <p class="text-xs text-gray-600 mt-1">{{ $file->company_name }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Summary & Actions -->
                        <div class="lg:col-span-1">
                            <div class="flex flex-col items-end justify-between h-full">
                                <!-- Summary -->
                                <div class="text-right mb-4">
                                    <div class="bg-green-50 rounded-lg p-3 border-l-4 border-green-600">
                                        <p class="text-xs font-medium text-green-700 uppercase tracking-wider mb-1">Total Price</p>
                                        <p class="text-xl font-bold text-green-900">₱{{ number_format($file->total_price ?? 0, 2) }}</p>
                                        @if($allTests->count() > 1)
                                            <p class="text-xs text-green-600 mt-1">{{ $allTests->count() }} tests selected</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div>
                                    <a href="{{ route('company.pre-employment.show', $file) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                        <i class="fas fa-eye mr-2"></i>
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-tie text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No pre-employment records found</h3>
                    <p class="text-gray-600 mb-6">Get started by creating your first pre-employment record.</p>
                    <a href="{{ route('company.pre-employment.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Create First Record
                    </a>
                </div>
                @endforelse

                <!-- Pagination -->
                @if(isset($files) && $files instanceof \Illuminate\Pagination\LengthAwarePaginator && $files->hasPages())
                <div class="mt-8 pt-6 border-t border-gray-200">
                    {{ $files->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 