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
        <div>
            <form action="{{ route('admin.fix-invalid-emails') }}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('This will attempt to fix records with invalid email addresses (like \"Male\" in email field). Continue?')" title="Fix Invalid Email Addresses">
                    <i class="bi bi-tools"></i> Fix Invalid Emails
                </button>
            </form>
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
                            <td>
                                @if(filter_var($preEmployment->email, FILTER_VALIDATE_EMAIL))
                                    {{ $preEmployment->email }}
                                @else
                                    <div class="d-flex align-items-center">
                                        <span class="text-danger me-2">{{ $preEmployment->email ?? 'N/A' }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editEmailModal{{ $preEmployment->id }}" title="Fix Invalid Email">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Edit Email Modal -->
                                    <div class="modal fade" id="editEmailModal{{ $preEmployment->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Fix Email Address</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.pre-employment.update-email', $preEmployment->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        <p><strong>Record:</strong> {{ $preEmployment->first_name }} {{ $preEmployment->last_name }}</p>
                                                        <p><strong>Current Email:</strong> <span class="text-danger">{{ $preEmployment->email ?? 'N/A' }}</span></p>
                                                        <p><strong>Phone Number:</strong> {{ $preEmployment->phone_number ?? 'N/A' }}</p>
                                                        <div class="mb-3">
                                                            <label for="email{{ $preEmployment->id }}" class="form-label">Correct Email Address:</label>
                                                            <input type="email" class="form-control" id="email{{ $preEmployment->id }}" name="email" required placeholder="Enter correct email address">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update Email</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
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
                                <form action="{{ route('admin.pre-employment.approve', $preEmployment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Approve this record?')">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.pre-employment.decline', $preEmployment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Decline this record?')">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                                @if($preEmployment->status === 'passed')
                                    <form action="{{ route('admin.pre-employment.send-email', $preEmployment->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary" onclick="return confirm('Send registration email to {{ $preEmployment->email }}?')" title="Send Email Registration">
                                            <i class="bi bi-envelope-fill"></i> Send Email
                                        </button>
                                    </form>
                                @endif
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

