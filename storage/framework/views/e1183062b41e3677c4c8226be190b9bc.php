<?php $__env->startSection('title', 'ECG Technician Dashboard'); ?>

<?php $__env->startSection('page-title', 'ECG Technician Dashboard'); ?>
<?php $__env->startSection('page-description', 'Manage ECG examinations and cardiac monitoring for all patient types'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="mb-8 p-4 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 flex items-center space-x-3">
        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
            <i class="fas fa-check text-white text-sm"></i>
        </div>
        <div>
            <p class="text-green-800 font-semibold"><?php echo e(session('success')); ?></p>
        </div>
        <button onclick="this.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
<?php endif; ?>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
    <!-- Pre-Employment Records Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-briefcase text-white text-lg"></i>
                </div>
                <span class="bg-blue-100 text-blue-700 text-sm font-bold px-3 py-1 rounded-full"><?php echo e($preEmploymentCount); ?></span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pre-Employment</h3>
            <p class="text-gray-600 text-sm mb-6">ECG examinations for employment screening</p>
            <a href="#pre-employment-section" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold text-sm group-hover:translate-x-1 transition-all duration-200">
                View Records
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
        <div class="h-1 bg-gradient-to-r from-blue-500 to-blue-600 rounded-b-xl"></div>
    </div>

    <!-- Annual Physical Patients Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-heartbeat text-white text-lg"></i>
                </div>
                <span class="bg-green-100 text-green-700 text-sm font-bold px-3 py-1 rounded-full"><?php echo e($patientCount); ?></span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Annual Physical</h3>
            <p class="text-gray-600 text-sm mb-6">Routine cardiac health assessments</p>
            <a href="#annual-physical-section" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold text-sm group-hover:translate-x-1 transition-all duration-200">
                View Patients
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
        <div class="h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-b-xl"></div>
    </div>

    <!-- ECG Reports Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-chart-line text-white text-lg"></i>
                </div>
                <span class="bg-purple-100 text-purple-700 text-sm font-bold px-3 py-1 rounded-full"><?php echo e($ecgReportCount); ?></span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">ECG Reports</h3>
            <p class="text-gray-600 text-sm mb-6">Completed cardiac examinations today</p>
            <a href="#ecg-reports-section" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold text-sm group-hover:translate-x-1 transition-all duration-200">
                View Reports
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
        <div class="h-1 bg-gradient-to-r from-purple-500 to-purple-600 rounded-b-xl"></div>
    </div>
</div>

<!-- Pre-Employment Records Section -->
<div id="pre-employment-section" class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
    <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-briefcase text-white"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Pre-Employment Records</h2>
                <p class="text-gray-600 text-sm mt-1">Manage ECG examinations for employment screening</p>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Patient</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Age</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Gender</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Company</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $preEmployments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preEmployment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        <?php echo e(strtoupper(substr($preEmployment->first_name, 0, 1) . substr($preEmployment->last_name, 0, 1))); ?>

                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($preEmployment->first_name); ?> <?php echo e($preEmployment->last_name); ?></p>
                                    <p class="text-xs text-gray-500">Pre-Employment Exam</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-600 font-medium"><?php echo e($preEmployment->age); ?></td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-600 font-medium"><?php echo e($preEmployment->sex); ?></td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-600 font-medium"><?php echo e($preEmployment->company_name); ?></td>
                        <td class="px-6 py-6 whitespace-nowrap">
                            <?php
                                $statusConfig = match($preEmployment->status) {
                                    'approved' => ['class' => 'bg-green-100 text-green-700 border-green-200', 'icon' => 'fas fa-check-circle'],
                                    'declined' => ['class' => 'bg-red-100 text-red-700 border-red-200', 'icon' => 'fas fa-times-circle'],
                                    'pending' => ['class' => 'bg-yellow-100 text-yellow-700 border-yellow-200', 'icon' => 'fas fa-clock'],
                                    default => ['class' => 'bg-gray-100 text-gray-700 border-gray-200', 'icon' => 'fas fa-question-circle']
                                };
                            ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border <?php echo e($statusConfig['class']); ?>">
                                <i class="<?php echo e($statusConfig['icon']); ?> mr-1"></i>
                                <?php echo e(ucfirst($preEmployment->status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-2">
                                <a href="<?php echo e(route('ecgtech.medical-checklist-page.pre-employment', $preEmployment->id)); ?>" class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition-colors duration-200" title="ECG Checklist">
                                    <i class="fas fa-heartbeat mr-1"></i>
                                    ECG Check
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-briefcase text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">No pre-employment records found</p>
                                <p class="text-gray-400 text-sm">New records will appear here when available</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Annual Physical Patients Section -->
<div id="annual-physical-section" class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
    <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-heartbeat text-white"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Annual Physical Patients</h2>
                <p class="text-gray-600 text-sm mt-1">Routine cardiac health assessments and monitoring</p>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Patient</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Age</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Gender</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        <?php echo e(strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1))); ?>

                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></p>
                                    <p class="text-xs text-gray-500">Annual Physical Exam</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-600 font-medium"><?php echo e($patient->age); ?></td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-600 font-medium"><?php echo e($patient->sex); ?></td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-600 font-medium"><?php echo e($patient->email); ?></td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-2">
                                <form action="<?php echo e(route('ecgtech.annual-physical.send-to-doctor', $patient->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-colors duration-200" title="Send to Doctor">
                                        <i class="fas fa-paper-plane mr-1"></i>
                                        Send
                                    </button>
                                </form>
                                <a href="<?php echo e(route('ecgtech.medical-checklist-page.annual-physical', $patient->id)); ?>" class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition-colors duration-200" title="ECG Checklist">
                                    <i class="fas fa-heartbeat mr-1"></i>
                                    ECG Check
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-heartbeat text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">No annual physical patients found</p>
                                <p class="text-gray-400 text-sm">New patients will appear here when scheduled</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ECG Reports Section -->
<div id="ecg-reports-section" class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
    <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-indigo-50">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-line text-white"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Recent ECG Reports</h2>
                <p class="text-gray-600 text-sm mt-1">View completed cardiac examination activities and results</p>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Patient</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">ECG Result</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $ecgReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        <?php echo e(strtoupper(substr($report->patient_name ?? 'N', 0, 1) . substr(explode(' ', $report->patient_name ?? 'A')[1] ?? 'A', 0, 1))); ?>

                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($report->patient_name ?? 'N/A'); ?></p>
                                    <p class="text-xs text-gray-500">ECG Report</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-600 font-medium">
                            <?php echo e($report->date ? \Carbon\Carbon::parse($report->date)->format('M d, Y') : 'N/A'); ?>

                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-600 font-medium">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                <?php echo e($report->ecg_result ?? 'Pending Analysis'); ?>

                            </span>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap">
                            <?php
                                $statusConfig = match($report->status ?? 'pending') {
                                    'completed' => ['class' => 'bg-green-100 text-green-700 border-green-200', 'icon' => 'fas fa-check-circle'],
                                    'cancelled' => ['class' => 'bg-red-100 text-red-700 border-red-200', 'icon' => 'fas fa-times-circle'],
                                    'pending' => ['class' => 'bg-yellow-100 text-yellow-700 border-yellow-200', 'icon' => 'fas fa-clock'],
                                    default => ['class' => 'bg-gray-100 text-gray-700 border-gray-200', 'icon' => 'fas fa-question-circle']
                                };
                            ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border <?php echo e($statusConfig['class']); ?>">
                                <i class="<?php echo e($statusConfig['icon']); ?> mr-1"></i>
                                <?php echo e(ucfirst($report->status ?? 'pending')); ?>

                            </span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-chart-line text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">No ECG reports found</p>
                                <p class="text-gray-400 text-sm">Completed examinations will appear here</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ecgtech', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/ecgtech/dashboard.blade.php ENDPATH**/ ?>