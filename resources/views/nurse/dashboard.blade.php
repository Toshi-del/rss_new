@extends('layouts.nurse')

@section('title', 'Nurse Dashboard - RSS Citi Health Services')
@section('page-title', 'Nurse Dashboard')
@section('page-description', 'Medical technologist dashboard and patient management')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="content-card rounded-xl overflow-hidden shadow-xl border-2 border-gray-200">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-user-md text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Welcome, {{ auth()->user()->name ?? 'Medical Technologist' }}</h2>
                        <p class="text-emerald-100 text-sm">Medical technologist dashboard and patient management system</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-white/90 text-sm">Current Time</div>
                    <div id="current-time" class="text-white font-bold text-lg"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Today's Appointments -->
        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-day text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Today's Appointments</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $appointments->count() }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="text-green-600 font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>Active
                    </span>
                    <span class="text-gray-600 ml-2">patient appointments</span>
                </div>
            </div>
        </div>

        <!-- Pending Examinations -->
        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-amber-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending Examinations</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $appointments->where('status', 'pending')->count() }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="text-amber-600 font-medium">
                        <i class="fas fa-clock mr-1"></i>Waiting
                    </span>
                    <span class="text-gray-600 ml-2">for completion</span>
                </div>
            </div>
        </div>

        <!-- Completed Today -->
        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Completed Today</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $appointments->where('status', 'completed')->count() }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="text-emerald-600 font-medium">
                        <i class="fas fa-check mr-1"></i>Finished
                    </span>
                    <span class="text-gray-600 ml-2">examinations</span>
                </div>
            </div>
        </div>

        <!-- Assigned Tasks -->
        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-tasks text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Assigned Tasks</p>
                    <p class="text-lg font-bold text-gray-900">Medical Work</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('nurse.messages') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                    <i class="fas fa-comments mr-1"></i>View Messages
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Appointments Section -->
    <div class="content-card rounded-xl shadow-xl border-2 border-gray-200">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-calendar-alt text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Recent Appointments</h3>
                        <p class="text-emerald-100 text-sm">Latest patient appointments and examinations</p>
                    </div>
                </div>
                <a href="{{ route('nurse.appointments') }}" class="px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors backdrop-blur-sm border border-white/20 font-medium">
                    <i class="fas fa-external-link-alt mr-2"></i>View All
                </a>
            </div>
        </div>
        
        <div class="p-0">
            @if($appointments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Patient</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Medical Test</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Schedule</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($appointments as $appointment)
                                @foreach($appointment->patients as $patient)
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
                                            <div class="text-sm text-gray-900">
                                                @if($appointment->medicalTestCategory)
                                                    <span class="font-medium">{{ $appointment->medicalTestCategory->name }}</span>
                                                    @if($appointment->medicalTest)
                                                        <p class="text-xs text-gray-500">{{ $appointment->medicalTest->name }}</p>
                                                    @endif
                                                @else
                                                    <span class="text-gray-500">{{ $appointment->appointment_type ?? 'General Checkup' }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm">
                                                <p class="text-gray-900 font-medium">{{ $appointment->formatted_date }}</p>
                                                <p class="text-xs text-gray-500">{{ $appointment->formatted_time_slot }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($appointment->status === 'completed')
                                                <span class="px-3 py-1 text-xs font-medium bg-emerald-100 text-emerald-800 rounded-full">
                                                    <i class="fas fa-check-circle mr-1"></i>Completed
                                                </span>
                                            @elseif($appointment->status === 'pending')
                                                <span class="px-3 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full">
                                                    <i class="fas fa-clock mr-1"></i>Pending
                                                </span>
                                            @else
                                                <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                                    <i class="fas fa-question-circle mr-1"></i>{{ ucfirst($appointment->status ?? 'Unknown') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                @if($appointment->status === 'pending')
                                                    <button class="text-emerald-600 hover:text-emerald-900 p-2 hover:bg-emerald-50 rounded-lg transition-colors" 
                                                            title="Complete Examination">
                                                        <i class="fas fa-stethoscope"></i>
                                                    </button>
                                                @endif
                                                <button class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition-colors" 
                                                        title="View Patient Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900 p-2 hover:bg-gray-50 rounded-lg transition-colors" 
                                                        title="View Medical History">
                                                    <i class="fas fa-file-medical"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
                    <a href="{{ route('nurse.appointments') }}" class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-medium">
                        <i class="fas fa-calendar-plus mr-2"></i>View All Appointments
                    </a>
                </div>
            @endif
        </div>
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
    
    // Add smooth animations to stats cards
    document.addEventListener('DOMContentLoaded', function() {
        const statsCards = document.querySelectorAll('.content-card');
        statsCards.forEach((card, index) => {
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
</style>
@endpush
