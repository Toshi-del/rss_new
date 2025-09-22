@extends('layouts.company')

@section('title', 'Pre-Employment Record Details')

@section('content')
<div class="min-h-screen" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-user-check mr-3"></i>Pre-Employment Record Details
                        </h1>
                        <p class="text-blue-100">View detailed pre-employment medical examination information</p>
                    </div>
                    <div>
                        <a href="{{ route('company.pre-employment.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 transition-all duration-200 shadow-sm">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-indigo-700 border-l-4 border-indigo-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-user mr-3"></i>Personal Information
                </h2>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-6">
                        <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-600">
                            <label class="block text-sm font-medium text-blue-700 mb-2">Record ID</label>
                            <p class="text-xl font-bold text-blue-900">#{{ $record->id }}</p>
                        </div>
                        <div class="p-4 bg-green-50 rounded-lg border-l-4 border-green-600">
                            <label class="block text-sm font-medium text-green-700 mb-2">Full Name</label>
                            <p class="text-lg font-semibold text-green-900">{{ $record->full_name }}</p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="p-4 bg-purple-50 rounded-lg border-l-4 border-purple-600">
                            <label class="block text-sm font-medium text-purple-700 mb-2">Age & Gender</label>
                            <p class="text-lg font-semibold text-purple-900">{{ $record->age }} years old • {{ $record->sex }}</p>
                        </div>
                        <div class="p-4 bg-emerald-50 rounded-lg border-l-4 border-emerald-600">
                            <label class="block text-sm font-medium text-emerald-700 mb-2">Email Address</label>
                            <p class="text-lg font-semibold text-emerald-900 flex items-center">
                                <i class="fas fa-envelope mr-2 text-emerald-600"></i>
                                {{ $record->email }}
                            </p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="p-4 bg-rose-50 rounded-lg border-l-4 border-rose-600">
                            <label class="block text-sm font-medium text-rose-700 mb-2">Phone Number</label>
                            <p class="text-lg font-semibold text-rose-900 flex items-center">
                                <i class="fas fa-phone mr-2 text-rose-600"></i>
                                {{ $record->phone_number }}
                            </p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-gray-600">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Created Date</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $record->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Selected Medical Tests Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-emerald-600 to-emerald-700 border-l-4 border-emerald-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-vial mr-3"></i>Selected Medical Tests
                </h2>
                <p class="text-emerald-100 mt-1">
                    @php
                        $allTests = $record->all_selected_tests;
                        $testsCount = $allTests->count();
                    @endphp
                    {{ $testsCount }} medical test(s) selected
                </p>
            </div>
            <div class="p-8">
                @if($allTests->count() > 0)
                    <!-- Display All Selected Tests -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($allTests as $test)
                            <div class="bg-emerald-50 rounded-xl p-6 border-l-4 border-emerald-600 {{ $test['is_primary'] ? 'ring-2 ring-emerald-300' : '' }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <h3 class="text-lg font-bold text-emerald-900">{{ $test['test_name'] }}</h3>
                                            @if($test['is_primary'])
                                                <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-600 text-white">
                                                    <i class="fas fa-star mr-1"></i>Primary
                                                </span>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-600 text-white">
                                            <i class="fas fa-tag mr-1"></i>
                                            {{ $test['category_name'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-4 text-right">
                                    <p class="text-2xl font-bold text-emerald-600">₱{{ number_format($test['price'], 2) }}</p>
                                    <p class="text-sm text-emerald-700">Test Price</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- No Tests Found -->
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-vial text-gray-400 text-xl"></i>
                        </div>
                        <p class="text-gray-600">No medical tests found for this record.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Additional Information Card -->
        @php
            $parsedOtherExams = $record->parsed_other_exams;
            $hasAdditionalExams = $parsedOtherExams && isset($parsedOtherExams['additional_exams']);
            $hasOtherExams = $record->other_exams && !$parsedOtherExams;
        @endphp
        @if($hasAdditionalExams || $hasOtherExams || $record->uploaded_file)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-amber-600 to-amber-700 border-l-4 border-amber-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-info-circle mr-3"></i>Additional Information
                </h2>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($hasAdditionalExams)
                    <div class="bg-amber-50 rounded-xl p-6 border-l-4 border-amber-600">
                        <h3 class="text-lg font-bold text-amber-900 mb-3">
                            <i class="fas fa-clipboard-list mr-2"></i>Additional Examinations
                        </h3>
                        <p class="text-amber-800 leading-relaxed">{{ $parsedOtherExams['additional_exams'] }}</p>
                    </div>
                    @elseif($hasOtherExams)
                    <div class="bg-amber-50 rounded-xl p-6 border-l-4 border-amber-600">
                        <h3 class="text-lg font-bold text-amber-900 mb-3">
                            <i class="fas fa-clipboard-list mr-2"></i>Other Examinations
                        </h3>
                        <p class="text-amber-800 leading-relaxed">{{ $record->other_exams }}</p>
                    </div>
                    @endif
                    @if($record->uploaded_file)
                    <div class="bg-green-50 rounded-xl p-6 border-l-4 border-green-600">
                        <h3 class="text-lg font-bold text-green-900 mb-3">
                            <i class="fas fa-file-excel mr-2"></i>Uploaded File
                        </h3>
                        <p class="text-green-800">{{ $record->uploaded_file }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Billing & Summary Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-purple-600 to-purple-700 border-l-4 border-purple-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-receipt mr-3"></i>Billing & Summary
                </h2>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-600">
                        <p class="text-blue-700 text-sm font-medium">Billing Type</p>
                        <p class="text-2xl font-bold text-blue-900">{{ $record->billing_type }}</p>
                    </div>
                    @if($record->company_name)
                    <div class="bg-indigo-50 rounded-lg p-4 border-l-4 border-indigo-600">
                        <p class="text-indigo-700 text-sm font-medium">Company Name</p>
                        <p class="text-lg font-bold text-indigo-900">{{ $record->company_name }}</p>
                    </div>
                    @endif
                    <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-600 {{ $record->company_name ? '' : 'md:col-span-2' }}">
                        <p class="text-green-700 text-sm font-medium">Total Price</p>
                        <p class="text-3xl font-bold text-green-900">₱{{ number_format($record->total_price ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 