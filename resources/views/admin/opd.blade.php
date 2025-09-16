@extends('layouts.admin')

@section('title', 'OPD - RSS Citi Health Services')
@section('page-title', 'OPD')

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
            <h5 class="card-title mb-0">OPD Entries</h5>
            <small class="text-muted">Filter by status and send results</small>
        </div>
    </div>

    <div class="card-body border-bottom">
        <ul class="nav nav-tabs" role="tablist">
            @php $statuses = ['pending' => 'Pending', 'approved' => 'Approved OPD', 'declined' => 'Declined OPD', 'opd' => 'OPD', 'done' => 'Done']; @endphp
            @foreach($statuses as $key => $label)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ ($filter ?? 'pending') === $key ? 'active' : '' }}" href="{{ route('admin.opd', ['filter' => $key]) }}">{{ $label }}</a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Medical Test</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entries as $entry)
                    <tr>
                        <td>{{ $entry->id }}</td>
                        <td>{{ $entry->customer_name }}</td>
                        <td>{{ $entry->customer_email }}</td>
                        <td>{{ $entry->medical_test }}</td>
                        <td>{{ $entry->appointment_date }}</td>
                        <td>{{ $entry->appointment_time }}</td>
                        <td>₱{{ number_format((float)($entry->price ?? 0), 2) }}</td>
                        <td>
                            <span class="badge {{ $entry->status === 'approved' ? 'bg-success' : ($entry->status === 'declined' ? 'bg-danger' : ($entry->status === 'done' ? 'bg-primary' : 'bg-secondary')) }}">
                                {{ ucfirst($entry->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                @if($entry->status !== 'approved')
                                <form action="{{ route('admin.opd.approve', $entry->id) }}" method="POST" onsubmit="return confirm('Approve this OPD entry?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-check2-circle"></i></button>
                                </form>
                                @endif
                                @if($entry->status !== 'declined')
                                <form class="ms-1" action="{{ route('admin.opd.decline', $entry->id) }}" method="POST" onsubmit="return confirm('Decline this OPD entry?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-octagon"></i></button>
                                </form>
                                @endif
                                <form class="ms-1" action="{{ route('admin.opd.mark-done', $entry->id) }}" method="POST" onsubmit="return confirm('Mark as done?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary"><i class="bi bi-check-all"></i></button>
                                </form>
                                @if($entry->status === 'done')
                                <form class="ms-1" action="{{ route('admin.opd.send-results', $entry->id) }}" method="POST" onsubmit="return confirm('Send results to {{ $entry->customer_email }}?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="bi bi-envelope me-1"></i> Send Results
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">No OPD entries found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($entries, 'links'))
        <div class="mt-3">{{ $entries->links() }}</div>
        @endif
    </div>
</div>
@endsection



