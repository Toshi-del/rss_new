@extends('layouts.radtech')

@section('title', 'Radtech Dashboard - RSS Citi Health Services')
@section('page-title', 'Radtech Dashboard')
@section('page-description', 'Radiologic technologist dashboard and X-ray management')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="content-card rounded-xl overflow-hidden shadow-xl border-2 border-gray-200">
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-x-ray text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Welcome, {{ auth()->user()->name ?? 'Radiologic Technologist' }}</h2>
                        <p class="text-cyan-100 text-sm">Radiologic technologist dashboard and X-ray management system</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-white/90 text-sm">Current Time</div>
                    <div id="current-time" class="text-white font-bold text-lg"></div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="content-card rounded-xl shadow-lg border border-green-200 p-4 bg-green-50">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600"></i>
                </div>
                <p class="text-green-800 font-semibold">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Pre-Employment Records -->
        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-briefcase text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pre-Employment Records</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $preEmploymentCount }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="text-blue-600 font-medium">
                        <i class="fas fa-x-ray mr-1"></i>X-ray Required
                    </span>
                    <span class="text-gray-600 ml-2">examinations</span>
                </div>
            </div>
            <div class="mt-4">
                <a href="#pre-employment-section" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View Records →
                </a>
            </div>
        </div>

        <!-- Annual Physical Patients -->
        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-md text-emerald-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Annual Physical Patients</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $patientCount }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="text-emerald-600 font-medium">
                        <i class="fas fa-stethoscope mr-1"></i>Physical Exam
                    </span>
                    <span class="text-gray-600 ml-2">X-ray needed</span>
                </div>
            </div>
            <div class="mt-4">
                <a href="#annual-physical-section" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium">
                    View Patients →
                </a>
            </div>
        </div>

        <!-- Recent Appointments -->
        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Recent Appointments</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $appointmentCount }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="text-purple-600 font-medium">
                        <i class="fas fa-clock mr-1"></i>Scheduled
                    </span>
                    <span class="text-gray-600 ml-2">appointments</span>
                </div>
            </div>
            <div class="mt-4">
                <a href="#appointments-section" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                    View Schedule →
                </a>
            </div>
        </div>
    </div>

    <!-- Pre-Employment Records Section -->
    <div id="pre-employment-section" class="content-card rounded-xl shadow-xl border-2 border-gray-200 mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-briefcase text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Pre-Employment Records</h3>
                        <p class="text-blue-100 text-sm">X-ray management for pre-employment examinations</p>
                    </div>
                </div>
                <div class="px-4 py-2 bg-white/10 text-white rounded-lg backdrop-blur-sm border border-white/20 font-medium">
                    <i class="fas fa-x-ray mr-2"></i>X-Ray Required
                </div>
            </div>
        </div>
        
        <div class="p-0">
            @if($preEmployments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Applicant</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Age & Gender</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($preEmployments as $preEmployment)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-blue-600 font-semibold text-sm">
                                                    {{ substr($preEmployment->first_name, 0, 1) }}{{ substr($preEmployment->last_name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $preEmployment->first_name }} {{ $preEmployment->last_name }}</p>
                                                <p class="text-xs text-gray-500">Record ID: #{{ $preEmployment->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm text-gray-900 font-medium">{{ $preEmployment->company_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $preEmployment->position ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium">{{ $preEmployment->age ?? 'N/A' }} years old</p>
                                            <p class="text-xs text-gray-500">{{ $preEmployment->sex ?? 'Not specified' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClass = match($preEmployment->status) {
                                                'approved' => 'bg-green-100 text-green-800',
                                                'declined' => 'bg-red-100 text-red-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                            <i class="fas fa-check-circle mr-1"></i>{{ ucfirst($preEmployment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button onclick="openMedicalChecklistModal('pre-employment', {{ $preEmployment->id }})" class="bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 transition-colors duration-200 font-medium" title="X-Ray Checklist">
                                            <i class="fas fa-x-ray mr-2"></i>X-Ray Checklist
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-briefcase text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Pre-Employment Records</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no pre-employment records requiring X-ray. New records will appear here once approved.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Annual Physical Patients Section -->
    <div id="annual-physical-section" class="content-card rounded-xl shadow-xl border-2 border-gray-200 mb-8">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-user-md text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Annual Physical Patients</h3>
                        <p class="text-emerald-100 text-sm">X-ray management for annual physical examinations</p>
                    </div>
                </div>
                <div class="px-4 py-2 bg-white/10 text-white rounded-lg backdrop-blur-sm border border-white/20 font-medium">
                    <i class="fas fa-stethoscope mr-2"></i>Physical Exam
                </div>
            </div>
        </div>
        
        <div class="p-0">
            @if($patients->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Patient</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Age & Gender</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Registration Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($patients as $patient)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                                <span class="text-emerald-600 font-semibold text-sm">
                                                    {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                                <p class="text-xs text-gray-500">Patient ID: #{{ $patient->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm text-gray-900">{{ $patient->email }}</p>
                                        <p class="text-xs text-gray-500">{{ $patient->phone ?? 'No phone' }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium">{{ $patient->age ?? 'N/A' }} years old</p>
                                            <p class="text-xs text-gray-500">{{ $patient->sex ?? 'Not specified' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium">{{ $patient->created_at->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ $patient->created_at->diffForHumans() }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button onclick="openMedicalChecklistModal('annual-physical', {{ $patient->id }})" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition-colors duration-200 font-medium" title="X-Ray Checklist">
                                            <i class="fas fa-x-ray mr-2"></i>X-Ray Checklist
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-user-times text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Annual Physical Patients</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no annual physical patients requiring X-ray. New patients will appear here once approved.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Appointments Section -->
    <div id="appointments-section" class="content-card rounded-xl shadow-xl border-2 border-gray-200">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-calendar-alt text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Recent Appointments</h3>
                        <p class="text-purple-100 text-sm">Latest appointment activities and schedules</p>
                    </div>
                </div>
                <div class="px-4 py-2 bg-white/10 text-white rounded-lg backdrop-blur-sm border border-white/20 font-medium">
                    <i class="fas fa-eye mr-2"></i>View Only
                </div>
            </div>
        </div>
        
        <div class="p-0">
            @if($appointments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Patient</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date & Time</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Scheduled</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($appointments as $appointment)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                                @if($appointment->patients->first())
                                                    <span class="text-purple-600 font-semibold text-sm">
                                                        {{ substr($appointment->patients->first()->first_name, 0, 1) }}{{ substr($appointment->patients->first()->last_name, 0, 1) }}
                                                    </span>
                                                @else
                                                    <i class="fas fa-user text-purple-600"></i>
                                                @endif
                                            </div>
                                            <div>
                                                @if($appointment->patients->first())
                                                    <p class="text-sm font-semibold text-gray-900">{{ $appointment->patients->first()->first_name }} {{ $appointment->patients->first()->last_name }}</p>
                                                    <p class="text-xs text-gray-500">Patient ID: #{{ $appointment->patients->first()->id }}</p>
                                                @else
                                                    <p class="text-sm font-semibold text-gray-900">N/A</p>
                                                    <p class="text-xs text-gray-500">No patient assigned</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ $appointment->time_slot }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClass = match($appointment->status) {
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'approved' => 'bg-blue-100 text-blue-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                            $statusIcon = match($appointment->status) {
                                                'completed' => 'fas fa-check-circle',
                                                'cancelled' => 'fas fa-times-circle',
                                                'pending' => 'fas fa-clock',
                                                'approved' => 'fas fa-thumbs-up',
                                                default => 'fas fa-question-circle'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                            <i class="{{ $statusIcon }} mr-1"></i>{{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium">{{ $appointment->created_at->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ $appointment->created_at->diffForHumans() }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-calendar-times text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Recent Appointments</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no recent appointments to display. New appointments will appear here once scheduled.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<!-- Medical Checklist Modal -->
<div id="medicalChecklistModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Medical Checklist</h3>
                <button onclick="closeMedicalChecklistModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="modalContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

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
    
    // Add smooth animations to stats cards
    document.addEventListener('DOMContentLoaded', function() {
        const statsCards = document.querySelectorAll('.content-card');
        statsCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-fade-in-up');
        });
    });

    // Medical Checklist Modal Functions
    function openMedicalChecklistModal(type, id) {
        const modal = document.getElementById('medicalChecklistModal');
        const modalContent = document.getElementById('modalContent');
        const modalTitle = document.getElementById('modalTitle');
        
        // Set title based on type
        if (type === 'pre-employment') {
            modalTitle.textContent = 'Pre-Employment X-Ray Checklist';
        } else {
            modalTitle.textContent = 'Annual Physical X-Ray Checklist';
        }
        
        // Load content via AJAX
        const url = type === 'pre-employment' 
            ? `/radtech/medical-checklist/pre-employment/${id}`
            : `/radtech/medical-checklist/annual-physical/${id}`;
        
        fetch(url)
            .then(response => response.text())
            .then(html => {
                modalContent.innerHTML = html;
                modal.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error loading modal content:', error);
                modalContent.innerHTML = '<p class="text-red-600">Error loading content</p>';
                modal.classList.remove('hidden');
            });
    }

    function closeMedicalChecklistModal() {
        document.getElementById('medicalChecklistModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('medicalChecklistModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeMedicalChecklistModal();
        }
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
</style>
@endpush
