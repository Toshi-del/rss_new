@extends('layouts.admin')

@section('title', 'Admin Dashboard - RSS Citi Health Services')

@section('page-title', 'Dashboard')

@section('content')
<style>
    html { scroll-behavior: auto !important; }
    body { overflow-x: hidden; }
    .stats-card { min-height: 80px; max-height: 100px; }
    .stats-number { font-size: 1.5rem; }
    .stats-label { font-size: 0.875rem; }
    .card-body canvas { max-height: 120px !important; }
    .container-fluid { max-width: 100%; overflow-x: hidden; }
</style>
<!-- Stats row -->
<div class="row g-3">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon primary">
                <i class="bi bi-people"></i>
            </div>
            <div class="stats-info">
                <div class="stats-label">Total Patients</div>
                <div class="stats-number">
                    {{ $totalPatients }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon success">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stats-info">
                <div class="stats-label">Approved Appointments</div>
                <div class="stats-number">
                    {{ $approvedAppointments }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon warning">
                <i class="bi bi-clipboard2-pulse"></i>
            </div>
            <div class="stats-info">
                <div class="stats-label">Tests Today</div>
                <div class="stats-number">
                    {{ $testsToday }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon info">
                <i class="bi bi-file-earmark-medical"></i>
            </div>
            <div class="stats-info">
                <div class="stats-label">Pre-Employment Records</div>
                <div class="stats-number">
                    {{ $totalPreEmployment }}
                </div>
            </div>
        </div>
    </div>
</div>

@php
    // Build Top Categories (Last 90 Days) for dashboard
    $dashboardSince = \Carbon\Carbon::now()->subDays(90);
    $dashboardCategoryData = \App\Models\MedicalTestCategory::select('id','name')
        ->get()
        ->map(function ($cat) use ($dashboardSince) {
            $per = \App\Models\PreEmploymentRecord::where('medical_test_categories_id', $cat->id)
                ->where('created_at', '>=', $dashboardSince)
                ->count();
            $appt = \App\Models\Appointment::where('medical_test_categories_id', $cat->id)
                ->where('created_at', '>=', $dashboardSince)
                ->count();
            return [ 'name' => $cat->name, 'count' => $per + $appt ];
        })
        ->sortByDesc('count')
        ->take(6)
        ->values();
@endphp

<!-- Top Categories (Last 90 Days) -->
<div class="row g-3 mt-3">
    <div class="col-12 col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Top Categories (Last 90 Days)</h5>
            </div>
            <div class="card-body" style="height: 180px; overflow: hidden;">
                <canvas id="dashTopCategoriesChart" height="110" tabindex="-1"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <!-- empty placeholder to keep grid balanced; add more widgets here later -->
    </div>
    
</div>


<!-- Scheduled Appointments -->
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recent Annual Physical Examinations</h5>
        <a href="{{ route('admin.appointments') }}" class="btn btn-sm btn-outline-primary">View All</a>
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
                        <th>Exam</th>
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
                                {{ Carbon\Carbon::parse($patient->appointment->appointment_date)->format('M d, Y') }}
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No recent patients with appointments found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pre-Employment Tests -->
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recent Pre-Employment Tests</h5>
        <a href="{{ route('admin.pre-employment') }}" class="btn btn-sm btn-outline-info">View All</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="preEmploymentTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Medical Exam</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($preEmployments as $preEmployment)
                        <tr>
                            <td>{{ $preEmployment->id }}</td>
                            <td>{{ $preEmployment->full_name }}</td>
                            <td>{{ $preEmployment->email }}</td>
                            <td>
                                {{ optional($preEmployment->medicalTestCategory)->name }}
                                @if($preEmployment->medicalTest)
                                    - {{ $preEmployment->medicalTest->name }}
                                @endif
                            </td>
                            <td>₱{{ number_format($preEmployment->total_price ?? 0, 2) }}</td>
                            <td>
                                @php
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    $status = $preEmployment->status ?? 'pending';
                                    if ($status === 'passed') {
                                        $statusClass = 'bg-green-100 text-green-800';
                                    } elseif ($status === 'failed') {
                                        $statusClass = 'bg-red-100 text-red-800';
                                    } elseif ($status === 'pending') {
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                    }
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No recent pre-employment tests found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    (function(){
        const labels = @json($dashboardCategoryData->pluck('name'));
        const counts = @json($dashboardCategoryData->pluck('count'));
        const primary = getComputedStyle(document.documentElement).getPropertyValue('--bs-primary') || '#0d6efd';
        const success = getComputedStyle(document.documentElement).getPropertyValue('--bs-success') || '#198754';
        const warning = getComputedStyle(document.documentElement).getPropertyValue('--bs-warning') || '#ffc107';
        new Chart(document.getElementById('dashTopCategoriesChart'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Count',
                    data: counts,
                    backgroundColor: [primary.trim(), success.trim(), warning.trim(), '#6f42c1', '#20c997', '#fd7e14']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    })();
</script>
@endpush