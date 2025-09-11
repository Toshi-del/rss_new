@extends('layouts.admin')

@section('title', 'Analytics & Reports - RSS Citi Health Services')
@section('page-title', 'Analytics & Reports')

@section('content')
@php
    // Ensure test data is available for the table rendered below
    $since = \Carbon\Carbon::now()->subDays(90);
    $testsEarly = \App\Models\MedicalTest::select('id','name','medical_test_category_id')->with('category')->get();
    $testData = $testsEarly->map(function($t) use ($since){
        $perCount = \App\Models\PreEmploymentRecord::where('medical_test_id', $t->id)
            ->where('created_at','>=',$since)
            ->count();
        $apptCount = \App\Models\Appointment::where('medical_test_id', $t->id)
            ->where('created_at','>=',$since)
            ->count();
        $perRevenue = (float) (\App\Models\PreEmploymentRecord::where('medical_test_id', $t->id)
            ->where('created_at','>=',$since)
            ->sum('total_price') ?? 0);
        try {
            $apptRevenue = (float) (\App\Models\Appointment::where('medical_test_id', $t->id)
                ->where('created_at','>=',$since)
                ->sum('total_price') ?? 0);
        } catch (\Throwable $e) { $apptRevenue = 0; }
        return [
            'test' => $t->name,
            'category' => optional($t->category)->name,
            'count' => $perCount + $apptCount,
            'revenue' => round($perRevenue + $apptRevenue, 2),
        ];
    })->filter(fn($row) => $row['count'] > 0)
      ->sortByDesc('count')
      ->take(10)
      ->values();
@endphp
<div class="container-fluid mt-3">
    <style>
        html { scroll-behavior: auto !important; }
        .card-body canvas { max-height: 220px; }
    </style>
    <div class="row g-3">
        <div class="col-12 col-xl-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Medical Test Volume (Last 12 Months)</h5>
                    <span class="text-muted small">All sources</span>
                </div>
                <div class="card-body">
                    <canvas id="medicalTestsTrend" height="80" tabindex="-1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Top Categories (Last 90 Days)</h5>
                </div>
                <div class="card-body">
                    <canvas id="topCategoriesChart" height="80" tabindex="-1"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-12 col-xl-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Top Medical Tests (Last 90 Days)</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="text-muted">Test</th>
                                    <th class="text-muted">Category</th>
                                    <th class="text-end text-muted">Count</th>
                                    <th class="text-end text-muted">Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($testData as $row)
                                    <tr>
                                        <td>{{ $row['test'] }}</td>
                                        <td>{{ $row['category'] }}</td>
                                        <td class="text-end">{{ $row['count'] }}</td>
                                        <td class="text-end">₱{{ number_format($row['revenue'], 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Financial Trend (Revenue by Month)</h5>
                    <span class="text-muted small">Sum of Pre-employment and Appointments</span>
                </div>
                <div class="card-body">
                    <canvas id="revenueTrend" height="90" tabindex="-1"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@php

    // Build last 12 months labels
    $months = collect(range(0, 11))->map(fn($i) => \Carbon\Carbon::now()->subMonths(11 - $i));
    $monthLabels = $months->map(fn($m) => $m->format('M Y'));

    // Medical test volume per month (from pre-employment records and appointments)
    $monthlyTestCounts = $months->map(function ($m) {
        $start = $m->copy()->startOfMonth();
        $end = $m->copy()->endOfMonth();
        $per = \App\Models\PreEmploymentRecord::whereBetween('created_at', [$start, $end])
            ->whereNotNull('medical_test_id')
            ->count();
        $appt = \App\Models\Appointment::whereBetween('created_at', [$start, $end])
            ->whereNotNull('medical_test_id')
            ->count();
        return $per + $appt;
    });

    // Top categories last 90 days by count
    $since = \Carbon\Carbon::now()->subDays(90);
    $categoryData = \App\Models\MedicalTestCategory::select('id','name')
        ->get()
        ->map(function ($cat) use ($since) {
            $per = \App\Models\PreEmploymentRecord::where('medical_test_categories_id', $cat->id)
                ->where('created_at', '>=', $since)
                ->count();
            $appt = \App\Models\Appointment::where('medical_test_categories_id', $cat->id)
                ->where('created_at', '>=', $since)
                ->count();
            return [
                'name' => $cat->name,
                'count' => $per + $appt,
            ];
        })
        ->sortByDesc('count')
        ->take(6)
        ->values();

    // Revenue trend per month (sum total_price)
    $monthlyRevenue = $months->map(function ($m) {
        $start = $m->copy()->startOfMonth();
        $end = $m->copy()->endOfMonth();
        $perTotal = (float) (\App\Models\PreEmploymentRecord::whereBetween('created_at', [$start, $end])->sum('total_price') ?? 0);
        // Appointments total_price may not exist for all rows; handle gracefully
        try {
            $apptTotal = (float) (\App\Models\Appointment::whereBetween('created_at', [$start, $end])->sum('total_price') ?? 0);
        } catch (\Throwable $e) {
            $apptTotal = 0;
        }
        return round($perTotal + $apptTotal, 2);
    });

    // Top tests last 90 days with counts and revenue
    $tests = \App\Models\MedicalTest::select('id','name','medical_test_category_id')->with('category')->get();
    $testData = $tests->map(function($t) use ($since){
        $perCount = \App\Models\PreEmploymentRecord::where('medical_test_id', $t->id)
            ->where('created_at','>=',$since)
            ->count();
        $apptCount = \App\Models\Appointment::where('medical_test_id', $t->id)
            ->where('created_at','>=',$since)
            ->count();
        $perRevenue = (float) (\App\Models\PreEmploymentRecord::where('medical_test_id', $t->id)
            ->where('created_at','>=',$since)
            ->sum('total_price') ?? 0);
        try {
            $apptRevenue = (float) (\App\Models\Appointment::where('medical_test_id', $t->id)
                ->where('created_at','>=',$since)
                ->sum('total_price') ?? 0);
        } catch (\Throwable $e) { $apptRevenue = 0; }
        return [
            'test' => $t->name,
            'category' => optional($t->category)->name,
            'count' => $perCount + $apptCount,
            'revenue' => round($perRevenue + $apptRevenue, 2),
        ];
    })->filter(fn($row) => $row['count'] > 0)
      ->sortByDesc('count')
      ->take(10)
      ->values();
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    (function(){
        const monthLabels = @json($monthLabels);
        const testCounts = @json($monthlyTestCounts);
        const revenue = @json($monthlyRevenue);
        const topCatLabels = @json($categoryData->pluck('name'));
        const topCatCounts = @json($categoryData->pluck('count'));

        const primary = getComputedStyle(document.documentElement).getPropertyValue('--bs-primary') || '#0d6efd';
        const success = getComputedStyle(document.documentElement).getPropertyValue('--bs-success') || '#198754';
        const warning = getComputedStyle(document.documentElement).getPropertyValue('--bs-warning') || '#ffc107';

        // Medical tests trend
        new Chart(document.getElementById('medicalTestsTrend'), {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Tests',
                    data: testCounts,
                    tension: 0.35,
                    borderColor: primary.trim(),
                    backgroundColor: primary.trim() + '22',
                    borderWidth: 2,
                    fill: true,
                    pointRadius: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });

        // Top categories bar
        new Chart(document.getElementById('topCategoriesChart'), {
            type: 'bar',
            data: {
                labels: topCatLabels,
                datasets: [{
                    label: 'Count',
                    data: topCatCounts,
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

        // Revenue trend
        new Chart(document.getElementById('revenueTrend'), {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Revenue (PHP)',
                    data: revenue,
                    tension: 0.35,
                    borderColor: success.trim(),
                    backgroundColor: success.trim() + '22',
                    borderWidth: 2,
                    fill: true,
                    pointRadius: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: { label: (ctx) => '₱' + Number(ctx.parsed.y).toLocaleString(undefined, {minimumFractionDigits:2}) }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (v) => '₱' + Number(v).toLocaleString()
                        }
                    }
                }
            }
        });
    })();
</script>
@endsection


