@extends('layouts.doctor')

@section('title', 'Pre-Employment Examinations')

@section('page-title', 'Pre-Employment Examinations')
@section('page-description', 'Manage and monitor pre-employment medical screenings for job applicants')

@section('content')
<div class="space-y-8" style="font-family: 'Poppins', sans-serif;">
    
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
    
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-orange-600 to-orange-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-briefcase mr-3"></i>Pre-Employment Examinations
                    </h1>
                    <p class="text-orange-100">Medical screenings and health assessments for job applicants</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-orange-500 rounded-lg px-4 py-2">
                        <p class="text-orange-100 text-sm font-medium">Total Applicants</p>
                        <p class="text-white text-lg font-bold">{{ $preEmployments->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Applicant Management Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-violet-600 to-violet-700 border-l-4 border-violet-800">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-user-tie mr-3"></i>Applicant Management
                    </h2>
                    <p class="text-violet-100 mt-1">Pre-employment medical examinations and screening status</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="bg-violet-500 rounded-lg px-3 py-2">
                        <p class="text-violet-100 text-xs font-medium">Active</p>
                        <p class="text-white text-sm font-bold">{{ $preEmployments->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        @if($preEmployments->count() > 0)
        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($preEmployments as $preEmployment)
                <div class="bg-orange-50 rounded-xl p-6 border-l-4 border-orange-600 hover:shadow-md transition-all duration-200">
                    <!-- Applicant Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-orange-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-lg">
                                    {{ strtoupper(substr($preEmployment->first_name, 0, 1) . substr($preEmployment->last_name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-orange-900">{{ $preEmployment->first_name }} {{ $preEmployment->last_name }}</h3>
                                <p class="text-orange-700 text-sm">{{ $preEmployment->age }} years, {{ $preEmployment->sex }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-600 text-white">
                                <i class="fas fa-user-tie mr-1"></i>
                                Applicant
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-600 text-white">
                                <i class="fas fa-briefcase mr-1"></i>
                                Pre-Emp
                            </span>
                        </div>
                    </div>
                    
                    <!-- Company Information -->
                    <div class="bg-white rounded-lg p-4 mb-4">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Company</p>
                        <p class="text-sm font-semibold text-gray-900 mb-2">{{ $preEmployment->company_name }}</p>
                        <div class="flex items-center text-xs text-gray-600">
                            <i class="fas fa-building mr-1"></i>
                            <span>Employment Screening</span>
                        </div>
                    </div>
                    
                    <!-- Medical Examination Details -->
                    <div class="grid grid-cols-1 gap-3 mb-4">
                        <div class="bg-white rounded-lg p-3">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Medical Examination</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $preEmployment->medical_exam_type ?? 'Standard Examination' }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-3">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Blood Chemistry</p>
                            <p class="text-sm font-semibold text-gray-900">
                                @if($preEmployment->blood_tests && count($preEmployment->blood_tests) > 0)
                                    {{ implode(', ', $preEmployment->blood_tests) }}
                                @else
                                    No blood tests required
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="grid grid-cols-3 gap-2">
                        <!-- Send to Admin -->
                        <form action="{{ route('doctor.pre-employment.by-record.submit', $preEmployment->id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 text-xs font-medium flex items-center justify-center shadow-sm hover:shadow-md" 
                                    title="Send to Admin">
                                <i class="fas fa-paper-plane mr-1"></i>
                                <span class="hidden sm:inline">Send</span>
                            </button>
                        </form>
                        
                        <!-- Edit Results -->
                        <a href="{{ route('doctor.pre-employment.examination.edit', $preEmployment->id) }}" 
                           class="w-full px-3 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all duration-200 text-xs font-medium flex items-center justify-center shadow-sm hover:shadow-md" 
                           title="Edit Results">
                            <i class="fas fa-pencil-alt mr-1"></i>
                            <span class="hidden sm:inline">Edit</span>
                        </a>
                        
                        <!-- Medical Checklist -->
                        <a href="{{ route('doctor.medical-checklist.pre-employment', $preEmployment->id) }}" 
                           class="w-full px-3 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-all duration-200 text-xs font-medium flex items-center justify-center shadow-sm hover:shadow-md" 
                           title="Medical Checklist">
                            <i class="fas fa-clipboard-list mr-1"></i>
                            <span class="hidden sm:inline">List</span>
                        </a>
                    </div>
                    
                    <!-- Applicant Status Footer -->
                    <div class="mt-4 pt-4 border-t border-orange-200">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-orange-700 font-medium">
                                <i class="fas fa-calendar mr-1"></i>
                                Last Updated: {{ $preEmployment->updated_at->format('M d, Y') }}
                            </span>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                                <span class="text-orange-700 font-medium">Active</span>
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
        <div class="p-12 text-center">
            <div class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-briefcase text-orange-600 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Pre-Employment Applicants</h3>
            <p class="text-gray-600 mb-6">No pre-employment examination records found. Applicants will appear here when they register for medical screenings.</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('doctor.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-lg font-medium hover:bg-orange-700 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 