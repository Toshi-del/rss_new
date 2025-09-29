<?php $__env->startSection('title', 'Annual Physical Examinations - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'Annual Physical Examinations'); ?>
<?php $__env->startSection('page-description', 'Manage and monitor annual physical examination patients'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    
    <!-- Success Message -->
    <?php if(session('success')): ?>
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="px-8 py-4 bg-green-600">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
                <span class="text-white font-medium"><?php echo e(session('success')); ?></span>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
        <div class="px-8 py-6 bg-purple-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center border border-white border-opacity-30">
                        <i class="fas fa-file-medical text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white mb-1">Annual Physical Examinations</h1>
                        <p class="text-purple-100 text-sm">Comprehensive health examinations and patient management</p>
                    </div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl px-6 py-4 border border-white border-opacity-30">
                    <p class="text-purple-100 text-sm font-medium">Total Patients</p>
                    <p class="text-white text-2xl font-bold"><?php echo e($patients->count()); ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Patients Section -->
    <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
        <div class="px-8 py-6 bg-purple-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center border border-white border-opacity-30">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Patient Management</h2>
                        <p class="text-purple-100 text-sm">Annual physical examination patients and their status</p>
                    </div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2 border border-white border-opacity-30">
                    <p class="text-purple-100 text-xs font-medium">Active Patients</p>
                    <p class="text-white text-lg font-bold"><?php echo e($patients->count()); ?></p>
                </div>
            </div>
        </div>
        
        <?php if($patients->count() > 0): ?>
        <div class="p-8">
            <div class="space-y-6">
                <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $canSend = $canSendByPatientId[$patient->id] ?? false; ?>
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-200">
                    <!-- Patient Header -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <?php
                                $initials = strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1));
                                $colors = ['bg-purple-500', 'bg-blue-500', 'bg-indigo-500', 'bg-pink-500', 'bg-red-500'];
                                $colorIndex = crc32($patient->id) % count($colors);
                            ?>
                            <div class="w-14 h-14 <?php echo e($colors[$colorIndex]); ?> rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-lg"><?php echo e($initials); ?></span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900"><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></h3>
                                <p class="text-gray-500 text-sm"><?php echo e($patient->age); ?> years, <?php echo e($patient->sex); ?></p>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <i class="fas fa-file-medical mr-1"></i>Annual Physical
                            </span>
                            <?php if($canSend): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>Ready to Submit
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>In Progress
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Medical Information -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-stethoscope text-purple-600 mr-2"></i>
                            <span class="text-sm font-medium text-purple-800">Medical Test Information</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-900 mb-1">
                            <?php echo e(optional($patient->appointment->medicalTestCategory)->name ?? 'Not Assigned'); ?>

                        </p>
                        <?php if(optional($patient->appointment)->medicalTest): ?>
                            <p class="text-xs text-gray-600">
                                Specific Test: <?php echo e($patient->appointment->medicalTest->name); ?>

                            </p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between space-x-3 mb-4">
                        <!-- Send to Admin -->
                        <form action="<?php echo e(route('doctor.annual-physical.by-patient.submit', $patient->id)); ?>" method="POST" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <button type="submit" 
                                    class="w-full px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center justify-center <?php echo e($canSend ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed'); ?>" 
                                    title="Send to Admin" 
                                    <?php echo e($canSend ? '' : 'disabled'); ?>>
                                <i class="fas fa-paper-plane mr-2"></i>
                                Submit to Admin
                            </button>
                        </form>
                        
                        <!-- Update Results -->
                        <a href="<?php echo e(route('doctor.annual-physical.by-patient.edit', $patient->id)); ?>" 
                           class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all duration-200 text-sm font-medium flex items-center justify-center" 
                           title="Update Results">
                            <i class="fas fa-edit mr-2"></i>
                            Update Results
                        </a>
                        
                        <!-- Medical Checklist -->
                        <a href="<?php echo e(route('doctor.medical-checklist.annual-physical', $patient->id)); ?>" 
                           class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 text-sm font-medium flex items-center justify-center" 
                           title="Medical Checklist">
                            <i class="fas fa-clipboard-list mr-2"></i>
                            Checklist
                        </a>
                    </div>
                    
                    <!-- Patient Status Footer -->
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                <span>Last Updated: <?php echo e($patient->updated_at->format('M d, Y')); ?></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <?php if($canSend): ?>
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-green-600 font-medium text-sm">Complete</span>
                                <?php else: ?>
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                    <span class="text-yellow-600 font-medium text-sm">In Progress</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <!-- Pagination if needed -->
            <?php if(method_exists($patients, 'links')): ?>
            <div class="mt-8">
                <?php echo e($patients->links()); ?>

            </div>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <!-- Empty State -->
        <div class="p-16 text-center">
            <div class="w-24 h-24 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-file-medical text-purple-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Annual Physical Patients</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">No annual physical examination patients found. Patients will appear here when they schedule appointments.</p>
            <div class="flex justify-center">
                <a href="<?php echo e(route('doctor.dashboard')); ?>" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.doctor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/doctor/annual-physical.blade.php ENDPATH**/ ?>