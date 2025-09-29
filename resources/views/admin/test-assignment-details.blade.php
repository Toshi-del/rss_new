@extends('layouts.admin')

@section('title', 'Test Assignment Details - RSS Citi Health Services')
@section('page-title', 'Test Assignment Details')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Test Assignment #{{ $assignment->id }}</h3>
                        <p class="text-purple-100 text-sm">Detailed view of medical test assignment</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.test-assignments') }}" 
                       class="glass-morphism px-4 py-2 rounded-lg text-white text-sm hover:bg-white/10 transition-all duration-200 border border-white/20">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Assignments
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Assignment Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Assignment Information -->
            <div class="content-card rounded-xl p-6 shadow-lg border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="text-lg font-bold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                        Assignment Information
                    </h4>
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
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold border {{ $statusClass }}">
                        <i class="{{ $statusIcon }} mr-2"></i>
                        {{ ucfirst(str_replace('_', ' ', $assignment->status)) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <label class="text-sm font-medium text-gray-600">Assignment ID</label>
                            <p class="text-lg font-bold text-gray-900">#{{ $assignment->id }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <label class="text-sm font-medium text-gray-600">Medical Test</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $assignment->medicalTest->name }}</p>
                            @if($assignment->medicalTest->description)
                                <p class="text-sm text-gray-600 mt-1">{{ $assignment->medicalTest->description }}</p>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <label class="text-sm font-medium text-gray-600">Staff Role</label>
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
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-semibold border {{ $colorClass }} mt-1">
                                <i class="fas fa-user-md mr-2"></i>
                                {{ $routingService->getStaffRoleDisplayName($assignment->staff_role) }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <label class="text-sm font-medium text-gray-600">Assigned To</label>
                            @if($assignment->assignedToUser)
                                <div class="flex items-center space-x-3 mt-2">
                                    <div class="w-10 h-10 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">
                                            {{ substr($assignment->assignedToUser->fname ?? 'U', 0, 1) }}{{ substr($assignment->assignedToUser->lname ?? 'N', 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-900">
                                            {{ $assignment->assignedToUser->fname }} {{ $assignment->assignedToUser->lname }}
                                        </p>
                                        <p class="text-sm text-gray-600">{{ $assignment->assignedToUser->email }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-500 italic mt-1">Not assigned to specific user</p>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <label class="text-sm font-medium text-gray-600">Assigned Date</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $assignment->assigned_at ? $assignment->assigned_at->format('M d, Y g:i A') : 'N/A' }}
                            </p>
                            @if($assignment->assigned_at)
                                <p class="text-sm text-gray-600">{{ $assignment->assigned_at->diffForHumans() }}</p>
                            @endif
                        </div>

                        @if($assignment->completed_at)
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <label class="text-sm font-medium text-green-600">Completed Date</label>
                                <p class="text-lg font-semibold text-green-900">
                                    {{ $assignment->completed_at->format('M d, Y g:i A') }}
                                </p>
                                <p class="text-sm text-green-600">{{ $assignment->completed_at->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($assignment->special_notes)
                    <div class="mt-6 bg-amber-50 p-4 rounded-lg border border-amber-200">
                        <label class="text-sm font-medium text-amber-700 flex items-center">
                            <i class="fas fa-sticky-note mr-2"></i>
                            Special Notes
                        </label>
                        <p class="text-amber-800 mt-2">{{ $assignment->special_notes }}</p>
                    </div>
                @endif

                @if($assignment->results)
                    <div class="mt-6 bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <label class="text-sm font-medium text-blue-700 flex items-center">
                            <i class="fas fa-file-medical mr-2"></i>
                            Test Results
                        </label>
                        <div class="mt-2 text-blue-800">
                            @if(is_array(json_decode($assignment->results, true)))
                                @php $results = json_decode($assignment->results, true); @endphp
                                @foreach($results as $key => $value)
                                    <div class="mb-2">
                                        <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                        <span class="ml-2">{{ $value }}</span>
                                    </div>
                                @endforeach
                            @else
                                <p>{{ $assignment->results }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Appointment Details -->
            <div class="content-card rounded-xl p-6 shadow-lg border border-gray-200">
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt text-purple-600 mr-2"></i>
                    Appointment Details
                </h4>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-md">
                            <span class="text-white font-bold text-sm">
                                #{{ $assignment->appointment->id }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Appointment ID</p>
                            <p class="text-lg font-semibold text-gray-900">#{{ $assignment->appointment->id }}</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg border">
                        <p class="text-sm font-medium text-gray-600">Patient/Company</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $assignment->appointment->creator->company ?? $assignment->appointment->creator->fname . ' ' . $assignment->appointment->creator->lname }}</p>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg border">
                        <p class="text-sm font-medium text-gray-600">Medical Test Category</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $assignment->appointment->medicalTestCategory->name ?? 'N/A' }}</p>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg border">
                        <p class="text-sm font-medium text-gray-600">Appointment Date</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($assignment->appointment->appointment_date)->format('M d, Y') }}
                        </p>
                        <p class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($assignment->appointment->appointment_date)->format('l') }}
                        </p>
                    </div>

                    @if($assignment->appointment->appointment_time)
                        <div class="bg-gray-50 p-3 rounded-lg border">
                            <p class="text-sm font-medium text-gray-600">Appointment Time</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($assignment->appointment->appointment_time)->format('g:i A') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="content-card rounded-xl p-6 shadow-lg border border-gray-200">
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-bolt text-purple-600 mr-2"></i>
                    Quick Actions
                </h4>
                
                <div class="space-y-3">
                    @if($assignment->status !== 'completed' && $assignment->status !== 'cancelled')
                        <button type="button" 
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-all duration-150"
                                onclick="openUpdateStatusModal({{ $assignment->id }}, '{{ $assignment->status }}')">
                            <i class="fas fa-edit mr-2"></i>
                            Update Status
                        </button>
                    @endif

                    @if($assignment->status === 'pending')
                        <button type="button" 
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-medium transition-all duration-150"
                                onclick="markInProgress({{ $assignment->id }})">
                            <i class="fas fa-play mr-2"></i>
                            Mark In Progress
                        </button>
                    @endif

                    @if($assignment->status === 'in_progress')
                        <button type="button" 
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all duration-150"
                                onclick="markCompleted({{ $assignment->id }})">
                            <i class="fas fa-check mr-2"></i>
                            Mark Completed
                        </button>
                    @endif

                    <a href="{{ route('admin.appointments') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all duration-150">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        View Appointments
                    </a>
                </div>
            </div>

            <!-- Assignment Timeline -->
            @if($assignment->assigned_at || $assignment->completed_at)
                <div class="content-card rounded-xl p-6 shadow-lg border border-gray-200">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-history text-purple-600 mr-2"></i>
                        Timeline
                    </h4>
                    
                    <div class="space-y-4">
                        @if($assignment->assigned_at)
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mt-1">
                                    <i class="fas fa-plus text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Assignment Created</p>
                                    <p class="text-xs text-gray-600">{{ $assignment->assigned_at->format('M d, Y g:i A') }}</p>
                                    <p class="text-xs text-gray-500">{{ $assignment->assigned_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endif

                        @if($assignment->status === 'in_progress')
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mt-1">
                                    <i class="fas fa-play text-orange-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">In Progress</p>
                                    <p class="text-xs text-gray-600">Currently being processed</p>
                                </div>
                            </div>
                        @endif

                        @if($assignment->completed_at)
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Completed</p>
                                    <p class="text-xs text-gray-600">{{ $assignment->completed_at->format('M d, Y g:i A') }}</p>
                                    <p class="text-xs text-gray-500">{{ $assignment->completed_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div id="updateStatusModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Update Assignment Status</h3>
                    <button onclick="closeUpdateStatusModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="updateStatusForm" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="statusSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Results (Optional)</label>
                            <textarea name="results" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Enter test results..."></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                            <textarea name="notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Additional notes..."></textarea>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3 mt-6">
                        <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Update Status
                        </button>
                        <button type="button" onclick="closeUpdateStatusModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openUpdateStatusModal(assignmentId, currentStatus) {
    const modal = document.getElementById('updateStatusModal');
    const form = document.getElementById('updateStatusForm');
    const statusSelect = document.getElementById('statusSelect');
    
    form.action = `/admin/test-assignments/${assignmentId}/update-status`;
    statusSelect.value = currentStatus;
    modal.classList.remove('hidden');
}

function closeUpdateStatusModal() {
    document.getElementById('updateStatusModal').classList.add('hidden');
}

function markInProgress(assignmentId) {
    updateAssignmentStatus(assignmentId, 'in_progress');
}

function markCompleted(assignmentId) {
    updateAssignmentStatus(assignmentId, 'completed');
}

function updateAssignmentStatus(assignmentId, status) {
    fetch(`/admin/test-assignments/${assignmentId}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the status.');
    });
}

// Close modal when clicking outside
document.getElementById('updateStatusModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUpdateStatusModal();
    }
});
</script>
@endsection
