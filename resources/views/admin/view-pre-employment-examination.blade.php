@extends('layouts.admin')

@section('title', 'View Pre-Employment Examination - RSS Citi Health Services')
@section('page-title', 'Pre-Employment Examination Details')

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
                            <strong>Company:</strong> {{ $examination->company_name }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Date:</strong> {{ $examination->date }}
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong> 
                            <span class="badge badge-{{ $examination->status === 'completed' ? 'success' : 'warning' }}">
                                {{ $examination->status }}
                            </span>
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

                    <h6>Findings</h6>
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
                    
                    <div class="mb-3">
                        <strong>Company:</strong> {{ $examination->company_name }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Examination Date:</strong> {{ $examination->date }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Status:</strong> {{ $examination->status }}
                    </div>
                    
                    <hr>
                    
                    <form action="{{ route('admin.send-pre-employment-examination', $examination->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to send this examination to {{ $examination->company_name }}?')">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-paper-plane"></i> Send to {{ $examination->company_name }}
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
