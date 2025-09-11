@extends('layouts.company')

@section('title', 'Pre-Employment Record Details')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900">Pre-Employment Record Details</h1>
                <a href="{{ route('company.pre-employment.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    Back to List
                </a>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Record Information</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Pre-employment medical examination details.</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Record ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $record->id }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $record->full_name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Age</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $record->age }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Sex</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $record->sex }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $record->email }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $record->phone_number }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Medical Exam Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ optional($record->medicalTestCategory)->name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Selected Test</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ optional($record->medicalTest)->name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Billing Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $record->billing_type }}</dd>
                    </div>
                    @if($record->company_name)
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Company Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $record->company_name }}</dd>
                    </div>
                    @endif
                    
                    @if($record->other_exams)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Other Exams</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $record->other_exams }}</dd>
                    </div>
                    @endif
                    @if($record->uploaded_file)
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Uploaded File</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $record->uploaded_file }}</dd>
                    </div>
                    @endif
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $record->created_at->format('M d, Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
        
        <!-- Selected Medical Test Card -->
        @if($record->medicalTest)
        <div class="bg-white shadow rounded-lg overflow-hidden mt-6">
            <div class="px-4 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-vial mr-2 text-blue-600"></i>Selected Medical Test
                </h2>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-gray-900">{{ $record->medicalTest->name }}</h3>
                        @if($record->medicalTest->description)
                            <p class="text-xs text-gray-600 mt-1">{{ Str::limit($record->medicalTest->description, 80) }}</p>
                        @endif
                        @if($record->medicalTestCategory)
                            <p class="text-xs text-blue-600 mt-1 font-medium">{{ $record->medicalTestCategory->name }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-green-600">₱{{ number_format($record->medicalTest->price ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Summary Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden mt-6">
            <div class="px-4 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-chart-bar mr-2 text-purple-600"></i>Summary
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Medical Exam:</span>
                        <span class="text-sm font-semibold text-gray-900">
                            {{ optional($record->medicalTestCategory)->name }}
                            @if($record->medicalTest)
                                - {{ $record->medicalTest->name }}
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Price:</span>
                        <span class="text-sm font-semibold text-green-600">₱{{ number_format($record->total_price ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Created:</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $record->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 