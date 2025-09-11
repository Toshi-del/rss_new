@extends('layouts.admin')

@section('title', 'Patients - RSS Citi Health Services')
@section('page-title', 'Patients')

@section('content')
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Annual Physical Examination Patients</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="patientsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>{{ $patient->id }}</td>
                            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                            <td>{{ $patient->company_name ?? 'N/A' }}</td>
                            <td>{{ $patient->email }}</td>
                            <td>
                                @if($patient->appointment)
                                    {{ \Carbon\Carbon::parse($patient->appointment->appointment_date)->format('M d, Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($patient->appointment)
                                    {{ $patient->appointment->time_slot ?? 'N/A' }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($patient->appointment)
                                    {{ $patient->appointment->appointment_type ?? 'N/A' }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($patient->appointment && $patient->appointment->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-info" disabled title="Not available yet">View Result</button>
                                <button class="btn btn-sm btn-outline-success" disabled title="Not available yet">Send Results</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                No patients found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection