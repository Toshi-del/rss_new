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
        <div class="mb-3">
            <form action="{{ route('admin.pre-employment.send-all-emails') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-envelope-fill me-2"></i> Send Registration link To all passed/approved status
                </button>
            </form>
        </div>
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
                                    $status = $preEmployment->status ?? 'Pending';
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    if ($status === 'Approved') {
                                        $statusClass = 'bg-green-100 text-green-800';
                                    } elseif ($status === 'Declined') {
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
                                @if($preEmployment->status === 'Approved')
                                    <form action="{{ route('admin.pre-employment.send-email', $preEmployment->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary" onclick="return confirm('Send registration email to {{ $preEmployment->email ?? 'this candidate' }}?')" title="Send Registration Email">
                                            <i class="bi bi-envelope-fill"></i>
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

