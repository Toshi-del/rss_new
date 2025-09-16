@extends('layouts.admin')

@section('title', 'Analytics & Reports')
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

<<<<<<< Updated upstream
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50 p-6">
    <div class="max-w-7xl mx-auto space-y-8">
        
        <!-- Enhanced Header Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Analytics & Reports</h1>
                        <p class="text-sm text-gray-600 mt-1">Comprehensive insights into medical test performance and revenue trends</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $testData->sum('count') }}</div>
                        <div class="text-xs text-gray-500">Total Tests (90d)</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">₱{{ number_format($testData->sum('revenue'), 0) }}</div>
                        <div class="text-xs text-gray-500">Total Revenue (90d)</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Charts Section -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Medical Test Volume Chart -->
            <div class="xl:col-span-2">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 h-full">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-chart-area text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Medical Test Volume</h3>
                                    <p class="text-sm text-gray-500">Last 12 months trend</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full">All sources</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <canvas id="medicalTestsTrend" height="80" tabindex="-1"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Categories Chart -->
            <div class="xl:col-span-1">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 h-full">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chart-pie text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Top Categories</h3>
                                <p class="text-sm text-gray-500">Last 90 days</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <canvas id="topCategoriesChart" height="80" tabindex="-1"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Tables and Revenue Chart Section -->
        <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">
            <!-- Top Medical Tests Table -->
            <div class="xl:col-span-2">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 h-full">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-trophy text-orange-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Top Medical Tests</h3>
                                <p class="text-sm text-gray-500">Performance over last 90 days</p>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($testData as $index => $row)
                                        <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-6 h-6 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center text-white text-xs font-bold">
                                                        {{ $index + 1 }}
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $row['test'] }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $row['category'] }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="text-sm font-semibold text-gray-900">{{ $row['count'] }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="text-sm font-semibold text-green-600">₱{{ number_format($row['revenue'], 2) }}</div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mb-3">
                                                        <i class="fas fa-chart-bar text-gray-400 text-lg"></i>
                                                    </div>
                                                    <p class="text-gray-500 text-sm">No test data available</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Trend Chart -->
            <div class="xl:col-span-3">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 h-full">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-chart-line text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Financial Trend</h3>
                                    <p class="text-sm text-gray-500">Revenue by month</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-full">Pre-employment + Appointments</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <canvas id="revenueTrend" height="90" tabindex="-1"></canvas>
=======
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50" style="font-family: 'Inter', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Modern Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif;">Analytics & Reports</h1>
                    <p class="text-lg text-gray-600">Comprehensive insights into medical tests, revenue, and performance metrics</p>
                </div>
                <div class="mt-4 sm:mt-0 flex items-center space-x-2">
                    <div class="flex items-center px-3 py-2 bg-white rounded-lg border border-gray-200">
                        <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                        <span class="text-sm text-gray-600">Last updated: {{ now()->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Medical Test Volume Chart -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">Medical Test Volume</h3>
                            <p class="text-sm text-gray-600 mt-1">Test volume trends over the last 12 months</p>
                        </div>
                        <div class="flex items-center px-3 py-1 bg-blue-50 rounded-lg">
                            <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                            <span class="text-xs font-medium text-blue-800">All sources</span>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div style="height: 280px;">
                        <canvas id="medicalTestsTrend" tabindex="-1"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Categories Chart -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">Top Categories</h3>
                        <p class="text-sm text-gray-600 mt-1">Most popular test categories (90 days)</p>
                    </div>
                </div>
                <div class="p-6">
                    <div style="height: 280px;">
                        <canvas id="topCategoriesChart" tabindex="-1"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <!-- Top Medical Tests Table -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">Top Medical Tests</h3>
                        <p class="text-sm text-gray-600 mt-1">Performance metrics for the last 90 days</p>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($testData as $index => $row)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 mr-3">
                                                    <div class="h-8 w-8 rounded-full {{ $index < 3 ? 'bg-gradient-to-r from-yellow-400 to-orange-500' : 'bg-gradient-to-r from-blue-400 to-purple-500' }} flex items-center justify-center text-white font-bold text-xs">
                                                        {{ $index + 1 }}
                                                    </div>
                                                </div>
                                                <div class="text-sm font-medium text-gray-900">{{ $row['test'] }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $row['category'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="text-sm font-semibold text-gray-900">{{ $row['count'] }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="text-sm font-semibold text-green-600">₱{{ number_format($row['revenue'], 2) }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <i class="fas fa-chart-bar text-2xl text-gray-400"></i>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">No data available</h3>
                                                <p class="text-gray-500">Test data will appear here once records are available.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Revenue Trend Chart -->
            <div class="lg:col-span-3 bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">Financial Trend</h3>
                            <p class="text-sm text-gray-600 mt-1">Revenue by month from all sources</p>
                        </div>
                        <div class="flex items-center px-3 py-1 bg-green-50 rounded-lg">
                            <i class="fas fa-peso-sign text-green-600 mr-2"></i>
                            <span class="text-xs font-medium text-green-800">Pre-employment + Appointments</span>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div style="height: 320px;">
                        <canvas id="revenueTrend" tabindex="-1"></canvas>
>>>>>>> Stashed changes
                    </div>
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


