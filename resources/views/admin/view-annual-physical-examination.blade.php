@extends('layouts.admin')

@section('title', 'View Annual Physical Examination - RSS Citi Health Services')
@section('page-title', 'Annual Physical Examination Details')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Examination Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Name:</strong> {{ $examination->name }}
                        </div>
                        <div class="col-md-6">
                            <strong>Date:</strong> {{ $examination->date }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Status:</strong> 
                            <span class="badge badge-{{ $examination->status === 'completed' ? 'success' : 'warning' }}">
                                {{ $examination->status }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <strong>Patient ID:</strong> {{ $examination->patient_id }}
                        </div>
                    </div>

                    <hr>

                    <h6>Medical History</h6>
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Illness History:</strong> {{ $examination->illness_history ?? 'Not specified' }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Accidents/Operations:</strong> {{ $examination->accidents_operations ?? 'None reported' }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Past Medical History:</strong> {{ $examination->past_medical_history ?? 'No major medical issues' }}
                        </div>
                    </div>

                    <h6>Family History</h6>
                    <div class="row mb-3">
                        <div class="col-12">
                            @if($examination->family_history)
                                @foreach($examination->family_history as $condition)
                                    <span class="badge badge-info mr-1">{{ $condition }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No family history recorded</span>
                            @endif
                        </div>
                    </div>

                    <h6>Personal Habits</h6>
                    <div class="row mb-3">
                        <div class="col-12">
                            @if($examination->personal_habits)
                                @foreach($examination->personal_habits as $habit)
                                    <span class="badge badge-secondary mr-1">{{ $habit }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No personal habits recorded</span>
                            @endif
                        </div>
                    </div>

                    <h6>Physical Examination</h6>
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Visual Acuity:</strong> {{ $examination->visual ?? 'Not tested' }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Ishihara Test:</strong> {{ $examination->ishihara_test ?? 'Not tested' }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Skin Marks:</strong> {{ $examination->skin_marks ?? 'None' }}
                        </div>
                    </div>

                    <h6>Laboratory Results</h6>
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>ECG:</strong> {{ $examination->ecg ?? 'Not performed' }}
                        </div>
                    </div>

                    <h6>Physical Findings</h6>
                    @if($examination->physical_findings)
                        @foreach($examination->physical_findings as $area => $finding)
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <strong>{{ $area }}:</strong>
                                </div>
                                <div class="col-md-8">
                                    <span class="badge badge-{{ $finding['result'] === 'Normal' ? 'success' : 'warning' }}">
                                        {{ $finding['result'] }}
                                    </span>
                                    @if(isset($finding['findings']))
                                        - {{ $finding['findings'] }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row mb-3">
                            <div class="col-12">
                                <span class="text-muted">No physical findings recorded</span>
                            </div>
                        </div>
                    @endif

                    <h6>Laboratory Findings</h6>
                    @if($examination->lab_findings)
                        @foreach($examination->lab_findings as $test => $result)
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <strong>{{ $test }}:</strong>
                                </div>
                                <div class="col-md-8">
                                    <span class="badge badge-{{ $result['result'] === 'Normal' ? 'success' : 'warning' }}">
                                        {{ $result['result'] }}
                                    </span>
                                    @if(isset($result['findings']))
                                        - {{ $result['findings'] }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row mb-3">
                            <div class="col-12">
                                <span class="text-muted">No laboratory findings recorded</span>
                            </div>
                        </div>
                    @endif

                    <h6>Final Findings</h6>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                {{ $examination->findings ?? 'No findings recorded' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Send to Company</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Review Before Sending</strong><br>
                        Please review all examination details above before sending to the company.
                    </div>
                    
                    @php
                        $patient = \App\Models\Patient::find($examination->patient_id);
                        $appointment = $patient ? \App\Models\Appointment::find($patient->appointment_id) : null;
                        $companyName = $appointment ? \App\Models\User::find($appointment->created_by)->company : 'Unknown Company';
                    @endphp
                    
                    <div class="mb-3">
                        <strong>Company:</strong> {{ $companyName }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Examination Date:</strong> {{ $examination->date }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Status:</strong> {{ $examination->status }}
                    </div>
                    
                    <hr>
                    
                    <form action="{{ route('admin.send-annual-physical-examination', $examination->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to send this examination to {{ $companyName }}?')">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-paper-plane"></i> Send to {{ $companyName }}
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.tests') }}" class="btn btn-secondary btn-block mt-2">
                        <i class="fas fa-arrow-left"></i> Back to Tests
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
