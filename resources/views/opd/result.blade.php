@extends('layouts.opd')

@section('opd-content')
<div class="card border-0 shadow-sm mb-3">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <div>
      <h5 class="mb-0">Examination Result</h5>
      <small class="text-muted">Preview</small>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('opd.dashboard') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back
      </a>
      <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">
        <i class="fa-solid fa-print me-1"></i> Print
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <!-- Header strip -->
    <div class="px-3 py-3 border-bottom d-flex justify-content-between align-items-start bg-primary-subtle">
      <div>
        <div class="fw-semibold">{{ $patientName ?? 'Patient Name' }}</div>
        <div class="text-muted small">Patient ID: {{ $patientId ?? '—' }}</div>
      </div>
      <div class="text-end">
        <div class="text-muted small">Examination Date</div>
        <div class="fw-semibold">{{ $examDate ?? now()->format('M d, Y') }}</div>
      </div>
    </div>

    <div class="p-3">
      <div class="row g-3">
        <!-- Medical History -->
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white"><strong>Medical History</strong></div>
            <div class="card-body">
              <div class="mb-3">
                <div class="text-muted small">Illness History</div>
                <div>{{ $illness_history ?? 'Not specified' }}</div>
              </div>
              <div class="mb-3">
                <div class="text-muted small">Accidents/Operations</div>
                <div>{{ $accidents_operations ?? 'None reported' }}</div>
              </div>
              <div>
                <div class="text-muted small">Past Medical History</div>
                <div>{{ $past_medical_history ?? 'No major medical issues' }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Physical Examination -->
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white"><strong>Physical Examination</strong></div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-sm-6">
                  <div class="text-muted small">Visual Acuity</div>
                  <div>{{ $visual ?? 'Not tested' }}</div>
                </div>
                <div class="col-sm-6">
                  <div class="text-muted small">Ishihara Test</div>
                  <div>{{ $ishihara_test ?? 'Not tested' }}</div>
                </div>
                <div class="col-sm-6">
                  <div class="text-muted small">Skin Marks</div>
                  <div>{{ $skin_marks ?? 'None' }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Laboratory Results + Final Findings -->
      <div class="row g-3 mt-1">
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white"><strong>Laboratory Results</strong></div>
            <div class="card-body">
              <div class="mb-2 d-flex justify-content-between align-items-center">
                <div>ECG</div>
                <span class="text-muted small">{{ $ecg ?? 'Not performed' }}</span>
              </div>
              <!-- Add more lab rows as needed -->
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white"><strong>Final Findings</strong></div>
            <div class="card-body">
              <div class="bg-light rounded p-3">{{ $final_findings ?? 'No findings recorded' }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Physical Findings Grid -->
      @if(!empty($physical_findings ?? []))
      <div class="card border-0 shadow-sm mt-3">
        <div class="card-header bg-white"><strong>Physical Findings</strong></div>
        <div class="card-body">
          <div class="row g-3">
            @foreach(($physical_findings ?? []) as $area => $finding)
            <div class="col-md-6">
              <div class="border rounded p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <div class="fw-semibold">{{ $area }}</div>
                  <span class="badge {{ ($finding['result'] ?? '') === 'Normal' ? 'text-bg-success' : 'text-bg-warning' }}">{{ $finding['result'] ?? '—' }}</span>
                </div>
                @if(!empty($finding['findings']))
                  <div class="text-muted small">{{ $finding['findings'] }}</div>
                @endif
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
      @endif

      <!-- Laboratory Findings Grid -->
      @if(!empty($lab_findings ?? []))
      <div class="card border-0 shadow-sm mt-3">
        <div class="card-header bg-white"><strong>Laboratory Findings</strong></div>
        <div class="card-body">
          <div class="row g-3">
            @foreach(($lab_findings ?? []) as $test => $result)
            <div class="col-md-6">
              <div class="border rounded p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <div class="fw-semibold">{{ $test }}</div>
                  <span class="badge {{ ($result['result'] ?? '') === 'Normal' ? 'text-bg-success' : 'text-bg-warning' }}">{{ $result['result'] ?? '—' }}</span>
                </div>
                @if(!empty($result['findings']))
                  <div class="text-muted small">{{ $result['findings'] }}</div>
                @endif
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>

<style>
@media print {
  .navbar, .sidebar, .btn, .breadcrumb { display: none !important; }
}
</style>
@endsection


