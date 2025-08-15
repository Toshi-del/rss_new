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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Annual Physical Examination Statistics</h5>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-period="weekly" data-chart="annual">Weekly</button>
                    <button type="button" class="btn btn-outline-primary btn-sm filter-btn active" data-period="monthly" data-chart="annual">Monthly</button>
                    <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-period="yearly" data-chart="annual">Yearly</button>
                </div>
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Pre-Employment Statistics</h5>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-info btn-sm filter-btn" data-period="weekly" data-chart="preEmployment">Weekly</button>
                    <button type="button" class="btn btn-outline-info btn-sm filter-btn active" data-period="monthly" data-chart="preEmployment">Monthly</button>
                    <button type="button" class="btn btn-outline-info btn-sm filter-btn" data-period="yearly" data-chart="preEmployment">Yearly</button>
                </div>
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
        // Chart instances
        let annualChart, preEmploymentChart;
        
        // Utility to slice dataset by period
        function getSlice(data, period) {
            const days = period === 'weekly' ? 7 : period === 'monthly' ? 30 : 365;
            const sliced = data.slice(-days);
            return {
                labels: sliced.map(item => item.date),
                values: sliced.map(item => item.count)
            };
        }
        
        // Annual Physical Examination Chart
        const annualCtx = document.getElementById('annualPhysicalChart').getContext('2d');
        const annualFullData = @json($annualPhysicalChartData);
        // Default view: monthly
        const annualInitial = getSlice(annualFullData, 'monthly');
        annualChart = new Chart(annualCtx, {
            type: 'bar',
            data: {
                labels: annualInitial.labels,
                datasets: [{
                    label: 'Annual Physical Examinations',
                    data: annualInitial.values,
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderColor: '#10b981',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false
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
        const preEmploymentFullData = @json($preEmploymentChartData);
        // Default view: monthly
        const preEmploymentInitial = getSlice(preEmploymentFullData, 'monthly');
        preEmploymentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: preEmploymentInitial.labels,
                datasets: [{
                    label: 'Pre-Employment Cases',
                    data: preEmploymentInitial.values,
                    backgroundColor: 'rgba(37, 99, 235, 0.8)',
                    borderColor: '#2563eb',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false
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

        // Filter button functionality
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                const period = this.getAttribute('data-period');
                const chartType = this.getAttribute('data-chart');
                
                // Update button states
                const buttonGroup = this.closest('.btn-group');
                buttonGroup.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                
                // Update the selected chart with the requested period
                updateChartData(chartType, period);
            });
        });
    });
    
    // Function to update chart data using preloaded datasets
    function updateChartData(chartType, period) {
        if (chartType === 'annual') {
            const slice = getSlice(annualFullData, period);
            annualChart.data.labels = slice.labels;
            annualChart.data.datasets[0].data = slice.values;
            annualChart.update();
        } else if (chartType === 'preEmployment') {
            const slice = getSlice(preEmploymentFullData, period);
            preEmploymentChart.data.labels = slice.labels;
            preEmploymentChart.data.datasets[0].data = slice.values;
            preEmploymentChart.update();
        }
    }
</script>
@endpush 