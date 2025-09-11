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
                        <dd class="mt-1 text-sm text-gray-900">{{ $record->medical_exam_type }}</dd>
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
                    @if($record->blood_tests && count($record->blood_tests) > 0)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Blood Tests</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <div class="flex flex-wrap gap-2">
                                @foreach($record->blood_tests as $test)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $test }}</span>
                                @endforeach
                            </div>
                        </dd>
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
    </div>
</div>
@endsection 