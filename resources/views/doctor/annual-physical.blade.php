@extends('layouts.doctor')

@section('title', 'Annual Physical Examinations')

@section('page-title', 'Annual Physical Examinations')
@section('page-description', 'Manage and monitor annual physical examination patients')

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
        <div class="px-8 py-6 bg-gradient-to-r from-emerald-600 to-emerald-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-file-medical mr-3"></i>Annual Physical Examinations
                    </h1>
                    <p class="text-emerald-100">Comprehensive health examinations and patient management</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-emerald-500 rounded-lg px-4 py-2">
                        <p class="text-emerald-100 text-sm font-medium">Total Patients</p>
                        <p class="text-white text-lg font-bold">{{ $patients->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Patients Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-violet-600 to-violet-700 border-l-4 border-violet-800">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-users mr-3"></i>Patient Management
                    </h2>
                    <p class="text-violet-100 mt-1">Annual physical examination patients and their status</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="bg-violet-500 rounded-lg px-3 py-2">
                        <p class="text-violet-100 text-xs font-medium">Active</p>
                        <p class="text-white text-sm font-bold">{{ $patients->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        @if($patients->count() > 0)
        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($patients as $patient)
                @php $canSend = $canSendByPatientId[$patient->id] ?? false; @endphp
                <div class="bg-emerald-50 rounded-xl p-6 border-l-4 border-emerald-600 hover:shadow-md transition-all duration-200">
                    <!-- Patient Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-emerald-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-lg">
                                    {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-emerald-900">{{ $patient->first_name }} {{ $patient->last_name }}</h3>
                                <p class="text-emerald-700 text-sm">{{ $patient->age }} years, {{ $patient->sex }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-600 text-white">
                                <i class="fas fa-user-injured mr-1"></i>
                                Patient
                            </span>
                            @if($canSend)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-600 text-white">
                                    <i class="fas fa-check mr-1"></i>
                                    Ready
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-600 text-white">
                                    <i class="fas fa-clock mr-1"></i>
                                    Pending
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Medical Information -->
                    <div class="bg-white rounded-lg p-4 mb-4">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Medical Test Category</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ optional($patient->appointment->medicalTestCategory)->name ?? 'Not Assigned' }}
                        </p>
                        @if(optional($patient->appointment)->medicalTest)
                            <p class="text-xs text-gray-600 mt-1">
                                Test: {{ $patient->appointment->medicalTest->name }}
                            </p>
                        @endif
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="grid grid-cols-3 gap-2">
                        <!-- Send to Admin -->
                        <form action="{{ route('doctor.annual-physical.by-patient.submit', $patient->id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-3 py-2 rounded-lg text-xs font-medium transition-all duration-200 flex items-center justify-center {{ $canSend ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm hover:shadow-md' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}" 
                                    title="Send to Admin" 
                                    {{ $canSend ? '' : 'disabled' }}>
                                <i class="fas fa-paper-plane mr-1"></i>
                                <span class="hidden sm:inline">Send</span>
                            </button>
                        </form>
                        
                        <!-- Update Results -->
                        <a href="{{ route('doctor.annual-physical.by-patient.edit', $patient->id) }}" 
                           class="w-full px-3 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all duration-200 text-xs font-medium flex items-center justify-center shadow-sm hover:shadow-md" 
                           title="Update Results">
                            <i class="fas fa-edit mr-1"></i>
                            <span class="hidden sm:inline">Edit</span>
                        </a>
                        
                        <!-- Medical Checklist -->
                        <a href="{{ route('doctor.medical-checklist.annual-physical', $patient->id) }}" 
                           class="w-full px-3 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-all duration-200 text-xs font-medium flex items-center justify-center shadow-sm hover:shadow-md" 
                           title="Medical Checklist">
                            <i class="fas fa-clipboard-list mr-1"></i>
                            <span class="hidden sm:inline">List</span>
                        </a>
                    </div>
                    
                    <!-- Patient Status Footer -->
                    <div class="mt-4 pt-4 border-t border-emerald-200">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-emerald-700 font-medium">
                                <i class="fas fa-calendar mr-1"></i>
                                Last Updated: {{ $patient->updated_at->format('M d, Y') }}
                            </span>
                            <div class="flex items-center space-x-2">
                                @if($canSend)
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-green-700 font-medium">Complete</span>
                                @else
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                    <span class="text-yellow-700 font-medium">In Progress</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination if needed -->
            @if(method_exists($patients, 'links'))
            <div class="mt-8">
                {{ $patients->links() }}
            </div>
            @endif
        </div>
        @else
        <!-- Empty State -->
        <div class="p-12 text-center">
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-file-medical text-emerald-600 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Annual Physical Patients</h3>
            <p class="text-gray-600 mb-6">No annual physical examination patients found. Patients will appear here when they schedule appointments.</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('doctor.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 