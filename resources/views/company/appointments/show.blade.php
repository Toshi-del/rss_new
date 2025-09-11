@extends('layouts.company')

@section('title', 'Appointment Details')

@section('content')
<div class="min-h-screen bg-gray-50" style="font-family: 'Inter', sans-serif;">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-white border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif; color: #800000;">
                                <i class="fas fa-calendar-check mr-3"></i>Appointment Details
                            </h1>
                            <p class="text-sm text-gray-600">View and manage appointment information</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('company.appointments.edit', $appointment) }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Appointment
                            </a>
                            <a href="{{ route('company.appointments.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Information Card -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Basic Information Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>Basic Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Appointment ID</label>
                                    <p class="text-lg font-semibold text-gray-900">#{{ $appointment->id }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Date</label>
                                    <p class="text-lg font-semibold text-gray-900 flex items-center">
                                        <i class="fas fa-calendar mr-2 text-blue-600"></i>
                                        {{ $appointment->formatted_date }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Time Slot</label>
                                    <p class="text-lg font-semibold text-gray-900 flex items-center">
                                        <i class="fas fa-clock mr-2 text-green-600"></i>
                                        {{ $appointment->formatted_time_slot }}
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Scheduled
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Appointment Type</label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $appointment->appointment_type }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Created By</label>
                                    <p class="text-lg font-semibold text-gray-900 flex items-center">
                                        <i class="fas fa-user mr-2 text-purple-600"></i>
                                        {{ $appointment->creator->full_name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical Tests Card -->
                @if($appointment->blood_chemistry && count($appointment->blood_chemistry) > 0)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-vial mr-2 text-blue-600"></i>Selected Medical Tests
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">{{ count($appointment->blood_chemistry) }} test(s) selected</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @php
                                $medicalTests = \App\Models\MedicalTest::with('category')->whereIn('id', $appointment->blood_chemistry)->get();
                                $totalPrice = $medicalTests->sum('price');
                            @endphp
                            @foreach($medicalTests as $test)
                            <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-gray-900">{{ $test->name }}</h3>
                                    @if($test->description)
                                        <p class="text-xs text-gray-600 mt-1">{{ Str::limit($test->description, 80) }}</p>
                                    @endif
                                    @if($test->category)
                                        <p class="text-xs text-blue-600 mt-1 font-medium">{{ $test->category->name }}</p>
                                    @else
                                        <p class="text-xs text-gray-500 mt-1 font-medium">No category</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-green-600">₱{{ number_format($test->price, 2) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Total Price -->
                        <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Total Price:</span>
                                <span class="text-2xl font-bold text-green-600">₱{{ number_format($totalPrice, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Notes Card -->
                @if($appointment->notes)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-sticky-note mr-2 text-yellow-600"></i>Additional Notes
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $appointment->notes }}</p>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Patients Card -->
                @if($appointment->patients && $appointment->patients->count() > 0)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-users mr-2 text-green-600"></i>Patients
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">{{ $appointment->patients->count() }} patient(s) registered</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @foreach($appointment->patients as $patient)
                            <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $patient->full_name }}</h3>
                                        <p class="text-xs text-gray-600 mt-1">{{ $patient->age_sex }}</p>
                                        @if($patient->email)
                                            <p class="text-xs text-blue-600 mt-1">
                                                <i class="fas fa-envelope mr-1"></i>{{ $patient->email }}
                                            </p>
                                        @endif
                                        @if($patient->phone)
                                            <p class="text-xs text-green-600 mt-1">
                                                <i class="fas fa-phone mr-1"></i>{{ $patient->phone }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- File Upload Card -->
                @if($appointment->excel_file_path)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-file-excel mr-2 text-green-600"></i>Uploaded File
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center p-3 bg-green-50 border border-green-200 rounded-lg">
                            <i class="fas fa-file-excel text-green-600 text-xl mr-3"></i>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-green-800">{{ basename($appointment->excel_file_path) }}</p>
                                <p class="text-xs text-green-600">Excel file uploaded</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Appointment Summary Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-chart-bar mr-2 text-purple-600"></i>Summary
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Patients:</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $appointment->patients->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Medical Tests:</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $appointment->blood_chemistry ? count($appointment->blood_chemistry) : 0 }}</span>
                            </div>
                            @if($appointment->blood_chemistry && count($appointment->blood_chemistry) > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Total Price:</span>
                                <span class="text-sm font-semibold text-green-600">₱{{ number_format($totalPrice, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Created:</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $appointment->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection