@extends('layouts.admin')

@section('title', 'Pre-Employment - RSS Citi Health Services')
@section('page-title', 'Pre-Employment')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title mb-0">Pre-Employment Tests</h5>
            <small class="text-muted">Click the envelope button (📧) to send registration emails to passed candidates</small>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="preEmploymentTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Medical Examination</th>
                        <th>Blood Chemistry</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($preEmployments as $preEmployment)
                        <tr>
                            <td>{{ $preEmployment->id }}</td>
                            <td>{{ $preEmployment->full_name ?? ($preEmployment->first_name . ' ' . $preEmployment->last_name) }}</td>
                            <td>{{ $preEmployment->email ?? 'N/A' }}</td>
                            <td>
                                @if(is_array($preEmployment->medical_exam_type))
                                    {{ implode(', ', $preEmployment->medical_exam_type) }}
                                @else
                                    {{ $preEmployment->medical_exam_type ?? 'N/A' }}
                                @endif
                            </td>
                            <td>
                                @if(is_array($preEmployment->blood_tests))
                                    {{ implode(', ', $preEmployment->blood_tests) }}
                                @else
                                    {{ $preEmployment->blood_tests ?? 'N/A' }}
                                @endif
                            </td>
                            <td>
                                @php
                                    $status = $preEmployment->status ?? 'pending';
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    if ($status === 'passed') {
                                        $statusClass = 'bg-green-100 text-green-800';
                                    } elseif ($status === 'failed') {
                                        $statusClass = 'bg-red-100 text-red-800';
                                    } elseif ($status === 'pending') {
                                        $statusClass = 'bg-orange-100 text-orange-800';
                                    }
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Actions">
                                    <form action="{{ route('admin.pre-employment.approve', $preEmployment->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" 
                                                onclick="return confirm('Approve this record?')"
                                                title="Approve Record"
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.pre-employment.decline', $preEmployment->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Decline this record?')"
                                                title="Decline Record"
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                    @if($preEmployment->status === 'passed')
                                        <form action="{{ route('admin.pre-employment.send-email', $preEmployment->id) }}" method="POST" style="display:inline-block;" class="send-email-form" data-email="{{ $preEmployment->email }}" data-name="{{ $preEmployment->full_name ?? ($preEmployment->first_name . ' ' . $preEmployment->last_name) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary send-email-btn" 
                                                    title="Send Registration Email to {{ $preEmployment->email }}"
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top">
                                                <i class="bi bi-envelope-fill me-1"></i>
                                                <span class="btn-text">Email</span>
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No pre-employment records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($preEmployments, 'links'))
            <div class="mt-3">
                {{ $preEmployments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Handle email form submissions
    document.querySelectorAll('.send-email-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.dataset.email;
            const name = this.dataset.name;
            const button = this.querySelector('.send-email-btn');
            const buttonText = button.querySelector('.btn-text');
            const spinner = button.querySelector('.spinner-border');
            const icon = button.querySelector('i');
            
            // Show confirmation dialog
            if (!confirm(`Send registration email to ${name} (${email})?`)) {
                return;
            }
            
            // Show loading state
            button.disabled = true;
            buttonText.textContent = 'Sending...';
            spinner.classList.remove('d-none');
            icon.classList.add('d-none');
            
            // Submit the form
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success state
                    buttonText.textContent = 'Sent!';
                    button.classList.remove('btn-outline-primary');
                    button.classList.add('btn-success');
                    icon.classList.remove('bi-envelope-fill');
                    icon.classList.add('bi-check-circle-fill');
                    
                    // Show success message
                    showAlert('Email sent successfully to ' + name, 'success');
                    
                    // Reset button after 3 seconds
                    setTimeout(() => {
                        resetButton(button, buttonText, spinner, icon);
                    }, 3000);
                } else {
                    throw new Error(data.message || 'Failed to send email');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Failed to send email: ' + error.message, 'error');
                resetButton(button, buttonText, spinner, icon);
            });
        });
    });
    
    function resetButton(button, buttonText, spinner, icon) {
        button.disabled = false;
        buttonText.textContent = 'Email';
        spinner.classList.add('d-none');
        icon.classList.remove('d-none');
        button.classList.remove('btn-success');
        button.classList.add('btn-outline-primary');
        icon.classList.remove('bi-check-circle-fill');
        icon.classList.add('bi-envelope-fill');
    }
    
    function showAlert(message, type) {
        const alertContainer = document.querySelector('.card');
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="${iconClass} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        alertContainer.insertAdjacentHTML('beforebegin', alertHtml);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert:last-of-type');
            if (alert) {
                const alertInstance = new bootstrap.Alert(alert);
                alertInstance.close();
            }
        }, 5000);
    }
});
</script>

<style>
.send-email-btn {
    min-width: 80px;
    transition: all 0.3s ease;
}

.send-email-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.send-email-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none !important;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn-sm {
    margin-right: 0;
}

.btn-group {
    gap: 2px;
}

.btn-group form {
    margin: 0;
}

/* Improve status badges */
.badge {
    font-size: 0.75em;
    padding: 0.375rem 0.75rem;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.775rem;
    }
    
    .send-email-btn .btn-text {
        display: none;
    }
    
    .send-email-btn {
        min-width: auto;
    }
}
</style>
@endpush

