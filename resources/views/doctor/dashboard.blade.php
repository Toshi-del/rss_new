@extends('layouts.doctor')

@section('title', 'Doctor Dashboard - RSS Citi Health Services')
@section('page-title', 'Doctor Dashboard')
@section('page-description', 'Medical professional dashboard and patient management')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-purple-600 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-xl flex items-center justify-center border border-white border-opacity-30">
                        <i class="fas fa-user-md text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Welcome, Dr. {{ Auth::user()->fname }} {{ Auth::user()->lname }}</h2>
                        <p class="text-purple-100 text-sm">Medical professional dashboard and patient management system</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-white text-opacity-90 text-sm">{{ now()->format('l, F d, Y') }}</div>
                    <div id="current-time" class="text-white font-bold text-lg"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Patients -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Patients</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $patientCount + $preEmploymentCount }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-purple-500 rounded-full mr-2"></span>
                        <span class="text-gray-600">{{ $patientCount }} Annual Physical</span>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm mt-1">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-indigo-500 rounded-full mr-2"></span>
                        <span class="text-gray-600">{{ $preEmploymentCount }} Pre-Employment</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Annual Physical -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-medical text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Annual Physical</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $patientCount }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-sm">
                        <span class="text-blue-600 font-medium">
                            <i class="fas fa-stethoscope mr-1"></i>Active
                        </span>
                        <span class="text-gray-600 ml-2">examinations</span>
                    </div>
                    <a href="{{ route('doctor.annual-physical') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pre-Employment -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-briefcase text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pre-Employment</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $preEmploymentCount }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 font-medium">
                            <i class="fas fa-user-tie mr-1"></i>Applicants
                        </span>
                        <span class="text-gray-600 ml-2">screening</span>
                    </div>
                    <a href="{{ route('doctor.pre-employment') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Annual Physical Patients Section -->
    <div class="bg-white rounded-xl shadow-xl border border-gray-200">
        <div class="bg-purple-600 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center border border-white border-opacity-30">
                        <i class="fas fa-file-medical text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Annual Physical Patients</h3>
                        <p class="text-purple-100 text-sm">Recent patient examinations and medical assessments</p>
                    </div>
                </div>
                <a href="{{ route('doctor.annual-physical') }}" class="px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-white hover:bg-opacity-30 transition-colors border border-white border-opacity-30 font-medium">
                    <i class="fas fa-external-link-alt mr-2"></i>View All
                </a>
            </div>
        </div>
        
        @if($patients->count() > 0)
        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($patients->take(6) as $patient)
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-200">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            @php
                                $initials = strtoupper(substr($patient->full_name, 0, 2));
                                $colors = ['bg-purple-500', 'bg-blue-500', 'bg-indigo-500', 'bg-pink-500', 'bg-red-500'];
                                $colorIndex = crc32($patient->id) % count($colors);
                            @endphp
                            <div class="w-12 h-12 {{ $colors[$colorIndex] }} rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-lg">{{ $initials }}</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $patient->full_name }}</h3>
                                <p class="text-gray-500 text-sm">{{ $patient->age_sex }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            <i class="fas fa-file-medical mr-1"></i>Annual Physical
                        </span>
                    </div>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Email</span>
                            <span class="text-sm font-medium text-gray-900 truncate ml-4">{{ $patient->email }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Phone</span>
                            <span class="text-sm font-medium text-gray-900">{{ $patient->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-500">Appointment</span>
                            <span class="text-sm font-medium text-gray-900 text-right ml-4">
                                @if($patient->appointment)
                                    {{ optional($patient->appointment->medicalTestCategory)->name }}
                                    @if($patient->appointment->medicalTest)
                                        <br><span class="text-xs text-gray-500">{{ $patient->appointment->medicalTest->name }}</span>
                                    @endif
                                @else
                                    No Appointment
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                            <i class="fas fa-stethoscope mr-2"></i>
                            Examine Patient
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="p-16 text-center">
            <div class="w-24 h-24 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-file-medical text-purple-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Annual Physical Patients</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no annual physical examination patients to display. New patients will appear here once scheduled.</p>
            <a href="{{ route('doctor.annual-physical') }}" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
                <i class="fas fa-calendar-plus mr-2"></i>View All Patients
            </a>
        </div>
        @endif
    </div>

    <!-- Pre-Employment Patients Section -->
    <div class="bg-white rounded-xl shadow-xl border border-gray-200">
        <div class="bg-green-600 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center border border-white border-opacity-30">
                        <i class="fas fa-briefcase text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Pre-Employment Applicants</h3>
                        <p class="text-green-100 text-sm">Job applicant medical screenings and assessments</p>
                    </div>
                </div>
                <a href="{{ route('doctor.pre-employment') }}" class="px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-white hover:bg-opacity-30 transition-colors border border-white border-opacity-30 font-medium">
                    <i class="fas fa-external-link-alt mr-2"></i>View All
                </a>
            </div>
        </div>
        
        @if($preEmployments->count() > 0)
        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($preEmployments->take(6) as $preEmployment)
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-200">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            @php
                                $initials = strtoupper(substr($preEmployment->first_name, 0, 1) . substr($preEmployment->last_name, 0, 1));
                                $colors = ['bg-green-500', 'bg-teal-500', 'bg-blue-500', 'bg-indigo-500', 'bg-cyan-500'];
                                $colorIndex = crc32($preEmployment->id) % count($colors);
                            @endphp
                            <div class="w-12 h-12 {{ $colors[$colorIndex] }} rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-lg">{{ $initials }}</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $preEmployment->first_name }} {{ $preEmployment->last_name }}</h3>
                                <p class="text-gray-500 text-sm">{{ $preEmployment->age }} years, {{ $preEmployment->sex }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-briefcase mr-1"></i>Pre-Employment
                        </span>
                    </div>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Company</span>
                            <span class="text-sm font-medium text-gray-900 truncate ml-4">{{ $preEmployment->company_name }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Package</span>
                            <span class="text-sm font-medium text-gray-900">{{ $preEmployment->billing_type }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Email</span>
                            <span class="text-sm font-medium text-gray-900 truncate ml-4">{{ $preEmployment->email }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-500">Phone</span>
                            <span class="text-sm font-medium text-gray-900">{{ $preEmployment->phone_number ?? 'N/A' }}</span>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-3 mb-4">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-stethoscope text-green-600 mr-2"></i>
                            <span class="text-sm font-medium text-green-800">Medical Examination</span>
                        </div>
                        <p class="text-sm text-green-700">{{ $preEmployment->medical_exam_type ?? 'Standard Screening' }}</p>
                        @if($preEmployment->blood_tests)
                            <p class="text-xs text-green-600 mt-1">Blood Tests: {{ implode(', ', $preEmployment->blood_tests) }}</p>
                        @endif
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                            <i class="fas fa-clipboard-check mr-2"></i>
                            Screen Applicant
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="p-16 text-center">
            <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-briefcase text-green-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Pre-Employment Applicants</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no pre-employment examination applicants to display. New applicants will appear here once scheduled.</p>
            <a href="{{ route('doctor.pre-employment') }}" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                <i class="fas fa-user-plus mr-2"></i>View All Applicants
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update current time every minute
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
            hour: 'numeric', 
            minute: '2-digit',
            hour12: true 
        });
        document.getElementById('current-time').textContent = timeString;
    }
    
    // Update time immediately and then every minute
    updateTime();
    setInterval(updateTime, 60000);
    
    // Add smooth animations to cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.content-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-fade-in-up');
        });
    });
</script>

<style>
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }
    
    /* Custom animations and transitions */
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endpush