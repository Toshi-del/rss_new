<?php $__env->startSection('title', 'Dashboard - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'Dashboard Overview'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Total Patients Card -->
        <div class="stat-card content-card rounded-lg p-6 hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-2 uppercase tracking-wide">Total Patients</p>
                    <div class="flex items-center space-x-3">
                        <p class="text-2xl font-semibold text-gray-900"><?php echo e(number_format($totalPatients)); ?></p>
                        <?php
                            $lastMonthPatients = \App\Models\Patient::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();
                            $currentMonthPatients = \App\Models\Patient::whereBetween('created_at', [now()->startOfMonth(), now()])->count();
                            $percentageChange = $lastMonthPatients > 0 ? (($currentMonthPatients - $lastMonthPatients) / $lastMonthPatients) * 100 : 0;
                        ?>
                        <?php if($percentageChange > 0): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">
                                <i class="fas fa-arrow-up text-xs mr-1"></i>
                                +<?php echo e(number_format($percentageChange, 1)); ?>%
                            </span>
                        <?php elseif($percentageChange < 0): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-50 text-red-700">
                                <i class="fas fa-arrow-down text-xs mr-1"></i>
                                <?php echo e(number_format($percentageChange, 1)); ?>%
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-50 text-gray-700">
                                <i class="fas fa-minus text-xs mr-1"></i>
                                0%
                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">vs last month</p>
                </div>
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Appointments Today Card -->
        <div class="stat-card content-card rounded-lg p-6 hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-2 uppercase tracking-wide">Today's Appointments</p>
                    <div class="flex items-center space-x-3">
                        <p class="text-2xl font-semibold text-gray-900"><?php echo e($testsToday); ?></p>
                        <?php
                            $pendingAppointments = \App\Models\Appointment::where('status', 'pending')->count();
                        ?>
                        <?php if($testsToday > 0): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">
                                <i class="fas fa-calendar-check text-xs mr-1"></i>
                                Active
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-50 text-gray-700">
                                <i class="fas fa-calendar text-xs mr-1"></i>
                                None
                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="text-xs text-gray-500 mt-1"><?php echo e($pendingAppointments); ?> pending approval</p>
                </div>
                <div class="w-12 h-12 bg-emerald-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-white text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Pending Tests Card -->
        <div class="stat-card content-card rounded-lg p-6 hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-2 uppercase tracking-wide">Pending Tests</p>
                    <div class="flex items-center space-x-3">
                        <?php
                            $pendingTests = \App\Models\Appointment::where('status', 'pending')->count();
                        ?>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo e($pendingTests); ?></p>
                        <?php if($pendingTests > 0): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-50 text-orange-700">
                                <i class="fas fa-clock text-xs mr-1"></i>
                                Pending
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">
                                <i class="fas fa-check text-xs mr-1"></i>
                                Clear
                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">awaiting results</p>
                </div>
                <div class="w-12 h-12 bg-amber-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-vial text-white text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="stat-card content-card rounded-lg p-6 hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-2 uppercase tracking-wide">Monthly Revenue</p>
                    <div class="flex items-center space-x-3">
                        <?php
                            // Calculate current month revenue from all sources
                            $currentMonth = now();
                            $startOfMonth = $currentMonth->copy()->startOfMonth();
                            $endOfMonth = $currentMonth->copy()->endOfMonth();
                            
                            // 1. Appointments Revenue (calculated with patient count)
                            $appointments = \App\Models\Appointment::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                ->where('status', 'approved')
                                ->with(['patients', 'medicalTest'])
                                ->get();
                            $appointmentRevenue = 0;
                            foreach($appointments as $appointment) {
                                $patientCount = $appointment->patients->count();
                                $testPrice = $appointment->medicalTest ? $appointment->medicalTest->price : 0;
                                $appointmentRevenue += ($testPrice * $patientCount);
                            }
                            
                            // 2. Pre-Employment Revenue
                            $preEmploymentRevenue = \App\Models\PreEmploymentRecord::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                ->sum('total_price') ?? 0;
                            
                            // 3. OPD Revenue (if OPD examinations have pricing)
                            $opdRevenue = 0;
                            try {
                                $opdExaminations = \App\Models\OpdExamination::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                    ->with('user')
                                    ->get();
                                foreach($opdExaminations as $opd) {
                                    // Assuming OPD has a standard rate or calculate based on services
                                    $opdRevenue += 500; // Default OPD consultation fee
                                }
                            } catch (\Exception $e) {
                                $opdRevenue = 0;
                            }
                            
                            $monthlyRevenue = $appointmentRevenue + $preEmploymentRevenue + $opdRevenue;
                            
                            // Calculate last month revenue for comparison
                            $lastMonth = now()->subMonth();
                            $lastMonthStart = $lastMonth->copy()->startOfMonth();
                            $lastMonthEnd = $lastMonth->copy()->endOfMonth();
                            
                            $lastMonthAppointments = \App\Models\Appointment::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                                ->where('status', 'approved')
                                ->with(['patients', 'medicalTest'])
                                ->get();
                            $lastMonthApptRevenue = 0;
                            foreach($lastMonthAppointments as $appointment) {
                                $patientCount = $appointment->patients->count();
                                $testPrice = $appointment->medicalTest ? $appointment->medicalTest->price : 0;
                                $lastMonthApptRevenue += ($testPrice * $patientCount);
                            }
                            
                            $lastMonthPreEmpRevenue = \App\Models\PreEmploymentRecord::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                                ->sum('total_price') ?? 0;
                            
                            $lastMonthOpdRevenue = 0;
                            try {
                                $lastMonthOpdCount = \App\Models\OpdExamination::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
                                $lastMonthOpdRevenue = $lastMonthOpdCount * 500;
                            } catch (\Exception $e) {
                                $lastMonthOpdRevenue = 0;
                            }
                            
                            $lastMonthRevenue = $lastMonthApptRevenue + $lastMonthPreEmpRevenue + $lastMonthOpdRevenue;
                            $revenueChange = $lastMonthRevenue > 0 ? (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;
                        ?>
                        <p class="text-2xl font-semibold text-gray-900">₱<?php echo e(number_format($monthlyRevenue, 0)); ?></p>
                        <?php if($revenueChange > 0): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-50 text-blue-700">
                                <i class="fas fa-arrow-up text-xs mr-1"></i>
                                +<?php echo e(number_format($revenueChange, 1)); ?>%
                            </span>
                        <?php elseif($revenueChange < 0): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-50 text-red-700">
                                <i class="fas fa-arrow-down text-xs mr-1"></i>
                                <?php echo e(number_format($revenueChange, 1)); ?>%
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-50 text-gray-700">
                                <i class="fas fa-minus text-xs mr-1"></i>
                                0%
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php
                        $targetRevenue = 180000; // ₱180K target
                    ?>
                    <div class="mt-2 space-y-1">
                        <p class="text-xs text-gray-500">target: ₱<?php echo e(number_format($targetRevenue, 0)); ?></p>
                        <div class="flex items-center space-x-4 text-xs">
                            <span class="text-blue-600">Appointments: ₱<?php echo e(number_format($appointmentRevenue, 0)); ?></span>
                            <span class="text-purple-600">Pre-Emp: ₱<?php echo e(number_format($preEmploymentRevenue, 0)); ?></span>
                            <span class="text-green-600">OPD: ₱<?php echo e(number_format($opdRevenue, 0)); ?></span>
                        </div>
                    </div>
                </div>
                <div class="w-12 h-12 bg-cyan-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Critical Stock Alert Section -->
    <?php if(isset($criticalStockCount) && $criticalStockCount > 0): ?>
        <div class="mb-8">
            <div class="content-card rounded-lg overflow-hidden border-l-4 border-red-500">
                <div class="bg-red-50 px-6 py-4 border-b border-red-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-red-600 text-lg animate-pulse"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-red-800">Critical Stock Alert</h3>
                            <p class="text-red-600 text-sm"><?php echo e($criticalStockCount); ?> <?php echo e(Str::plural('item', $criticalStockCount)); ?> require immediate attention</p>
                        </div>
                        <div class="ml-auto">
                            <a href="<?php echo e(route('admin.inventory.index')); ?>" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors duration-200">
                                <i class="fas fa-boxes mr-2"></i>
                                Manage Inventory
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $criticalStockItems->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white border border-red-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-gray-900 text-sm truncate"><?php echo e($item->item_name); ?></h4>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Critical
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-sm text-gray-600">
                                    <span>Current Stock: <strong class="text-red-600"><?php echo e($item->item_quantity); ?></strong></span>
                                    <span>Min Required: <strong><?php echo e($item->minimum_stock); ?></strong></span>
                                </div>
                                <div class="mt-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <?php
                                            $percentage = $item->minimum_stock > 0 ? min(($item->item_quantity / $item->minimum_stock) * 100, 100) : 0;
                                        ?>
                                        <div class="bg-red-500 h-2 rounded-full transition-all duration-1000" style="width: <?php echo e($percentage); ?>%"></div>
                                    </div>
                                    <p class="text-xs text-red-600 mt-1 font-medium">
                                        <?php echo e($item->minimum_stock - $item->item_quantity); ?> units needed
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <?php if($criticalStockCount > 6): ?>
                        <div class="mt-4 text-center">
                            <a href="<?php echo e(route('admin.inventory.index')); ?>" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                View <?php echo e($criticalStockCount - 6); ?> more critical items →
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Recent Appointments -->
        <div class="xl:col-span-2">
            <div class="content-card rounded-lg overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Recent Appointments</h3>
                            <p class="text-blue-100 text-sm">Latest patient bookings and schedules</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-4 px-2 text-sm font-bold text-gray-700 uppercase tracking-wider">Patient</th>
                                    <th class="text-left py-4 px-2 text-sm font-bold text-gray-700 uppercase tracking-wider">Time</th>
                                    <th class="text-left py-4 px-2 text-sm font-bold text-gray-700 uppercase tracking-wider">Service</th>
                                    <th class="text-left py-4 px-2 text-sm font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="text-left py-4 px-2 text-sm font-bold text-gray-700 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $appointment = $patient->appointment;
                                        $initials = strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1));
                                        $colors = ['from-blue-500 to-purple-600', 'from-emerald-500 to-teal-600', 'from-purple-500 to-pink-600', 'from-orange-500 to-red-600', 'from-cyan-500 to-blue-600'];
                                        $colorIndex = crc32($patient->id) % count($colors);
                                    ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="py-4 px-2">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-12 h-12 bg-gradient-to-br <?php echo e($colors[$colorIndex]); ?> rounded-2xl flex items-center justify-center text-white font-bold text-lg">
                                                    <?php echo e($initials); ?>

                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900"><?php echo e($patient->full_name); ?></div>
                                                    <div class="text-sm text-gray-500"><?php echo e($patient->email ?? 'No email'); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-2">
                                            <div class="font-medium text-gray-900"><?php echo e($appointment ? $appointment->time_slot : 'N/A'); ?></div>
                                            <div class="text-sm text-gray-500">
                                                <?php if($appointment && $appointment->appointment_date): ?>
                                                    <?php if($appointment->appointment_date->isToday()): ?>
                                                        Today
                                                    <?php elseif($appointment->appointment_date->isTomorrow()): ?>
                                                        Tomorrow
                                                    <?php else: ?>
                                                        <?php echo e($appointment->appointment_date->format('M d')); ?>

                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    N/A
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="py-4 px-2">
                                            <div class="font-medium text-gray-900">
                                                <?php if($appointment && $appointment->medicalTest): ?>
                                                    <?php echo e($appointment->medicalTest->name); ?>

                                                <?php elseif($appointment && $appointment->medicalTestCategory): ?>
                                                    <?php echo e($appointment->medicalTestCategory->name); ?>

                                                <?php else: ?>
                                                    General Checkup
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?php if($appointment && $appointment->medicalTest): ?>
                                                    <?php echo e($appointment->medicalTest->description ?? 'Medical Test'); ?>

                                                <?php else: ?>
                                                    Medical Examination
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="py-4 px-2">
                                            <?php if($appointment): ?>
                                                <?php switch($appointment->status):
                                                    case ('approved'): ?>
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                            <i class="fas fa-check-circle mr-1"></i>
                                                            Approved
                                                        </span>
                                                        <?php break; ?>
                                                    <?php case ('pending'): ?>
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                                            <i class="fas fa-clock mr-1"></i>
                                                            Pending
                                                        </span>
                                                        <?php break; ?>
                                                    <?php case ('cancelled'): ?>
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                            <i class="fas fa-times-circle mr-1"></i>
                                                            Cancelled
                                                        </span>
                                                        <?php break; ?>
                                                    <?php default: ?>
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                            <i class="fas fa-calendar mr-1"></i>
                                                            Scheduled
                                                        </span>
                                                <?php endswitch; ?>
                                            <?php else: ?>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                                    <i class="fas fa-question mr-1"></i>
                                                    Unknown
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 px-2">
                                            <?php if($appointment): ?>
                                                <a href="<?php echo e(route('admin.appointments')); ?>" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">View Details</a>
                                            <?php else: ?>
                                                <span class="text-gray-400 text-sm">No appointment</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="py-8 px-2 text-center text-gray-500">
                                            <div class="flex flex-col items-center space-y-2">
                                                <i class="fas fa-calendar-times text-3xl text-gray-300"></i>
                                                <p class="font-medium">No recent appointments</p>
                                                <p class="text-sm">Appointments will appear here once patients book services</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Content -->
        <div class="space-y-8">
            <!-- Quick Actions -->
            <div class="content-card rounded-lg overflow-hidden">
                <div class="bg-emerald-600 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-bolt text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Quick Actions</h3>
                            <p class="text-emerald-100 text-xs">Frequently used functions</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 space-y-3">
                    <a href="<?php echo e(route('admin.appointments')); ?>" class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-calendar-check mr-2 text-sm"></i>
                        View Appointments
                    </a>
                    
                    <a href="<?php echo e(route('admin.pre-employment')); ?>" class="w-full flex items-center justify-center px-4 py-3 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition-colors duration-200">
                        <i class="fas fa-file-medical mr-2 text-sm"></i>
                        View Pre-Employment
                    </a>
                    
                    <a href="<?php echo e(route('admin.tests')); ?>" class="w-full flex items-center justify-center px-4 py-3 bg-amber-600 text-white rounded-lg font-medium hover:bg-amber-700 transition-colors duration-200">
                        <i class="fas fa-vial mr-2 text-sm"></i>
                        View Medical Tests
                    </a>
                    
                    <a href="<?php echo e(route('admin.inventory.index')); ?>" class="w-full flex items-center justify-center px-4 py-3 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors duration-200">
                        <i class="fas fa-boxes mr-2 text-sm"></i>
                        Manage Inventory
                    </a>
                    
                    <a href="<?php echo e(route('admin.report')); ?>" class="w-full flex items-center justify-center px-4 py-3 bg-slate-600 text-white rounded-lg font-medium hover:bg-slate-700 transition-colors duration-200">
                        <i class="fas fa-chart-line mr-2 text-sm"></i>
                        View Reports
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="content-card rounded-lg overflow-hidden">
                <div class="bg-cyan-600 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-activity text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Recent Activity</h3>
                            <p class="text-cyan-100 text-xs">Latest system updates</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 space-y-5">
                    <?php
                        // Get recent activities from different models
                        $recentPatients = \App\Models\Patient::orderBy('created_at', 'desc')->limit(2)->get();
                        $recentAppointments = \App\Models\Appointment::where('status', 'approved')->orderBy('updated_at', 'desc')->limit(2)->get();
                        $recentPreEmployment = \App\Models\PreEmploymentRecord::orderBy('created_at', 'desc')->limit(1)->get();
                        
                        // Combine and sort activities
                        $activities = collect();
                        
                        foreach($recentPatients as $patient) {
                            $activities->push([
                                'type' => 'patient_registered',
                                'title' => 'New patient registered',
                                'description' => $patient->full_name . ' completed registration',
                                'time' => $patient->created_at,
                                'color' => 'emerald-500',
                                'pulse' => true
                            ]);
                        }
                        
                        foreach($recentAppointments as $appointment) {
                            $activities->push([
                                'type' => 'appointment_approved',
                                'title' => 'Appointment approved',
                                'description' => 'Appointment for ' . $appointment->appointment_date->format('M d, Y') . ' confirmed',
                                'time' => $appointment->updated_at,
                                'color' => 'blue-500',
                                'pulse' => false
                            ]);
                        }
                        
                        foreach($recentPreEmployment as $preEmp) {
                            $activities->push([
                                'type' => 'pre_employment',
                                'title' => 'Pre-employment record created',
                                'description' => ($preEmp->first_name ?? 'New') . ' ' . ($preEmp->last_name ?? 'applicant') . ' submitted application',
                                'time' => $preEmp->created_at,
                                'color' => 'purple-500',
                                'pulse' => false
                            ]);
                        }
                        
                        // Sort by time and take top 5
                        $activities = $activities->sortByDesc('time')->take(5);
                    ?>
                    
                    <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-start space-x-4">
                            <div class="w-3 h-3 bg-<?php echo e($activity['color']); ?> rounded-full mt-2 <?php echo e($activity['pulse'] ? 'pulse-icon' : ''); ?>"></div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 text-sm"><?php echo e($activity['title']); ?></p>
                                <p class="text-xs text-gray-500 mt-1"><?php echo e($activity['description']); ?></p>
                                <p class="text-xs text-gray-400"><?php echo e($activity['time']->diffForHumans()); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <!-- Fallback activities if no real data -->
                        <div class="flex items-start space-x-4">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 text-sm">System initialized</p>
                                <p class="text-xs text-gray-500 mt-1">RSS Citi Health Services dashboard ready</p>
                                <p class="text-xs text-gray-400"><?php echo e(now()->diffForHumans()); ?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-3 h-3 bg-green-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 text-sm">Database connected</p>
                                <p class="text-xs text-gray-500 mt-1">All systems operational</p>
                                <p class="text-xs text-gray-400"><?php echo e(now()->subMinutes(5)->diffForHumans()); ?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-3 h-3 bg-purple-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 text-sm">Admin dashboard loaded</p>
                                <p class="text-xs text-gray-500 mt-1">Ready to manage appointments and patients</p>
                                <p class="text-xs text-gray-400"><?php echo e(now()->subMinutes(10)->diffForHumans()); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>