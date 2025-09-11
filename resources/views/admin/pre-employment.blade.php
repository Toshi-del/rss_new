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
    
    <!-- Filter Tabs -->
    <div class="card-body border-bottom">
        <ul class="nav nav-tabs" id="filterTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $filter === 'pending' ? 'active' : '' }}" 
                   href="{{ route('admin.pre-employment', ['filter' => 'pending']) }}" 
                   role="tab">
                    Pending
                    <span class="badge bg-warning ms-1">{{ \App\Models\PreEmploymentRecord::where('status', 'pending')->count() }}</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $filter === 'approved' ? 'active' : '' }}" 
                   href="{{ route('admin.pre-employment', ['filter' => 'approved']) }}" 
                   role="tab">
                    Approved
                    <span class="badge bg-success ms-1">{{ \App\Models\PreEmploymentRecord::where('status', 'Approved')->where('registration_link_sent', false)->count() }}</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $filter === 'declined' ? 'active' : '' }}" 
                   href="{{ route('admin.pre-employment', ['filter' => 'declined']) }}" 
                   role="tab">
                    Declined
                    <span class="badge bg-danger ms-1">{{ \App\Models\PreEmploymentRecord::where('status', 'Declined')->count() }}</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $filter === 'approved_with_link' ? 'active' : '' }}" 
                   href="{{ route('admin.pre-employment', ['filter' => 'approved_with_link']) }}" 
                   role="tab">
                    Approved (Link Sent)
                    <span class="badge bg-info ms-1">{{ \App\Models\PreEmploymentRecord::where('status', 'Approved')->where('registration_link_sent', true)->count() }}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        @if($filter === 'approved')
            <div class="mb-3">
                <form action="{{ route('admin.pre-employment.send-all-emails') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-envelope-fill me-2"></i> Send Registration link To all approved records
                    </button>
                </form>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table" id="preEmploymentTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Medical Examination</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Registration Link</th>
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
                                @if($preEmployment->medicalTestCategory)
                                    {{ $preEmployment->medicalTestCategory->name }}
                                    @if($preEmployment->medicalTest)
                                        - {{ $preEmployment->medicalTest->name }}
                                    @endif
                                @else
                                    {{ $preEmployment->medical_exam_type ?? 'N/A' }}
                                @endif
                            </td>
                            <td>
                                ₱{{ number_format((float)($preEmployment->total_price ?? 0), 2) }}
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
                                @if($preEmployment->registration_link_sent)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle-fill me-1"></i>Sent
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-x-circle-fill me-1"></i>Not Sent
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Actions">
                                    @if($preEmployment->status !== 'Approved')
                                        <form action="{{ route('admin.pre-employment.approve', $preEmployment->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this record?')" title="Approve">
                                                <i class="bi bi-check2-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($preEmployment->status !== 'Declined')
                                        <form action="{{ route('admin.pre-employment.decline', $preEmployment->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Decline this record?')" title="Decline">
                                                <i class="bi bi-x-octagon"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($preEmployment->status === 'Approved' && !$preEmployment->registration_link_sent)
                                        <form action="{{ route('admin.pre-employment.send-email', $preEmployment->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary" onclick="return confirm('Send registration email to {{ $preEmployment->email ?? 'this candidate' }}?')" title="Send Registration Email">
                                                <i class="bi bi-envelope-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
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

