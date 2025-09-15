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
            <table class="table table-hover align-middle" id="patientsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Exam</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>{{ $patient->id }}</td>
                            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                            <td>
                                @if($patient->appointment && $patient->appointment->creator)
                                    {{ $patient->appointment->creator->company ?? 'N/A' }}
                                @else
                                    N/A
                                @endif
                            </td>
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
                                    {{ optional($patient->appointment->medicalTestCategory)->name }}
                                    @if($patient->appointment->medicalTest)
                                        - {{ $patient->appointment->medicalTest->name }}
                                    @endif
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