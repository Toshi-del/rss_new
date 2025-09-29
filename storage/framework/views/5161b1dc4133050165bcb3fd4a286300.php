<?php $__env->startSection('title', 'Appointment Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-calendar-check mr-3"></i>Appointment Details
                        </h1>
                        <p class="text-blue-100">View and manage appointment information</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="<?php echo e(route('company.appointments.edit', $appointment)); ?>" 
                           class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 transition-all duration-200 shadow-sm">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Appointment
                        </a>
                        <a href="<?php echo e(route('company.appointments.index')); ?>" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 transition-all duration-200 shadow-sm">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Single Column Layout -->
        <div class="space-y-8">
            
            <!-- Basic Information Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700 border-l-4 border-blue-800">
                    <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-info-circle mr-3"></i>Basic Information
                    </h2>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="space-y-6">
                            <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-600">
                                <label class="block text-sm font-medium text-blue-700 mb-2">Appointment ID</label>
                                <p class="text-xl font-bold text-blue-900">#<?php echo e($appointment->id); ?></p>
                            </div>
                            <div class="p-4 bg-green-50 rounded-lg border-l-4 border-green-600">
                                <label class="block text-sm font-medium text-green-700 mb-2">Date</label>
                                <p class="text-lg font-semibold text-green-900 flex items-center">
                                    <i class="fas fa-calendar mr-2 text-green-600"></i>
                                    <?php echo e($appointment->formatted_date); ?>

                                </p>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="p-4 bg-purple-50 rounded-lg border-l-4 border-purple-600">
                                <label class="block text-sm font-medium text-purple-700 mb-2">Time Slot</label>
                                <p class="text-lg font-semibold text-purple-900 flex items-center">
                                    <i class="fas fa-clock mr-2 text-purple-600"></i>
                                    <?php echo e($appointment->formatted_time_slot); ?>

                                </p>
                            </div>
                            <div class="p-4 bg-emerald-50 rounded-lg border-l-4 border-emerald-600">
                                <label class="block text-sm font-medium text-emerald-700 mb-2">Status</label>
                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-bold bg-emerald-600 text-white">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Scheduled
                                </span>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="p-4 bg-indigo-50 rounded-lg border-l-4 border-indigo-600">
                                <label class="block text-sm font-medium text-indigo-700 mb-2">Medical Exam</label>
                                <p class="text-lg font-semibold text-indigo-900">
                                    <?php echo e(optional($appointment->medicalTestCategory)->name); ?>

                                    <?php if($appointment->medicalTest): ?>
                                        <br><span class="text-sm text-indigo-700"><?php echo e($appointment->medicalTest->name); ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="p-4 bg-rose-50 rounded-lg border-l-4 border-rose-600">
                                <label class="block text-sm font-medium text-rose-700 mb-2">Created By</label>
                                <p class="text-lg font-semibold text-rose-900 flex items-center">
                                    <i class="fas fa-user mr-2 text-rose-600"></i>
                                    <?php echo e($appointment->creator->full_name); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Test Card -->
            <?php if($appointment->medicalTest): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-emerald-600 to-emerald-700 border-l-4 border-emerald-800">
                    <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-vial mr-3"></i>Selected Medical Test
                    </h2>
                </div>
                <div class="p-8">
                    <?php $test = $appointment->medicalTest; ?>
                    <div class="bg-emerald-50 rounded-xl p-6 border-l-4 border-emerald-600">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-emerald-900 mb-2"><?php echo e($test->name); ?></h3>
                                <?php if($test->description): ?>
                                    <p class="text-emerald-700 mb-3"><?php echo e($test->description); ?></p>
                                <?php endif; ?>
                                <?php if($test->category): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-600 text-white">
                                        <i class="fas fa-tag mr-1"></i>
                                        <?php echo e($test->category->name); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-500 text-white">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        No category
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="text-right ml-6">
                                <p class="text-3xl font-bold text-emerald-600">₱<?php echo e(number_format($test->price, 2)); ?></p>
                                <p class="text-sm text-emerald-700">Test Price</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Notes Card -->
            <?php if($appointment->notes): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-amber-600 to-amber-700 border-l-4 border-amber-800">
                    <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-sticky-note mr-3"></i>Additional Notes
                    </h2>
                </div>
                <div class="p-8">
                    <div class="bg-amber-50 rounded-xl p-6 border-l-4 border-amber-600">
                        <p class="text-amber-900 whitespace-pre-wrap text-lg leading-relaxed"><?php echo e($appointment->notes); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Patients Card -->
            <?php if($appointment->patients && $appointment->patients->count() > 0): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-indigo-700 border-l-4 border-indigo-800">
                    <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-users mr-3"></i>Registered Patients
                    </h2>
                    <p class="text-indigo-100 mt-1"><?php echo e($appointment->patients->count()); ?> patient(s) registered</p>
                </div>
                <div class="p-8">
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        <?php $__currentLoopData = $appointment->patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-indigo-50 rounded-xl p-4 border-l-4 border-indigo-600">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-indigo-900"><?php echo e($patient->full_name); ?></h3>
                                    <p class="text-indigo-700 mt-1"><?php echo e($patient->age_sex); ?></p>
                                    <?php if($patient->email): ?>
                                        <p class="text-indigo-600 mt-2 flex items-center">
                                            <i class="fas fa-envelope mr-2"></i><?php echo e($patient->email); ?>

                                        </p>
                                    <?php endif; ?>
                                    <?php if($patient->phone): ?>
                                        <p class="text-indigo-600 mt-1 flex items-center">
                                            <i class="fas fa-phone mr-2"></i><?php echo e($patient->phone); ?>

                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- File Upload Card -->
            <?php if($appointment->excel_file_path): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-green-600 to-green-700 border-l-4 border-green-800">
                    <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-file-excel mr-3"></i>Uploaded File
                    </h2>
                </div>
                <div class="p-8">
                    <div class="bg-green-50 rounded-xl p-6 border-l-4 border-green-600">
                        <div class="flex items-center">
                            <i class="fas fa-file-excel text-green-600 text-3xl mr-4"></i>
                            <div class="flex-1">
                                <p class="text-lg font-bold text-green-900"><?php echo e(basename($appointment->excel_file_path)); ?></p>
                                <p class="text-green-700">Excel file uploaded successfully</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Appointment Summary Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-purple-600 to-purple-700 border-l-4 border-purple-800">
                    <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-chart-bar mr-3"></i>Appointment Summary
                    </h2>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-600">
                            <p class="text-blue-700 text-sm font-medium">Total Patients</p>
                            <p class="text-2xl font-bold text-blue-900"><?php echo e($appointment->patients->count()); ?></p>
                        </div>
                        <div class="bg-emerald-50 rounded-lg p-4 border-l-4 border-emerald-600">
                            <p class="text-emerald-700 text-sm font-medium">Medical Tests</p>
                            <p class="text-2xl font-bold text-emerald-900"><?php echo e($appointment->medical_test_id ? 1 : 0); ?></p>
                        </div>
                        <?php if($appointment->medicalTest): ?>
                        <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-600 col-span-2">
                            <p class="text-green-700 text-sm font-medium">Total Price Calculation</p>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-sm text-green-700">
                                    <span>Test Price per Patient:</span>
                                    <span class="font-semibold">₱<?php echo e(number_format($appointment->medicalTest->price, 2)); ?></span>
                                </div>
                                <div class="flex items-center justify-between text-sm text-green-700">
                                    <span>Number of Patients:</span>
                                    <span class="font-semibold"><?php echo e($appointment->patient_count); ?></span>
                                </div>
                                <hr class="border-green-300">
                                <div class="flex items-center justify-between">
                                    <span class="text-green-700 font-medium">Total Amount:</span>
                                    <span class="text-3xl font-bold text-green-900"><?php echo e($appointment->formatted_total_price); ?></span>
                                </div>
                                <?php if($appointment->patient_count > 0): ?>
                                <p class="text-xs text-green-600 mt-1">
                                    (₱<?php echo e(number_format($appointment->medicalTest->price, 2)); ?> × <?php echo e($appointment->patient_count); ?> patients)
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-gray-600 col-span-2">
                            <p class="text-gray-700 text-sm font-medium">Created Date</p>
                            <p class="text-xl font-bold text-gray-900"><?php echo e($appointment->created_at->format('M d, Y')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.company', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/company/appointments/show.blade.php ENDPATH**/ ?>