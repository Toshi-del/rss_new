@extends('layouts.admin')

@section('title', 'Pre-Employment Details - RSS Citi Health Services')
@section('page-title', 'Pre-Employment Details')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-user-tie text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Pre-Employment Record Details</h3>
                        <p class="text-cyan-100 text-sm">Record ID: #{{ $preEmployment->id }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.pre-employment') }}" 
                       class="bg-white/10 hover:bg-white/20 text-white px-6 py-2 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 border border-white/20 backdrop-blur-sm">
                        <i class="fas fa-arrow-left text-sm"></i>
                        <span>Back to List</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Main Details -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Candidate Information -->
            <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-cyan-600 text-lg"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Candidate Information</h4>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-6 mb-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-2xl">
                                {{ substr($preEmployment->first_name ?? $preEmployment->full_name ?? 'N', 0, 1) }}{{ substr($preEmployment->last_name ?? 'A', 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $preEmployment->full_name }}
                            </h3>
                            <p class="text-gray-600">Pre-Employment Candidate</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-envelope text-gray-400"></i>
                                <div>
                                    <p class="text-sm text-gray-500">Email Address</p>
                                    <p class="font-medium text-gray-900">{{ $preEmployment->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-phone text-gray-400"></i>
                                <div>
                                    <p class="text-sm text-gray-500">Phone Number</p>
                                    <p class="font-medium text-gray-900">{{ $preEmployment->phone_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-calendar text-gray-400"></i>
                                <div>
                                    <p class="text-sm text-gray-500">Application Date</p>
                                    <p class="font-medium text-gray-900">{{ $preEmployment->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-building text-gray-400"></i>
                                <div>
                                    <p class="text-sm text-gray-500">Company</p>
                                    <p class="font-medium text-gray-900">{{ $preEmployment->company_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Examination Details -->
            <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
                <div class="bg-gradient-to-r from-amber-50 to-amber-100 px-6 py-4 border-b border-amber-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-stethoscope text-amber-600 text-lg"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Medical Examination</h4>
                    </div>
                </div>
                <div class="p-6">
                    @php
                        $allTests = $preEmployment->all_selected_tests;
                    @endphp
                    
                    @if($allTests && $allTests->count() > 0)
                        <div class="space-y-4">
                            @foreach($allTests as $test)
                                <div class="bg-amber-50 p-4 rounded-lg border border-amber-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h5 class="font-semibold text-amber-800">
                                                {{ $test['category_name'] }}
                                                @if($test['is_primary'])
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800 ml-2">
                                                        Primary
                                                    </span>
                                                @endif
                                            </h5>
                                            <p class="text-sm text-amber-600 mt-1">{{ $test['test_name'] }}</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center space-x-2 text-green-700">
                                                <i class="fas fa-peso-sign text-sm"></i>
                                                <span class="font-semibold">{{ number_format((float)($test['price'] ?? 0), 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200 mt-4">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-green-800">Total Price:</span>
                                    <div class="flex items-center space-x-2 text-green-700">
                                        <i class="fas fa-peso-sign"></i>
                                        <span class="text-lg font-bold">{{ number_format((float)($preEmployment->total_price ?? 0), 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-amber-50 p-4 rounded-lg border border-amber-200">
                            <div class="text-center py-4">
                                <i class="fas fa-stethoscope text-amber-400 text-3xl mb-2"></i>
                                <p class="text-amber-700 font-medium">No medical tests assigned</p>
                                <p class="text-amber-600 text-sm">Medical examination details will appear here once assigned</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Status & Actions -->
        <div class="space-y-8">
            <!-- Status Card -->
            <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-gray-600 text-lg"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Status Information</h4>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Application Status</p>
                        @php
                            $status = $preEmployment->status ?? 'Pending';
                        @endphp
                        @if($status === 'Approved')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                                <i class="fas fa-check-circle mr-2"></i>
                                Approved
                            </span>
                        @elseif($status === 'Declined')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800 border border-red-200">
                                <i class="fas fa-times-circle mr-2"></i>
                                Declined
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                <i class="fas fa-clock mr-2"></i>
                                Pending
                            </span>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Registration Link</p>
                        @if($preEmployment->registration_link_sent)
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                <i class="fas fa-check-circle mr-2"></i>
                                Sent
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-800 border border-gray-200">
                                <i class="fas fa-times-circle mr-2"></i>
                                Not Sent
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cogs text-blue-600 text-lg"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Actions</h4>
                    </div>
                </div>
                <div class="p-6 space-y-3">
                    @if($preEmployment->status !== 'Approved')
                        <button type="button" 
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg font-medium transition-all duration-150 border border-green-200"
                                onclick="openPreEmploymentApproveModal({{ $preEmployment->id }})">
                            <i class="fas fa-check mr-2"></i>
                            Approve Record
                        </button>
                    @endif
                    
                    @if($preEmployment->status !== 'Declined')
                        <button type="button" 
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-medium transition-all duration-150 border border-red-200"
                                onclick="openPreEmploymentDeclineModal({{ $preEmployment->id }})">
                            <i class="fas fa-times mr-2"></i>
                            Decline Record
                        </button>
                    @endif
                    
                    @if($preEmployment->status === 'Approved' && !$preEmployment->registration_link_sent)
                        <button type="button" 
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg font-medium transition-all duration-150 border border-blue-200"
                                onclick="openPreEmploymentSendEmailModal({{ $preEmployment->id }}, '{{ $preEmployment->email ?? 'this candidate' }}')">
                            <i class="fas fa-envelope mr-2"></i>
                            Send Registration Link
                        </button>
                    @endif
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-purple-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-purple-600 text-lg"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Timeline</h4>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-plus text-blue-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Application Submitted</p>
                                <p class="text-sm text-gray-500">{{ $preEmployment->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                        
                        @if($preEmployment->updated_at != $preEmployment->created_at)
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-edit text-yellow-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Last Updated</p>
                                    <p class="text-sm text-gray-500">{{ $preEmployment->updated_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include the same modals from the main page for actions -->
<!-- Pre-Employment Approve Modal -->
<div id="preEmploymentApproveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-green-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check text-white text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Approve Pre-Employment Record</h3>
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
                        Are you sure you want to approve this pre-employment record? This will allow the candidate to proceed with registration.
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
                        onclick="closePreEmploymentApproveModal()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Cancel
                </button>
                <button type="button" 
                        onclick="confirmPreEmploymentApprove()" 
                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                    <i class="fas fa-check mr-2"></i>
                    Approve Record
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Pre-Employment Decline Modal -->
<div id="preEmploymentDeclineModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-red-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times text-white text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Decline Pre-Employment Record</h3>
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
                        Are you sure you want to decline this pre-employment record? The candidate will be notified of the rejection.
                    </p>
                </div>
            </div>
            <div class="mb-6">
                <label for="preEmploymentDeclineReason" class="block text-sm font-medium text-gray-700 mb-2">
                    Reason for declining (optional)
                </label>
                <textarea id="preEmploymentDeclineReason" 
                          rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                          placeholder="Provide a reason for declining this record..."></textarea>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-center space-x-2 text-red-800">
                    <i class="fas fa-exclamation-triangle text-sm"></i>
                    <span class="text-sm font-medium">This action cannot be undone</span>
                </div>
            </div>
            <div class="flex items-center justify-end space-x-3">
                <button type="button" 
                        onclick="closePreEmploymentDeclineModal()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Cancel
                </button>
                <button type="button" 
                        onclick="confirmPreEmploymentDecline()" 
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                    <i class="fas fa-times mr-2"></i>
                    Decline Record
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Pre-Employment Send Email Modal -->
<div id="preEmploymentSendEmailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-blue-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-envelope text-white text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Send Registration Link</h3>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-start space-x-4 mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-envelope text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Send Registration Email</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Send registration link to <span id="candidateEmail" class="font-medium text-blue-600">{{ $preEmployment->email ?? 'this candidate' }}</span>? This will allow them to complete their registration process.
                    </p>
                </div>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-center space-x-2 text-blue-800">
                    <i class="fas fa-info-circle text-sm"></i>
                    <span class="text-sm font-medium">Email will be sent immediately</span>
                </div>
            </div>
            <div class="flex items-center justify-end space-x-3">
                <button type="button" 
                        onclick="closePreEmploymentSendEmailModal()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Cancel
                </button>
                <button type="button" 
                        onclick="confirmPreEmploymentSendEmail()" 
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                    <i class="fas fa-envelope mr-2"></i>
                    Send Email
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Forms for Actions -->
<form id="preEmploymentApproveForm" action="" method="POST" style="display: none;">
    @csrf
</form>

<form id="preEmploymentDeclineForm" action="" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="reason" id="preEmploymentDeclineReasonInput">
</form>

<form id="preEmploymentSendEmailForm" action="" method="POST" style="display: none;">
    @csrf
</form>

<script>
let currentPreEmploymentId = {{ $preEmployment->id }};

function openPreEmploymentApproveModal(preEmploymentId) {
    currentPreEmploymentId = preEmploymentId;
    document.getElementById('preEmploymentApproveModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePreEmploymentApproveModal() {
    document.getElementById('preEmploymentApproveModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function confirmPreEmploymentApprove() {
    if (currentPreEmploymentId) {
        const form = document.getElementById('preEmploymentApproveForm');
        form.action = `/admin/pre-employment/${currentPreEmploymentId}/approve`;
        form.submit();
    }
}

function openPreEmploymentDeclineModal(preEmploymentId) {
    currentPreEmploymentId = preEmploymentId;
    document.getElementById('preEmploymentDeclineModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePreEmploymentDeclineModal() {
    document.getElementById('preEmploymentDeclineModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('preEmploymentDeclineReason').value = '';
}

function confirmPreEmploymentDecline() {
    if (currentPreEmploymentId) {
        const reason = document.getElementById('preEmploymentDeclineReason').value;
        document.getElementById('preEmploymentDeclineReasonInput').value = reason;
        
        const form = document.getElementById('preEmploymentDeclineForm');
        form.action = `/admin/pre-employment/${currentPreEmploymentId}/decline`;
        form.submit();
    }
}

function openPreEmploymentSendEmailModal(preEmploymentId, email) {
    currentPreEmploymentId = preEmploymentId;
    document.getElementById('candidateEmail').textContent = email;
    document.getElementById('preEmploymentSendEmailModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePreEmploymentSendEmailModal() {
    document.getElementById('preEmploymentSendEmailModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function confirmPreEmploymentSendEmail() {
    if (currentPreEmploymentId) {
        const form = document.getElementById('preEmploymentSendEmailForm');
        form.action = `/admin/pre-employment/${currentPreEmploymentId}/send-email`;
        form.submit();
    }
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const modals = ['preEmploymentApproveModal', 'preEmploymentDeclineModal', 'preEmploymentSendEmailModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            if (modalId === 'preEmploymentDeclineModal') {
                document.getElementById('preEmploymentDeclineReason').value = '';
            }
        }
    });
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = ['preEmploymentApproveModal', 'preEmploymentDeclineModal', 'preEmploymentSendEmailModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (!modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                if (modalId === 'preEmploymentDeclineModal') {
                    document.getElementById('preEmploymentDeclineReason').value = '';
                }
            }
        });
    }
});
</script>
@endsection
