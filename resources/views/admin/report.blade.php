@extends('layouts.admin')

@section('title', 'Admin Report')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Pre-Employment Examinations</h2>
    <div class="table-responsive mb-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>User ID</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($preEmploymentExams as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->name ?? 'N/A' }}</td>
                        <td>{{ $exam->company_name ?? ($exam->user->company ?? 'N/A') }}</td>
                        <td>{{ $exam->user_id ?? 'N/A' }}</td>
                        <td>{{ $exam->status ?? 'N/A' }}</td>
                        <td>{{ $exam->date ? $exam->date->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No pre-employment examinations found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h2 class="mb-4">Annual Physical Examinations</h2>
    <div class="table-responsive mb-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>User ID</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($annualPhysicalExams as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->name ?? 'N/A' }}</td>
                        <td>{{ $exam->user_id ?? 'N/A' }}</td>
                        <td>{{ $exam->status ?? 'N/A' }}</td>
                        <td>{{ $exam->date ? $exam->date->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No annual physical examinations found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h2 class="mb-4">Patients and Their Company Accounts</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Appointment ID</th>
                    <th>Company User ID</th>
                    <th>Company Name</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td>{{ $patient->full_name ?? ($patient->fname . ' ' . $patient->lname) }}</td>
                        <td>{{ $patient->appointment_id ?? 'N/A' }}</td>
                        <td>{{ $patient->appointment && $patient->appointment->creator ? $patient->appointment->creator->id : 'N/A' }}</td>
                        <td>{{ $patient->appointment && $patient->appointment->creator ? $patient->appointment->creator->company : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No patients found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
