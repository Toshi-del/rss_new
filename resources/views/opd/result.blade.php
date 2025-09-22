@extends('layouts.opd')

@section('opd-content')
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-4">
  <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex items-start justify-between">
    <div>
      <h2 class="text-base font-semibold text-gray-900 m-0">Examination Result</h2>
      <p class="text-xs text-gray-500">Preview</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('opd.dashboard') }}" class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 hover:bg-gray-50 transition">
        <i class="fa-solid fa-arrow-left mr-2"></i> Back
      </a>
      <button type="button" class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700 transition" onclick="window.print()">
        <i class="fa-solid fa-print mr-2"></i> Print
      </button>
    </div>
  </div>
  <div class="p-0">
    <!-- Header strip -->
    <div class="px-4 sm:px-6 py-3 border-b border-gray-200 bg-blue-50 flex items-start justify-between">
      <div>
        <div class="font-semibold text-gray-900">{{ $patientName ?? 'Patient Name' }}</div>
        <div class="text-xs text-gray-600">Patient ID: {{ $patientId ?? '—' }}</div>
      </div>
      <div class="text-right">
        <div class="text-xs text-gray-600">Examination Date</div>
        <div class="font-semibold text-gray-900">{{ $examDate ?? now()->format('M d, Y') }}</div>
      </div>
    </div>

    <div class="p-4 sm:p-6">
      @php
        $hasHistory = !empty($illness_history ?? null) || !empty($accidents_operations ?? null) || !empty($past_medical_history ?? null);
        $hasPhysicalSummary = !empty($visual ?? null) || !empty($ishihara_test ?? null) || !empty($skin_marks ?? null);
      @endphp

      @if($hasHistory || $hasPhysicalSummary)
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @if($hasHistory)
        <!-- Medical History -->
        <div>
          <div class="border border-gray-200 rounded-xl overflow-hidden h-full">
            <div class="px-4 py-3 border-b border-gray-200 bg-white"><strong class="text-gray-900">Medical History</strong></div>
            <div class="p-4">
              @if(!empty($illness_history))
              <div class="mb-3">
                <div class="text-xs text-gray-500">Illness History</div>
                <div class="text-sm text-gray-900">{{ $illness_history }}</div>
              </div>
              @endif
              @if(!empty($accidents_operations))
              <div class="mb-3">
                <div class="text-xs text-gray-500">Accidents/Operations</div>
                <div class="text-sm text-gray-900">{{ $accidents_operations }}</div>
              </div>
              @endif
              @if(!empty($past_medical_history))
              <div>
                <div class="text-xs text-gray-500">Past Medical History</div>
                <div class="text-sm text-gray-900">{{ $past_medical_history }}</div>
              </div>
              @endif
            </div>
          </div>
        </div>
        @endif

        @if($hasPhysicalSummary)
        <!-- Physical Examination -->
        <div>
          <div class="border border-gray-200 rounded-xl overflow-hidden h-full">
            <div class="px-4 py-3 border-b border-gray-200 bg-white"><strong class="text-gray-900">Physical Examination</strong></div>
            <div class="p-4">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @if(!empty($visual))
                <div>
                  <div class="text-xs text-gray-500">Visual Acuity</div>
                  <div class="text-sm text-gray-900">{{ $visual }}</div>
                </div>
                @endif
                @if(!empty($ishihara_test))
                <div>
                  <div class="text-xs text-gray-500">Ishihara Test</div>
                  <div class="text-sm text-gray-900">{{ $ishihara_test }}</div>
                </div>
                @endif
                @if(!empty($skin_marks))
                <div>
                  <div class="text-xs text-gray-500">Skin Marks</div>
                  <div class="text-sm text-gray-900">{{ $skin_marks }}</div>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
      @endif

      <!-- Laboratory Results + Final Findings -->
      @php
        $hasLabResults = !empty($ecg ?? null);
        $hasFinalFindings = !empty($final_findings ?? null);
      @endphp
      @if($hasLabResults || $hasFinalFindings)
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-2">
        @if($hasLabResults)
        <div>
          <div class="border border-gray-200 rounded-xl overflow-hidden h-full">
            <div class="px-4 py-3 border-b border-gray-200 bg-white"><strong class="text-gray-900">Laboratory Results</strong></div>
            <div class="p-4">
              @if(!empty($ecg))
              <div class="mb-2 flex items-center justify-between">
                <div class="text-sm text-gray-900">ECG</div>
                <span class="text-xs text-gray-600">{{ $ecg }}</span>
              </div>
              @endif
            </div>
          </div>
        </div>
        @endif
        @if($hasFinalFindings)
        <div>
          <div class="border border-gray-200 rounded-xl overflow-hidden h-full">
            <div class="px-4 py-3 border-b border-gray-200 bg-white"><strong class="text-gray-900">Final Findings</strong></div>
            <div class="p-4">
              <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-900">{{ $final_findings }}</div>
            </div>
          </div>
        </div>
        @endif
      </div>
      @endif

      <!-- Physical Findings Grid -->
      @if(!empty($physical_findings ?? []))
      <div class="border border-gray-200 rounded-xl overflow-hidden mt-3">
        <div class="px-4 py-3 border-b border-gray-200 bg-white"><strong class="text-gray-900">Physical Findings</strong></div>
        <div class="p-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach(($physical_findings ?? []) as $area => $finding)
            <div>
              <div class="border border-gray-200 rounded-lg p-3 h-full">
                <div class="flex items-center justify-between mb-1">
                  <div class="font-semibold text-sm text-gray-900">{{ $area }}</div>
                  @php $ok = ($finding['result'] ?? '') === 'Normal'; @endphp
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $ok ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ $finding['result'] ?? '—' }}</span>
                </div>
                @if(!empty($finding['findings']))
                  <div class="text-xs text-gray-500">{{ $finding['findings'] }}</div>
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
      <div class="border border-gray-200 rounded-xl overflow-hidden mt-3">
        <div class="px-4 py-3 border-b border-gray-200 bg-white"><strong class="text-gray-900">Laboratory Findings</strong></div>
        <div class="p-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach(($lab_findings ?? []) as $test => $result)
            <div>
              <div class="border border-gray-200 rounded-lg p-3 h-full">
                <div class="flex items-center justify-between mb-1">
                  <div class="font-semibold text-sm text-gray-900">{{ $test }}</div>
                  @php $ok2 = ($result['result'] ?? '') === 'Normal'; @endphp
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $ok2 ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ $result['result'] ?? '—' }}</span>
                </div>
                @if(!empty($result['findings']))
                  <div class="text-xs text-gray-500">{{ $result['findings'] }}</div>
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






