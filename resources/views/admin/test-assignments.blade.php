@extends('layouts.admin')

@section('title', 'Test Assignments - RSS Citi Health Services')
@section('page-title', 'Medical Test Assignments')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-tasks text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Medical Test Assignments</h3>
                        <p class="text-purple-100 text-sm">Track and manage test assignments to medical staff</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Staff Role Filter -->
                    <div class="relative">
                        <select id="staffRoleFilter" class="glass-morphism px-4 py-2 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 border border-white/20">
                            <option value="all" class="text-gray-900">All Staff Roles</option>
                            @foreach($staffRoles as $role => $name)
                                <option value="{{ $role }}" class="text-gray-900" {{ $staffRole === $role ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Status Filter -->
                    <div class="relative">
                        <select id="statusFilter" class="glass-morphism px-4 py-2 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 border border-white/20">
                            <option value="all" class="text-gray-900">All Status</option>
                            <option value="pending" class="text-gray-900" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" class="text-gray-900" {{ $status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" class="text-gray-900" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" class="text-gray-900" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="content-card rounded-xl p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Assignments</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-blue-600 text-lg"></i>
                </div>
            </div>
        </div>
        
        <div class="content-card rounded-xl p-6 border-l-4 border-yellow-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-lg"></i>
                </div>
            </div>
        </div>
        
        <div class="content-card rounded-xl p-6 border-l-4 border-orange-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">In Progress</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['in_progress'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-spinner text-orange-600 text-lg"></i>
                </div>
            </div>
        </div>
        
        <div class="content-card rounded-xl p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Completed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Assignments Table -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full" id="assignmentsTable">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">ID</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Appointment</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Medical Test</th>

                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Assigned To</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Status</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Assigned Date</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($assignments as $assignment)
                        <tr class="hover:bg-purple-50 transition-all duration-200 border-l-4 border-transparent hover:border-purple-400">
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-sm font-bold text-gray-700">
                                        {{ $assignment->id }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-md">
                                        <span class="text-white font-bold text-xs">
                                            #{{ $assignment->appointment->id }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $assignment->appointment->creator->company ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($assignment->appointment->appointment_date)->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="bg-amber-50 px-3 py-2 rounded-lg border border-amber-200">
                                    <div class="text-sm font-medium text-amber-800">
                                        {{ $assignment->medicalTest->name }}
                                    </div>
                                    @if($assignment->medicalTest->description)
                                        <div class="text-xs text-amber-600 mt-1">
                                            {{ Str::limit($assignment->medicalTest->description, 50) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    @php
                                        $roleColors = [
                                            'doctor' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'nurse' => 'bg-green-100 text-green-800 border-green-200',
                                            'phlebotomist' => 'bg-red-100 text-red-800 border-red-200',
                                            'pathologist' => 'bg-purple-100 text-purple-800 border-purple-200',
                                            'radiologist' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                            'radtech' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
                                            'ecg_tech' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            'med_tech' => 'bg-pink-100 text-pink-800 border-pink-200',
                                        ];
                                        $colorClass = $roleColors[$assignment->staff_role] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border {{ $colorClass }}">
                                        <i class="fas fa-user-md mr-1.5 text-xs"></i>
                                        {{ $routingService->getStaffRoleDisplayName($assignment->staff_role) }}
                                    </span>
                                </div>
                            </td>
                          
                            <td class="py-5 px-6 border-r border-gray-100">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'in_progress' => 'bg-orange-100 text-orange-800 border-orange-200',
                                        'completed' => 'bg-green-100 text-green-800 border-green-200',
                                        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                    ];
                                    $statusIcons = [
                                        'pending' => 'fas fa-clock',
                                        'in_progress' => 'fas fa-spinner',
                                        'completed' => 'fas fa-check-circle',
                                        'cancelled' => 'fas fa-times-circle',
                                    ];
                                    $statusClass = $statusColors[$assignment->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                    $statusIcon = $statusIcons[$assignment->status] ?? 'fas fa-question-circle';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border {{ $statusClass }}">
                                    <i class="{{ $statusIcon }} mr-1.5 text-xs"></i>
                                    {{ ucfirst(str_replace('_', ' ', $assignment->status)) }}
                                </span>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center space-x-2 bg-blue-50 px-3 py-2 rounded-lg border border-blue-200">
                                    <i class="fas fa-calendar text-blue-500 text-xs"></i>
                                    <span class="text-sm font-medium text-blue-700">
                                        {{ $assignment->assigned_at ? $assignment->assigned_at->format('M d, Y') : 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="flex items-center space-x-2">
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-xs font-medium transition-all duration-150 border border-blue-200"
                                            onclick="openAssignmentViewModal({{ $assignment->id }})">
                                        <i class="fas fa-eye mr-1"></i>
                                        View
                                    </button>
                                    @if($assignment->status !== 'completed')
                                        <button type="button" 
                                                class="inline-flex items-center px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg text-xs font-medium transition-all duration-150 border border-emerald-200"
                                                onclick="openUpdateStatusModal({{ $assignment->id }}, '{{ $assignment->status }}')">
                                            <i class="fas fa-edit mr-1"></i>
                                            Update
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-16 text-center border-2 border-dashed border-gray-300">
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center border-4 border-purple-300">
                                        <i class="fas fa-tasks text-purple-500 text-3xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 font-semibold text-lg">No test assignments found</p>
                                        <p class="text-gray-500 text-sm mt-1">Test assignments will appear here when appointments are approved</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(method_exists($assignments, 'links'))
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $assignments->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<script>
// Filter functionality
document.getElementById('staffRoleFilter').addEventListener('change', function() {
    updateFilters();
});

document.getElementById('statusFilter').addEventListener('change', function() {
    updateFilters();
});

function updateFilters() {
    const staffRole = document.getElementById('staffRoleFilter').value;
    const status = document.getElementById('statusFilter').value;
    
    const url = new URL(window.location);
    url.searchParams.set('staff_role', staffRole);
    url.searchParams.set('status', status);
    
    window.location.href = url.toString();
}

function openAssignmentViewModal(assignmentId) {
    // Implementation for viewing assignment details
    console.log('View assignment:', assignmentId);
}

function openUpdateStatusModal(assignmentId, currentStatus) {
    // Implementation for updating assignment status
    console.log('Update assignment:', assignmentId, 'Current status:', currentStatus);
}
</script>
@endsection
