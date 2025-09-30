<?php $__env->startSection('title', 'Pre-Employment Examinations - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'Pre-Employment Examinations'); ?>
<?php $__env->startSection('page-description', 'Manage and monitor pre-employment medical screenings for job applicants'); ?>

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
        <div class="px-8 py-6 bg-green-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center border border-white border-opacity-30">
                        <i class="fas fa-briefcase text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white mb-1">Pre-Employment Examinations</h1>
                        <p class="text-green-100 text-sm">Medical screenings and health assessments for job applicants</p>
                    </div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl px-6 py-4 border border-white border-opacity-30">
                    <p class="text-green-100 text-sm font-medium">Total Examinations</p>
                    <p class="text-white text-2xl font-bold"><?php echo e($preEmploymentExaminations->count()); ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Applicant Management Section -->
    <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
        <div class="px-8 py-6 bg-green-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center border border-white border-opacity-30">
                        <i class="fas fa-user-tie text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Applicant Management</h2>
                        <p class="text-green-100 text-sm">Pre-employment medical examinations and screening status</p>
                    </div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2 border border-white border-opacity-30">
                    <p class="text-green-100 text-xs font-medium">Ready for Review</p>
                    <p class="text-white text-lg font-bold"><?php echo e($preEmploymentExaminations->count()); ?></p>
                </div>
            </div>
        </div>
        
        
        <?php if($preEmploymentExaminations->count() > 0): ?>
        <div class="p-8">
            <div class="space-y-6">
                <?php $__currentLoopData = $preEmploymentExaminations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    $preEmployment = $examination->preEmploymentRecord;
                    // Fallback to examination data if preEmploymentRecord is null
                    $firstName = $preEmployment->first_name ?? ($examination->name ? explode(' ', $examination->name)[0] : 'Unknown');
                    $lastName = $preEmployment->last_name ?? ($examination->name ? (explode(' ', $examination->name)[1] ?? '') : 'User');
                    $fullName = $preEmployment ? $preEmployment->full_name : $examination->name;
                    $age = $preEmployment->age ?? 'N/A';
                    $sex = $preEmployment->sex ?? 'N/A';
                    $email = $preEmployment->email ?? 'N/A';
                    $companyName = $preEmployment->company_name ?? $examination->company_name ?? 'Unknown Company';
                ?>
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-200">
                    <!-- Applicant Header -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <?php
                                $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                                $colors = ['bg-green-500', 'bg-teal-500', 'bg-blue-500', 'bg-indigo-500', 'bg-cyan-500'];
                                $colorIndex = crc32($examination->id) % count($colors);
                            ?>
                            <div class="w-14 h-14 <?php echo e($colors[$colorIndex]); ?> rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-lg"><?php echo e($initials); ?></span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900"><?php echo e($fullName); ?></h3>
                                <p class="text-gray-500 text-sm"><?php echo e($age); ?> years, <?php echo e($sex); ?></p>
                                <?php if($preEmployment): ?>
                                    <p class="text-xs text-gray-400">Record ID: #<?php echo e($preEmployment->id); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-2">
                            <?php
                                $statusConfig = [
                                    'Pending' => ['bg-yellow-100 text-yellow-800', 'fas fa-clock'],
                                    'Approved' => ['bg-green-100 text-green-800', 'fas fa-check-circle'],
                                    'completed' => ['bg-blue-100 text-blue-800', 'fas fa-clipboard-check'],
                                    'sent_to_company' => ['bg-purple-100 text-purple-800', 'fas fa-paper-plane']
                                ];
                                $config = $statusConfig[$examination->status] ?? ['bg-gray-100 text-gray-800', 'fas fa-question-circle'];
                            ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo e($config[0]); ?>">
                                <i class="<?php echo e($config[1]); ?> mr-1"></i><?php echo e(ucfirst($examination->status)); ?>

                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-user-tie mr-1"></i>Job Applicant
                            </span>
                        </div>
                    </div>
                    
                    <!-- Company Information -->
                    <div class="bg-green-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-building text-green-600 mr-2"></i>
                            <span class="text-sm font-medium text-green-800">Company Information</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-900 mb-1"><?php echo e($companyName); ?></p>
                        <p class="text-xs text-green-600">Employment Medical Screening</p>
                        <?php if($preEmployment && $preEmployment->billing_type): ?>
                            <p class="text-xs text-gray-600 mt-1">Billing: <?php echo e($preEmployment->billing_type); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Patient Information -->
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Email Address</span>
                            <span class="text-sm font-medium text-gray-900 truncate ml-4"><?php echo e($email); ?></span>
                        </div>
                        <?php if($preEmployment && $preEmployment->phone_number): ?>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Phone Number</span>
                                <span class="text-sm font-medium text-gray-900"><?php echo e($preEmployment->phone_number); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if($preEmployment && $preEmployment->medicalTest): ?>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Medical Test</span>
                                <span class="text-sm font-medium text-gray-900"><?php echo e($preEmployment->medicalTest->name); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if($preEmployment && $preEmployment->medicalTestCategory): ?>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-500">Test Category</span>
                                <span class="text-sm font-medium text-gray-900"><?php echo e($preEmployment->medicalTestCategory->name); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Examination Details -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-stethoscope text-blue-600 mr-2"></i>
                            <span class="text-sm font-medium text-blue-800">Medical Examination Details</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">Examination Date:</p>
                                <?php
                                    $examDate = null;
                                    if (!empty($examination->date)) {
                                        try {
                                            $examDate = \Carbon\Carbon::parse($examination->date);
                                        } catch (\Exception $e) {
                                            $examDate = null;
                                        }
                                    }
                                ?>
                                <p class="font-semibold"><?php echo e($examDate ? $examDate->format('M d, Y') : 'Not set'); ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Status:</p>
                                <p class="font-semibold text-green-600"><?php echo e(ucfirst($examination->status)); ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Examination ID:</p>
                                <p class="font-semibold">#<?php echo e($examination->id); ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Created:</p>
                                <p class="font-semibold"><?php echo e($examination->created_at->format('M d, Y')); ?></p>
                            </div>
                        </div>
                        
                        <!-- Physical Examination Results -->
                        <?php if($examination->physical_exam && is_array($examination->physical_exam)): ?>
                        <div class="mt-4">
                            <p class="text-gray-600 text-sm mb-2">Physical Examination Results:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <?php $__currentLoopData = $examination->physical_exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($value && $value !== 'Not available'): ?>
                                    <div class="bg-white rounded px-3 py-2 border border-blue-200">
                                        <span class="text-xs text-gray-600"><?php echo e(ucfirst(str_replace('_', ' ', $key))); ?>:</span>
                                        <span class="text-sm font-medium text-gray-900 ml-2"><?php echo e($value); ?></span>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($examination->findings): ?>
                        <div class="mt-4 pt-3 border-t border-blue-200">
                            <p class="text-gray-600 text-sm">Medical Findings:</p>
                            <p class="text-gray-900 font-medium mt-1"><?php echo e($examination->findings); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <?php if($preEmployment): ?>
                            <!-- Send to Admin -->
                            <form action="<?php echo e(route('doctor.pre-employment.by-record.submit', $preEmployment->id)); ?>" method="POST" class="flex-1 min-w-0">
                                <?php echo csrf_field(); ?>
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm font-medium flex items-center justify-center" 
                                        title="Send to Admin">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Submit to Admin
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <!-- Edit Examination -->
                        <a href="<?php echo e(route('doctor.pre-employment.edit', ['id' => $examination->id])); ?>" 
                           class="flex-1 min-w-0 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 text-sm font-medium flex items-center justify-center" 
                           title="Edit Examination">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Examination
                        </a>
                        
                        <?php if($preEmployment): ?>
                            <!-- Medical Checklist -->
                            <a href="<?php echo e(route('doctor.medical-checklist.pre-employment', $preEmployment->id)); ?>" 
                               class="flex-1 min-w-0 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all duration-200 text-sm font-medium flex items-center justify-center" 
                               title="Medical Checklist">
                                <i class="fas fa-clipboard-list mr-2"></i>
                                Checklist
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Examination Status Footer -->
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-user-nurse text-gray-400 mr-2"></i>
                                <span>Examined by: <?php echo e($examination->user ? ($examination->user->fname . ' ' . $examination->user->lname) : 'Medical Staff'); ?></span>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end space-x-4">
                                <?php if($preEmployment && $preEmployment->total_price): ?>
                                    <div class="text-sm">
                                        <span class="text-gray-500">Total:</span>
                                        <span class="font-semibold text-emerald-600">₱<?php echo e(number_format($preEmployment->total_price, 2)); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="flex items-center space-x-2">
                                    <?php
                                        $statusDot = match($examination->status) {
                                            'Pending' => 'bg-yellow-500',
                                            'Approved' => 'bg-green-500',
                                            'completed' => 'bg-blue-500',
                                            'sent_to_company' => 'bg-purple-500',
                                            default => 'bg-gray-500'
                                        };
                                    ?>
                                    <div class="w-2 h-2 <?php echo e($statusDot); ?> rounded-full"></div>
                                    <span class="text-sm font-medium" style="color: <?php echo e(str_replace('bg-', '', $statusDot) === 'yellow-500' ? '#d97706' : (str_replace('bg-', '', $statusDot) === 'green-500' ? '#059669' : (str_replace('bg-', '', $statusDot) === 'blue-500' ? '#2563eb' : (str_replace('bg-', '', $statusDot) === 'purple-500' ? '#7c3aed' : '#6b7280')))); ?>"><?php echo e(ucfirst($examination->status)); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <!-- Pagination if needed -->
            <?php if(method_exists($preEmploymentExaminations, 'links')): ?>
            <div class="mt-8">
                <?php echo e($preEmploymentExaminations->links()); ?>

            </div>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <!-- Empty State -->
        <div class="p-16 text-center">
            <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-briefcase text-green-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Pre-Employment Applicants</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">No pre-employment examination records found. Applicants will appear here when they register for medical screenings.</p>
            <div class="flex justify-center">
                <a href="<?php echo e(route('doctor.dashboard')); ?>" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.doctor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/doctor/pre-employment.blade.php ENDPATH**/ ?>