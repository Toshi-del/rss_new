<?php $__env->startSection('title', 'Company Dashboard - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'Company Dashboard'); ?>
<?php $__env->startSection('page-description', 'Comprehensive overview of your company\'s medical examination activities and employee health records'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Welcome Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-blue-600 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-building text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Welcome to Your Dashboard</h2>
                        <p class="text-blue-100 text-sm">Monitor and manage your company's medical examination activities</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-white/90 text-sm">Today's Date</div>
                    <div class="text-white font-bold text-lg"><?php echo e(now()->format('M d, Y')); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Pending Appointments -->
        <div class="content-card rounded-xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Pending Appointments</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($pendingAppointmentsCount ?? 156); ?></p>
                </div>
                <div class="w-16 h-16 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-amber-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm">
                <span class="text-amber-600 font-medium">⏳ Awaiting approval</span>
            </div>
        </div>

        <!-- Approved Appointments -->
        <div class="content-card rounded-xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Approved Appointments</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($approvedAppointmentsCount ?? 892); ?></p>
                </div>
                <div class="w-16 h-16 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-emerald-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm">
                <span class="text-emerald-600 font-medium">✅ Ready for examination</span>
            </div>
        </div>

        <!-- Total Appointments -->
        <div class="content-card rounded-xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Appointments</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($totalAppointmentsCount ?? 1247); ?></p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-check text-blue-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm">
                <span class="text-blue-600 font-medium">📅 All time appointments</span>
            </div>
        </div>

        <!-- Pre-Employment Records -->
        <div class="content-card rounded-xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Pre-Employment Records</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($totalPreEmploymentCount ?? 45); ?></p>
                </div>
                <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-tie text-purple-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm">
                <span class="text-purple-600 font-medium">👔 New employee screenings</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-bolt text-blue-600"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Quick Actions</h3>
                <p class="text-gray-600 text-sm">Frequently used actions for efficient management</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="<?php echo e(route('company.appointments.create')); ?>" class="group bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-xl p-6 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-calendar-plus text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-blue-700">Schedule Appointment</h4>
                        <p class="text-sm text-gray-600">Book new medical examination</p>
                    </div>
                </div>
            </a>

            <a href="<?php echo e(route('company.pre-employment.create')); ?>" class="group bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-xl p-6 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-purple-700">New Pre-Employment</h4>
                        <p class="text-sm text-gray-600">Create employee screening record</p>
                    </div>
                </div>
            </a>

            <a href="<?php echo e(route('company.medical-results')); ?>" class="group bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-xl p-6 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-emerald-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-medical text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-emerald-700">View Medical Results</h4>
                        <p class="text-sm text-gray-600">Access examination reports</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Recent Appointments</h3>
                    <p class="text-gray-600 text-sm">Latest scheduled medical examinations</p>
                </div>
            </div>
            <a href="<?php echo e(route('company.appointments.index')); ?>" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center space-x-1">
                <span>View All</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        
        <?php if(isset($appointments) && count($appointments) > 0): ?>
        <div class="space-y-4">
            <?php $__currentLoopData = $appointments->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:bg-gray-100 transition-colors duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar text-blue-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">
                                <?php echo e(optional($appointment->medicalTestCategory)->name); ?>

                                <?php if($appointment->medicalTest): ?>
                                    - <?php echo e($appointment->medicalTest->name); ?>

                                <?php endif; ?>
                            </h4>
                            <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                                <span class="flex items-center space-x-1">
                                    <i class="fas fa-calendar-day text-xs"></i>
                                    <span><?php echo e($appointment->formatted_date ?? 'N/A'); ?></span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <i class="fas fa-clock text-xs"></i>
                                    <span><?php echo e($appointment->formatted_time_slot ?? 'N/A'); ?></span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <i class="fas fa-peso-sign text-xs"></i>
                                    <span>₱<?php echo e(number_format($appointment->total_price ?? 0, 2)); ?></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <?php
                            $statusConfig = [
                                'pending' => ['bg-amber-100 text-amber-700', 'fas fa-clock', 'Pending'],
                                'approved' => ['bg-emerald-100 text-emerald-700', 'fas fa-check-circle', 'Approved'],
                                'failed' => ['bg-red-100 text-red-700', 'fas fa-times-circle', 'Failed'],
                            ];
                            $status = $appointment->status ?? 'pending';
                            $config = $statusConfig[$status] ?? $statusConfig['pending'];
                        ?>
                        <span class="px-3 py-1 rounded-full text-xs font-medium <?php echo e($config[0]); ?> flex items-center space-x-1">
                            <i class="<?php echo e($config[1]); ?> text-xs"></i>
                            <span><?php echo e($config[2]); ?></span>
                        </span>
                        <div class="flex items-center space-x-2">
                            <a href="<?php echo e(route('company.appointments.show', $appointment->id)); ?>" class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="<?php echo e(route('company.appointments.edit', $appointment->id)); ?>" class="p-2 text-gray-600 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
            </div>
            <h4 class="text-lg font-medium text-gray-900 mb-2">No Appointments Yet</h4>
            <p class="text-gray-600 mb-4">Get started by scheduling your first medical examination.</p>
            <a href="<?php echo e(route('company.appointments.create')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Schedule Appointment
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Recent Pre-Employment Records -->
    <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-tie text-purple-600"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Recent Pre-Employment Records</h3>
                    <p class="text-gray-600 text-sm">Latest employee screening examinations</p>
                </div>
            </div>
            <a href="<?php echo e(route('company.pre-employment.index')); ?>" class="text-purple-600 hover:text-purple-700 font-medium text-sm flex items-center space-x-1">
                <span>View All</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        
        <?php if(isset($preEmploymentRecords) && count($preEmploymentRecords) > 0): ?>
        <div class="space-y-4">
            <?php $__currentLoopData = $preEmploymentRecords->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:bg-gray-100 transition-colors duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-purple-600 font-bold text-lg">
                                <?php echo e(substr($record->full_name ?? 'A', 0, 1)); ?>

                            </span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900"><?php echo e($record->full_name ?? 'Unknown Applicant'); ?></h4>
                            <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                                <span class="flex items-center space-x-1">
                                    <i class="fas fa-envelope text-xs"></i>
                                    <span><?php echo e($record->email ?? 'N/A'); ?></span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <i class="fas fa-calendar-day text-xs"></i>
                                    <span><?php echo e($record->created_at ? $record->created_at->format('M d, Y') : 'N/A'); ?></span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <i class="fas fa-peso-sign text-xs"></i>
                                    <span>₱<?php echo e(number_format($record->total_price ?? 0, 2)); ?></span>
                                </span>
                            </div>
                            <?php if($record->medicalTestCategory || $record->medicalTest): ?>
                            <div class="text-xs text-gray-500 mt-1">
                                <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full">
                                    <?php echo e(optional($record->medicalTestCategory)->name); ?>

                                    <?php if($record->medicalTest): ?>
                                        - <?php echo e($record->medicalTest->name); ?>

                                    <?php endif; ?>
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <?php
                            $statusConfig = [
                                'pending' => ['bg-amber-100 text-amber-700', 'fas fa-clock', 'Pending'],
                                'passed' => ['bg-emerald-100 text-emerald-700', 'fas fa-check-circle', 'Passed'],
                                'failed' => ['bg-red-100 text-red-700', 'fas fa-times-circle', 'Failed'],
                            ];
                            $status = $record->status ?? 'pending';
                            $config = $statusConfig[$status] ?? $statusConfig['pending'];
                        ?>
                        <span class="px-3 py-1 rounded-full text-xs font-medium <?php echo e($config[0]); ?> flex items-center space-x-1">
                            <i class="<?php echo e($config[1]); ?> text-xs"></i>
                            <span><?php echo e($config[2]); ?></span>
                        </span>
                        <div class="flex items-center space-x-2">
                            <a href="<?php echo e(route('company.pre-employment.show', $record->id)); ?>" class="p-2 text-purple-600 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-colors">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <?php if($record->uploaded_file): ?>
                            <a href="<?php echo e(asset('storage/' . $record->uploaded_file)); ?>" class="p-2 text-gray-600 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" download>
                                <i class="fas fa-download text-sm"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-times text-gray-400 text-2xl"></i>
            </div>
            <h4 class="text-lg font-medium text-gray-900 mb-2">No Pre-Employment Records Yet</h4>
            <p class="text-gray-600 mb-4">Start screening new employees with medical examinations.</p>
            <a href="<?php echo e(route('company.pre-employment.create')); ?>" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Create Record
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.company', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/company/dashboard.blade.php ENDPATH**/ ?>