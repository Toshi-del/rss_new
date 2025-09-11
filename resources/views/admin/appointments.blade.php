@extends('layouts.admin')

@section('title', 'Appointments - RSS Citi Health Services')
@section('page-title', 'Appointments')

@section('content')
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Appointments</h5>
        <div class="d-flex gap-2">
            <span class="badge bg-light text-muted d-none d-md-inline">Manage and review appointment requests</span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="appointmentsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Company Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                            <td>{{ $appointment->time_slot ?? 'N/A' }}</td>
                            <td>
                                @if($appointment->medicalTestCategory)
                                    {{ $appointment->medicalTestCategory->name }}
                                    @if($appointment->medicalTest)
                                        - {{ $appointment->medicalTest->name }}
                                    @endif
                                @else
                                    {{ $appointment->appointment_type ?? 'N/A' }}
                                @endif
                            </td>
                            <td>{{ $appointment->creator->email ?? 'N/A' }}</td>
                            <td>
                                @if($appointment->status === 'approved')
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Approved</span>
                                @elseif($appointment->status === 'declined')
                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Declined</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Actions">
                                    <form action="{{ route('admin.appointments.approve', $appointment->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm btn-success {{ $appointment->status === 'approved' ? 'disabled' : '' }}" 
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Approve appointment"
                                                onclick="return confirm('Approve this appointment?')">
                                            <i class="bi bi-check2-circle"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.appointments.decline', $appointment->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger {{ $appointment->status === 'declined' ? 'disabled' : '' }}" 
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Decline appointment"
                                                onclick="return confirm('Decline this appointment?')">
                                            <i class="bi bi-x-octagon"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No appointments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection