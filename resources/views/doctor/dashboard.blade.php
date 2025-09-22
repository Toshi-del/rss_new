@extends('layouts.doctor')

@section('title', 'Doctor Dashboard')

@section('page-title', 'Dashboard Overview')
@section('page-description', 'Monitor your medical examinations and patient statistics')

@section('content')
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Dashboard Container -->
<div class="space-y-6" style="font-family: 'Inter', sans-serif;">
    
    <!-- Welcome Banner -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 flex flex-col md:flex-row md:items-center justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    Welcome, Dr. {{ Auth::user()->fname }} {{ Auth::user()->lname }}
                </h1>
                <p class="text-gray-500">{{ now()->format('l, F d, Y') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="#" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-md flex items-center hover:bg-blue-100 transition-colors">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span>Schedule</span>
                </a>
                <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-md flex items-center hover:bg-blue-700 transition-colors">
                    <i class="fas fa-user-plus mr-2"></i>
                    <span>New Patient</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Patients Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 font-medium">Total Patients</h3>
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-3xl font-bold text-gray-800">{{ $patientCount + $preEmploymentCount }}</p>
                    <p class="text-sm text-gray-500 mt-1">All examinations</p>
                </div>
                <div class="text-right">
                    <div class="flex items-center text-sm text-gray-500 mb-1">
                        <span class="w-3 h-3 bg-blue-500 rounded-sm mr-2"></span>
                        <span>{{ $patientCount }} Annual</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <span class="w-3 h-3 bg-teal-500 rounded-sm mr-2"></span>
                        <span>{{ $preEmploymentCount }} Pre-Emp</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Annual Physical Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 font-medium">Annual Physical</h3>
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-file-medical text-blue-600"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-3xl font-bold text-gray-800">{{ $patientCount }}</p>
                    <p class="text-sm text-gray-500 mt-1">Active patients</p>
                </div>
                <a href="{{ route('doctor.annual-physical') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                    View All
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Pre-Employment Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 font-medium">Pre-Employment</h3>
                <div class="w-10 h-10 rounded-full bg-teal-50 flex items-center justify-center">
                    <i class="fas fa-briefcase text-teal-600"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-3xl font-bold text-gray-800">{{ $preEmploymentCount }}</p>
                    <p class="text-sm text-gray-500 mt-1">Applicants</p>
                </div>
                <a href="{{ route('doctor.pre-employment') }}" class="text-teal-600 hover:text-teal-800 text-sm font-medium flex items-center">
                    View All
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Annual Physical Patients Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between">
            <div class="mb-4 md:mb-0">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mr-3">
                        <i class="fas fa-file-medical text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Annual Physical Patients</h2>
                        <p class="text-gray-500 text-sm">Recent patient examinations</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('doctor.annual-physical') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">
                View All Patients
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        @if($patients->count() > 0)
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($patients->take(6) as $patient)
                <div class="bg-white rounded-lg border border-gray-100 p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-white font-bold text-lg">
                                    {{ strtoupper(substr($patient->full_name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $patient->full_name }}</h3>
                                <p class="text-gray-500 text-sm">{{ $patient->age_sex }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Annual Physical
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-gray-50 rounded-md p-3">
                            <p class="text-xs font-medium text-gray-500 mb-1">Email</p>
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $patient->email }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-md p-3">
                            <p class="text-xs font-medium text-gray-500 mb-1">Phone</p>
                            <p class="text-sm font-medium text-gray-800">{{ $patient->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-md p-3 mb-4">
                        <p class="text-xs font-medium text-gray-500 mb-1">Appointment</p>
                        <p class="text-sm font-medium text-gray-800">
                            @if($patient->appointment)
                                {{ optional($patient->appointment->medicalTestCategory)->name }}
                                @if($patient->appointment->medicalTest)
                                    - {{ $patient->appointment->medicalTest->name }}
                                @endif
                            @else
                                No Appointment Scheduled
                            @endif
                        </p>
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">
                            <i class="fas fa-eye mr-2"></i>
                            View Details
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-file-medical text-blue-600 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">No Annual Physical Patients</h3>
            <p class="text-gray-500 mb-4">No annual physical examination patients found.</p>
        </div>
        @endif
    </div>

    <!-- Pre-Employment Patients Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between">
            <div class="mb-4 md:mb-0">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-teal-50 flex items-center justify-center mr-3">
                        <i class="fas fa-briefcase text-teal-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Pre-Employment Applicants</h2>
                        <p class="text-gray-500 text-sm">Job applicant medical screenings</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('doctor.pre-employment') }}" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-md text-sm font-medium hover:bg-teal-700 transition-colors">
                View All Applicants
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        @if($preEmployments->count() > 0)
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($preEmployments->take(6) as $preEmployment)
                <div class="bg-white rounded-lg border border-gray-100 p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-teal-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-white font-bold text-lg">
                                    {{ strtoupper(substr($preEmployment->first_name, 0, 1) . substr($preEmployment->last_name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $preEmployment->first_name }} {{ $preEmployment->last_name }}</h3>
                                <p class="text-gray-500 text-sm">{{ $preEmployment->age }} years, {{ $preEmployment->sex }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                            Pre-Employment
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-gray-50 rounded-md p-3">
                            <p class="text-xs font-medium text-gray-500 mb-1">Company</p>
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $preEmployment->company_name }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-md p-3">
                            <p class="text-xs font-medium text-gray-500 mb-1">Package</p>
                            <p class="text-sm font-medium text-gray-800">{{ $preEmployment->billing_type }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-gray-50 rounded-md p-3">
                            <p class="text-xs font-medium text-gray-500 mb-1">Email</p>
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $preEmployment->email }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-md p-3">
                            <p class="text-xs font-medium text-gray-500 mb-1">Phone</p>
                            <p class="text-sm font-medium text-gray-800">{{ $preEmployment->phone_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-md p-3 mb-4">
                        <p class="text-xs font-medium text-gray-500 mb-1">Medical Examination</p>
                        <p class="text-sm font-medium text-gray-800">{{ $preEmployment->medical_exam_type ?? 'Standard' }}</p>
                        @if($preEmployment->blood_tests)
                            <p class="text-xs text-gray-500 mt-1">Blood Tests: {{ implode(', ', $preEmployment->blood_tests) }}</p>
                        @endif
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-md text-sm font-medium hover:bg-teal-700 transition-colors">
                            <i class="fas fa-eye mr-2"></i>
                            View Details
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-20 h-20 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-briefcase text-teal-600 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">No Pre-Employment Applicants</h3>
            <p class="text-gray-500 mb-4">No pre-employment examination applicants found.</p>
        </div>
        @endif
    </div>
</div>
@endsection