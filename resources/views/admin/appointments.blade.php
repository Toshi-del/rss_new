@extends('layouts.admin')

@section('title', 'Appointments - RSS Citi Health Services')
@section('page-title', 'Appointments')

@section('content')
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Appointments</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="appointmentsTable">
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
                            <td>{{ $appointment->appointment_type ?? 'N/A' }}</td>
                            <td>{{ $appointment->creator->email ?? 'N/A' }}</td>
                            <td>
                                @if($appointment->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($appointment->status === 'declined')
                                    <span class="badge bg-danger">Declined</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            
                           
                            <td>
                                <form action="{{ route('admin.appointments.approve', $appointment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Approve this appointment?')">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.appointments.decline', $appointment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Decline this appointment?')">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
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