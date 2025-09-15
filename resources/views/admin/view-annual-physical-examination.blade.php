@extends('layouts.admin')

@section('title', 'View Annual Physical Examination - RSS Citi Health Services')
@section('page-title', 'Annual Physical Examination')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Patient & Exam Summary</h5>
                        <small class="text-muted">Comprehensive details of the annual physical</small>
                    </div>
                    <span class="badge badge-{{ $examination->status === 'sent_to_company' ? 'primary' : ($examination->status === 'completed' ? 'success' : 'warning') }}">
                        {{ ucfirst($examination->status ?? 'pending') }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-2"><strong>Name:</strong> {{ $examination->name }}</div>
                            <div class="mb-2"><strong>Patient ID:</strong> {{ $examination->patient_id }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2"><strong>Date:</strong> {{ $examination->date }}</div>
                            <div class="mb-2"><strong>ECG:</strong> {{ $examination->ecg ?? 'Not performed' }}</div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Medical History</h6>
                    <div class="row mb-3">
                        <div class="col-12"><strong>Illness/Hospitalization:</strong> {{ $examination->illness_history ?? 'Not specified' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12"><strong>Accidents/Operations:</strong> {{ $examination->accidents_operations ?? 'None reported' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12"><strong>Past Medical History:</strong> {{ $examination->past_medical_history ?? 'No major medical issues' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <h6 class="mb-2">Family History</h6>
                            @if($examination->family_history)
                                @foreach($examination->family_history as $condition)
                                    <span class="badge badge-info mr-1">{{ $condition }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No family history recorded</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="mb-2">Personal Habits</h6>
                            @if($examination->personal_habits)
                                @foreach($examination->personal_habits as $habit)
                                    <span class="badge badge-secondary mr-1">{{ $habit }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No personal habits recorded</span>
                            @endif
                        </div>
                    </div>

                    <h6 class="mb-2">Physical Examination</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Area</th>
                                    <th scope="col">Result</th>
                                    <th scope="col">Findings</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $phys = $examination->physical_findings ?? []; @endphp
                                @forelse($phys as $area => $row)
                                    <tr>
                                        <td class="text-nowrap">{{ $area }}</td>
                                        <td>{{ data_get($row, 'result', '—') }}</td>
                                        <td>{{ data_get($row, 'findings', '—') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No physical findings recorded</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @php
                        // Build lab rows from structured lab_findings when available; otherwise derive from lab_report
                        $labRows = [];
                        if (!empty($examination->lab_findings)) {
                            foreach ($examination->lab_findings as $test => $row) {
                                $labRows[] = [
                                    'test' => $test,
                                    'result' => $row['result'] ?? '',
                                    'findings' => $row['findings'] ?? ''
                                ];
                            }
                        } elseif (!empty($examination->lab_report)) {
                            foreach ($examination->lab_report as $key => $val) {
                                if (str_ends_with($key, '_findings')) continue;
                                $findKey = $key . '_findings';
                                $label = \Illuminate\Support\Str::title(str_replace('_', ' ', $key));
                                $labRows[] = [
                                    'test' => $label,
                                    'result' => $val ?? '',
                                    'findings' => $examination->lab_report[$findKey] ?? ''
                                ];
                            }
                        }
                    @endphp

                    <h6 class="mb-2">Laboratory Results</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Test</th>
                                    <th scope="col">Result</th>
                                    <th scope="col">Findings</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($labRows as $row)
                                    <tr>
                                        <td class="text-nowrap">{{ $row['test'] }}</td>
                                        <td>{{ $row['result'] !== '' ? $row['result'] : '—' }}</td>
                                        <td>{{ $row['findings'] !== '' ? $row['findings'] : '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No laboratory results recorded</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h6 class="mt-4 mb-2">Final Findings</h6>
                    <div class="alert alert-info mb-0">{{ $examination->findings ?? 'No findings recorded' }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    @php
                        $patient = \App\Models\Patient::find($examination->patient_id);
                        $appointment = $patient ? \App\Models\Appointment::find($patient->appointment_id) : null;
                        $companyName = $appointment ? \App\Models\User::find($appointment->created_by)->company : 'Unknown Company';
                    @endphp

                    <div class="mb-2"><strong>Company:</strong> {{ $companyName }}</div>
                    <div class="mb-2"><strong>Status:</strong> {{ ucfirst($examination->status ?? 'pending') }}</div>
                    <div class="mb-3"><strong>Exam Date:</strong> {{ $examination->date }}</div>

                    <form action="{{ route('admin.send-annual-physical-examination', $examination->id) }}" method="POST" onsubmit="return confirm('Send this examination to {{ $companyName }}?')">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-paper-plane"></i> Send to {{ $companyName }}
                        </button>
                    </form>

                    <a href="{{ route('admin.tests') }}" class="btn btn-light border btn-block mt-2">
                        <i class="fas fa-arrow-left"></i> Back to Tests
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
