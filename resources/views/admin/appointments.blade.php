@extends('layouts.admin')

@section('title', 'Appointments - RSS Citi Health Services')
@section('page-title', 'Appointment Management')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-calendar-check text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Appointment Management</h3>
                        <p class="text-emerald-100 text-sm">Review and manage appointment requests from companies</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Filter Dropdown -->
                    <div class="relative">
                        <select class="glass-morphism px-4 py-2 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 border border-white/20">
                            <option value="all" class="text-gray-900">All Status</option>
                            <option value="pending" class="text-gray-900">Pending</option>
                            <option value="approved" class="text-gray-900">Approved</option>
                            <option value="declined" class="text-gray-900">Declined</option>
                        </select>
                    </div>
                    <!-- Search Bar -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-white/60 text-sm"></i>
                        </div>
                        <input type="text" 
                               class="glass-morphism pl-12 pr-4 py-2 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 w-72 text-sm border border-white/20" 
                               placeholder="Search appointments...">
                    </div>
                    <!-- Export Button -->
                    <button class="bg-white/10 hover:bg-white/20 text-white px-6 py-2 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 border border-white/20 backdrop-blur-sm">
                        <i class="fas fa-download text-sm"></i>
                        <span>Export</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full" id="appointmentsTable">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">ID</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Appointment Date</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Time Slot</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Examination Type</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Company Email</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Status</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-emerald-50 transition-all duration-200 border-l-4 border-transparent hover:border-emerald-400">
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-sm font-bold text-gray-700">
                                        {{ $appointment->id }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center space-x-2 bg-blue-50 px-3 py-2 rounded-lg border border-blue-200">
                                    <i class="fas fa-calendar text-blue-500 text-xs"></i>
                                    <span class="text-sm font-medium text-blue-700">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center space-x-2 bg-emerald-50 px-3 py-2 rounded-lg border border-emerald-200">
                                    <i class="fas fa-clock text-emerald-500 text-xs"></i>
                                    <span class="text-sm font-medium text-emerald-700">
                                        {{ $appointment->time_slot ?? 'TBD' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="bg-amber-50 px-3 py-2 rounded-lg border border-amber-200">
                                    <div class="text-sm font-medium text-amber-800">
                                        @if($appointment->medicalTestCategory)
                                            {{ $appointment->medicalTestCategory->name }}
                                            @if($appointment->medicalTest)
                                                <div class="text-xs text-amber-600 mt-1">
                                                    {{ $appointment->medicalTest->name }}
                                                </div>
                                            @endif
                                        @else
                                            {{ $appointment->appointment_type ?? 'General Checkup' }}
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-envelope text-gray-400 text-xs"></i>
                                    <span class="text-sm text-gray-700">{{ $appointment->creator->email ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                @if($appointment->status === 'approved')
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                        <i class="fas fa-check-circle mr-1.5 text-xs"></i>
                                        Approved
                                    </span>
                                @elseif($appointment->status === 'declined')
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                        <i class="fas fa-times-circle mr-1.5 text-xs"></i>
                                        Declined
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <i class="fas fa-clock mr-1.5 text-xs"></i>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="py-5 px-6">
                                <div class="flex items-center space-x-2">
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-1.5 {{ $appointment->status === 'approved' ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-green-100 hover:bg-green-200 text-green-700' }} rounded-lg text-xs font-medium transition-all duration-150 border {{ $appointment->status === 'approved' ? 'border-gray-200' : 'border-green-200' }}"
                                            {{ $appointment->status === 'approved' ? 'disabled' : 'onclick=openApproveModal(' . $appointment->id . ')' }}>
                                        <i class="fas fa-check mr-1"></i>
                                        Approve
                                    </button>
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-1.5 {{ $appointment->status === 'declined' ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-red-100 hover:bg-red-200 text-red-700' }} rounded-lg text-xs font-medium transition-all duration-150 border {{ $appointment->status === 'declined' ? 'border-gray-200' : 'border-red-200' }}"
                                            {{ $appointment->status === 'declined' ? 'disabled' : 'onclick=openDeclineModal(' . $appointment->id . ')' }}>
                                        <i class="fas fa-times mr-1"></i>
                                        Decline
                                    </button>
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-xs font-medium transition-all duration-150 border border-blue-200"
                                            onclick="openViewModal({{ $appointment->id }})">
                                        <i class="fas fa-eye mr-1"></i>
                                        View
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center border-2 border-dashed border-gray-300">
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="w-20 h-20 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-full flex items-center justify-center border-4 border-emerald-300">
                                        <i class="fas fa-calendar-check text-emerald-500 text-3xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 font-semibold text-lg">No appointments found</p>
                                        <p class="text-gray-500 text-sm mt-1">Appointments will appear here when companies submit requests</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-green-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check text-white text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Approve Appointment</h3>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-start space-x-4 mb-6">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Confirm Approval</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Are you sure you want to approve this appointment? This action will notify the company and confirm the appointment slot.
                    </p>
                </div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex items-center space-x-2 text-green-800">
                    <i class="fas fa-info-circle text-sm"></i>
                    <span class="text-sm font-medium">This action cannot be undone</span>
                </div>
            </div>
            <div class="flex items-center justify-end space-x-3">
                <button type="button" 
                        onclick="closeApproveModal()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Cancel
                </button>
                <button type="button" 
                        onclick="confirmApprove()" 
                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                    <i class="fas fa-check mr-2"></i>
                    Approve Appointment
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Decline Modal -->
<div id="declineModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-red-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times text-white text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Decline Appointment</h3>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-start space-x-4 mb-6">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Confirm Decline</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Are you sure you want to decline this appointment? The company will be notified of the rejection.
                    </p>
                </div>
            </div>
            <div class="mb-6">
                <label for="declineReason" class="block text-sm font-medium text-gray-700 mb-2">
                    Reason for declining (optional)
                </label>
                <textarea id="declineReason" 
                          rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                          placeholder="Provide a reason for declining this appointment..."></textarea>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-center space-x-2 text-red-800">
                    <i class="fas fa-exclamation-triangle text-sm"></i>
                    <span class="text-sm font-medium">This action cannot be undone</span>
                </div>
            </div>
            <div class="flex items-center justify-end space-x-3">
                <button type="button" 
                        onclick="closeDeclineModal()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Cancel
                </button>
                <button type="button" 
                        onclick="confirmDecline()" 
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                    <i class="fas fa-times mr-2"></i>
                    Decline Appointment
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 transform transition-all duration-300">
        <div class="bg-blue-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-eye text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Appointment Details</h3>
                </div>
                <button onclick="closeViewModal()" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div id="appointmentDetails" class="space-y-6">
                <!-- Appointment details will be loaded here -->
            </div>
            <div class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <button type="button" 
                        onclick="closeViewModal()" 
                        class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Forms for Actions -->
<form id="approveForm" action="" method="POST" style="display: none;">
    @csrf
</form>

<form id="declineForm" action="" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="reason" id="declineReasonInput">
</form>

<script>
let currentAppointmentId = null;

function openApproveModal(appointmentId) {
    currentAppointmentId = appointmentId;
    document.getElementById('approveModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentAppointmentId = null;
}

function confirmApprove() {
    if (currentAppointmentId) {
        const form = document.getElementById('approveForm');
        form.action = `/admin/appointments/${currentAppointmentId}/approve`;
        form.submit();
    }
}

function openDeclineModal(appointmentId) {
    currentAppointmentId = appointmentId;
    document.getElementById('declineModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeclineModal() {
    document.getElementById('declineModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentAppointmentId = null;
    document.getElementById('declineReason').value = '';
}

function confirmDecline() {
    if (currentAppointmentId) {
        const reason = document.getElementById('declineReason').value;
        document.getElementById('declineReasonInput').value = reason;
        
        const form = document.getElementById('declineForm');
        form.action = `/admin/appointments/${currentAppointmentId}/decline`;
        form.submit();
    }
}

function openViewModal(appointmentId) {
    // In a real implementation, you would fetch appointment details via AJAX
    // For now, we'll show a placeholder
    const appointmentDetails = document.getElementById('appointmentDetails');
    appointmentDetails.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h5 class="font-semibold text-gray-900 mb-2">Appointment Information</h5>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID:</span>
                            <span class="font-medium">#${appointmentId}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-medium">Loading...</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Time:</span>
                            <span class="font-medium">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h5 class="font-semibold text-gray-900 mb-2">Company Details</h5>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <div class="bg-amber-50 p-4 rounded-lg">
                    <h5 class="font-semibold text-gray-900 mb-2">Medical Examination</h5>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h5 class="font-semibold text-gray-900 mb-2">Status</h5>
                    <div class="space-y-2 text-sm">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i>
                            Loading...
                        </span>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('viewModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeViewModal() {
    document.getElementById('viewModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const modals = ['approveModal', 'declineModal', 'viewModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            if (modalId === 'declineModal') {
                document.getElementById('declineReason').value = '';
            }
            currentAppointmentId = null;
        }
    });
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = ['approveModal', 'declineModal', 'viewModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (!modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                if (modalId === 'declineModal') {
                    document.getElementById('declineReason').value = '';
                }
                currentAppointmentId = null;
            }
        });
    }
});
</script>
@endsection