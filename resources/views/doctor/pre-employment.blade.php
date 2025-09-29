@extends('layouts.doctor')

@section('title', 'Pre-Employment Examinations - RSS Citi Health Services')
@section('page-title', 'Pre-Employment Examinations')
@section('page-description', 'Manage and monitor pre-employment medical screenings for job applicants')

@section('content')
<div class="space-y-8">
    
    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="px-8 py-4 bg-green-600">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
                <span class="text-white font-medium">{{ session('success') }}</span>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
        <div class="px-8 py-6 bg-green-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center border border-white border-opacity-30">
                        <i class="fas fa-briefcase text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white mb-1">Pre-Employment Examinations</h1>
                        <p class="text-green-100 text-sm">Medical screenings and health assessments for job applicants</p>
                    </div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl px-6 py-4 border border-white border-opacity-30">
                    <p class="text-green-100 text-sm font-medium">Total Applicants</p>
                    <p class="text-white text-2xl font-bold">{{ $preEmployments->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Applicant Management Section -->
    <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
        <div class="px-8 py-6 bg-green-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center border border-white border-opacity-30">
                        <i class="fas fa-user-tie text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Applicant Management</h2>
                        <p class="text-green-100 text-sm">Pre-employment medical examinations and screening status</p>
                    </div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2 border border-white border-opacity-30">
                    <p class="text-green-100 text-xs font-medium">Active Applicants</p>
                    <p class="text-white text-lg font-bold">{{ $preEmployments->count() }}</p>
                </div>
            </div>
        </div>
        
        @if($preEmployments->count() > 0)
        <div class="p-8">
            <div class="space-y-6">
                @foreach($preEmployments as $preEmployment)
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-200">
                    <!-- Applicant Header -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            @php
                                $initials = strtoupper(substr($preEmployment->first_name, 0, 1) . substr($preEmployment->last_name, 0, 1));
                                $colors = ['bg-green-500', 'bg-teal-500', 'bg-blue-500', 'bg-indigo-500', 'bg-cyan-500'];
                                $colorIndex = crc32($preEmployment->id) % count($colors);
                            @endphp
                            <div class="w-14 h-14 {{ $colors[$colorIndex] }} rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-lg">{{ $initials }}</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $preEmployment->first_name }} {{ $preEmployment->last_name }}</h3>
                                <p class="text-gray-500 text-sm">{{ $preEmployment->age }} years, {{ $preEmployment->sex }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-briefcase mr-1"></i>Pre-Employment
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-user-tie mr-1"></i>Job Applicant
                            </span>
                        </div>
                    </div>
                    
                    <!-- Company Information -->
                    <div class="bg-green-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-building text-green-600 mr-2"></i>
                            <span class="text-sm font-medium text-green-800">Company Information</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-900 mb-1">{{ $preEmployment->company_name }}</p>
                        <p class="text-xs text-green-600">Employment Medical Screening</p>
                    </div>
                    
                    <!-- Medical Examination Details -->
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Medical Examination</span>
                            <span class="text-sm font-medium text-gray-900">{{ $preEmployment->medical_exam_type ?? 'Standard Examination' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Blood Chemistry</span>
                            <span class="text-sm font-medium text-gray-900 text-right ml-4">
                                @if($preEmployment->blood_tests && count($preEmployment->blood_tests) > 0)
                                    {{ implode(', ', $preEmployment->blood_tests) }}
                                @else
                                    No blood tests required
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-500">Email</span>
                            <span class="text-sm font-medium text-gray-900 truncate ml-4">{{ $preEmployment->email }}</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between space-x-3 mb-4">
                        <!-- Send to Admin -->
                        <form action="{{ route('doctor.pre-employment.by-record.submit', $preEmployment->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm font-medium flex items-center justify-center" 
                                    title="Send to Admin">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Submit to Admin
                            </button>
                        </form>
                        
                        <!-- Edit Results -->
                        <a href="{{ route('doctor.pre-employment.examination.edit', $preEmployment->id) }}" 
                           class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 text-sm font-medium flex items-center justify-center" 
                           title="Edit Results">
                            <i class="fas fa-pencil-alt mr-2"></i>
                            Update Results
                        </a>
                        
                        <!-- Medical Checklist -->
                        <a href="{{ route('doctor.medical-checklist.pre-employment', $preEmployment->id) }}" 
                           class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all duration-200 text-sm font-medium flex items-center justify-center" 
                           title="Medical Checklist">
                            <i class="fas fa-clipboard-list mr-2"></i>
                            Checklist
                        </a>
                    </div>
                    
                    <!-- Applicant Status Footer -->
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                <span>Last Updated: {{ $preEmployment->updated_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-green-600 font-medium text-sm">Active Screening</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination if needed -->
            @if(method_exists($preEmployments, 'links'))
            <div class="mt-8">
                {{ $preEmployments->links() }}
            </div>
            @endif
        </div>
        @else
        <!-- Empty State -->
        <div class="p-16 text-center">
            <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-briefcase text-green-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Pre-Employment Applicants</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">No pre-employment examination records found. Applicants will appear here when they register for medical screenings.</p>
            <div class="flex justify-center">
                <a href="{{ route('doctor.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 