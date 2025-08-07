@extends('layouts.admin')

@section('title', 'Admin Dashboard - RSS Citi Health Services')

@section('page-title', 'Dashboard')

@section('content')
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

<!-- Appointment Statistics -->
<div class="row g-3 mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Appointment Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Weekly Statistics -->
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="text-primary mb-3">Weekly (Last 7 Days)</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-primary mb-1">{{ $appointmentStats['weekly']['total'] }}</div>
                                        <div class="small text-muted">Total</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-success mb-1">{{ $appointmentStats['weekly']['approved'] }}</div>
                                        <div class="small text-muted">Approved</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-warning mb-1">{{ $appointmentStats['weekly']['pending'] }}</div>
                                        <div class="small text-muted">Pending</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-danger mb-1">{{ $appointmentStats['weekly']['cancelled'] }}</div>
                                        <div class="small text-muted">Cancelled</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Monthly Statistics -->
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="text-primary mb-3">Monthly (Last 30 Days)</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-primary mb-1">{{ $appointmentStats['monthly']['total'] }}</div>
                                        <div class="small text-muted">Total</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-success mb-1">{{ $appointmentStats['monthly']['approved'] }}</div>
                                        <div class="small text-muted">Approved</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-warning mb-1">{{ $appointmentStats['monthly']['pending'] }}</div>
                                        <div class="small text-muted">Pending</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-danger mb-1">{{ $appointmentStats['monthly']['cancelled'] }}</div>
                                        <div class="small text-muted">Cancelled</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Yearly Statistics -->
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="text-primary mb-3">Yearly (Last 365 Days)</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-primary mb-1">{{ $appointmentStats['yearly']['total'] }}</div>
                                        <div class="small text-muted">Total</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-success mb-1">{{ $appointmentStats['yearly']['approved'] }}</div>
                                        <div class="small text-muted">Approved</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-warning mb-1">{{ $appointmentStats['yearly']['pending'] }}</div>
                                        <div class="small text-muted">Pending</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-danger mb-1">{{ $appointmentStats['yearly']['cancelled'] }}</div>
                                        <div class="small text-muted">Cancelled</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pre-Employment Statistics -->
<div class="row g-3 mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Pre-Employment Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Weekly Statistics -->
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="text-info mb-3">Weekly (Last 7 Days)</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-info mb-1">{{ $preEmploymentStats['weekly']['total'] }}</div>
                                        <div class="small text-muted">Total</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-success mb-1">{{ $preEmploymentStats['weekly']['passed'] }}</div>
                                        <div class="small text-muted">Passed</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-warning mb-1">{{ $preEmploymentStats['weekly']['pending'] }}</div>
                                        <div class="small text-muted">Pending</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-danger mb-1">{{ $preEmploymentStats['weekly']['failed'] }}</div>
                                        <div class="small text-muted">Failed</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Monthly Statistics -->
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="text-info mb-3">Monthly (Last 30 Days)</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-info mb-1">{{ $preEmploymentStats['monthly']['total'] }}</div>
                                        <div class="small text-muted">Total</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-success mb-1">{{ $preEmploymentStats['monthly']['passed'] }}</div>
                                        <div class="small text-muted">Passed</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-warning mb-1">{{ $preEmploymentStats['monthly']['pending'] }}</div>
                                        <div class="small text-muted">Pending</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-danger mb-1">{{ $preEmploymentStats['monthly']['failed'] }}</div>
                                        <div class="small text-muted">Failed</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Yearly Statistics -->
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="text-info mb-3">Yearly (Last 365 Days)</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-info mb-1">{{ $preEmploymentStats['yearly']['total'] }}</div>
                                        <div class="small text-muted">Total</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-success mb-1">{{ $preEmploymentStats['yearly']['passed'] }}</div>
                                        <div class="small text-muted">Passed</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-warning mb-1">{{ $preEmploymentStats['yearly']['pending'] }}</div>
                                        <div class="small text-muted">Pending</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-danger mb-1">{{ $preEmploymentStats['yearly']['failed'] }}</div>
                                        <div class="small text-muted">Failed</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <th>Type</th>
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
                                {{ $patient->appointment->appointment_type ?? 'N/A' }}
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
                        <th>Medical Examination</th>
                        <th>Blood Chemistry</th>
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
                                @if(is_array($preEmployment->medical_exam_type))
                                    {{ implode(', ', $preEmployment->medical_exam_type) }}
                                @else
                                    {{ $preEmployment->medical_exam_type ?? 'N/A' }}
                                @endif
                            </td>
                            <td>
                                @if(is_array($preEmployment->blood_tests))
                                    {{ implode(', ', $preEmployment->blood_tests) }}
                                @else
                                    {{ $preEmployment->blood_tests ?? 'N/A' }}
                                @endif
                            </td>
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

<!-- Annual Physical Examination Statistics Chart -->
<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Annual Physical Examination Statistics</h5>
            </div>
            <div class="card-body">
                <canvas id="annualPhysicalChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Pre-Employment Statistics Chart -->
<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Pre-Employment Statistics</h5>
            </div>
            <div class="card-body">
                <canvas id="preEmploymentChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Annual Physical Examination Chart
        const annualCtx = document.getElementById('annualPhysicalChart').getContext('2d');
        const annualChartData = @json($annualPhysicalChartData);
        new Chart(annualCtx, {
            type: 'line',
            data: {
                labels: annualChartData.map(item => item.date),
                datasets: [{
                    label: 'Annual Physical Examinations',
                    data: annualChartData.map(item => item.count),
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderColor: '#10b981',
                    borderWidth: 2,
                    pointRadius: 5,
                    pointBackgroundColor: '#10b981',
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Cases'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        });

        // Pre-Employment Chart
        const ctx = document.getElementById('preEmploymentChart').getContext('2d');
        const chartData = @json($preEmploymentChartData);
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.map(item => item.date),
                datasets: [{
                    label: 'Pre-Employment Cases',
                    data: chartData.map(item => item.count),
                    backgroundColor: 'rgba(37, 99, 235, 0.2)',
                    borderColor: '#2563eb',
                    borderWidth: 2,
                    pointRadius: 5,
                    pointBackgroundColor: '#2563eb',
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Cases'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        });
    });
</script>
@endpush 