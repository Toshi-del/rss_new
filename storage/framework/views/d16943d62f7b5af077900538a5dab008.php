<?php $__env->startSection('title', 'Pre-Employment Files'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-user-tie mr-3"></i>Pre-Employment Files
                        </h1>
                        <p class="text-blue-100">Manage pre-employment medical records and examinations</p>
                    </div>
                    <div>
                        <a href="<?php echo e(route('company.pre-employment.create')); ?>" 
                           class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-lg text-sm font-bold hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 transition-all duration-200 shadow-sm">
                            <i class="fas fa-plus mr-2"></i>
                            New Pre-Employment File
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <?php if(session('success')): ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-emerald-600 to-emerald-700">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-white text-xl mr-3"></i>
                    <span class="text-white font-medium"><?php echo e(session('success')); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Pre-Employment Records -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-indigo-700 border-l-4 border-indigo-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-list mr-3"></i>Pre-Employment Records
                </h2>
                <p class="text-indigo-100 mt-1"><?php echo e(isset($files) ? $files->count() : 0); ?> record(s) found</p>
            </div>
            
            <div class="p-8">
                <?php $__empty_1 = true; $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="mb-6 last:mb-0 bg-gray-50 rounded-xl p-6 border-l-4 border-blue-600 hover:shadow-md transition-shadow duration-200">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        
                        <!-- Personal Information -->
                        <div class="lg:col-span-1">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-white font-bold text-lg">
                                        <?php echo e(strtoupper(substr($file->first_name, 0, 1) . substr($file->last_name, 0, 1))); ?>

                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900"><?php echo e($file->full_name); ?></h3>
                                    <p class="text-sm text-gray-600"><?php echo e($file->age); ?> years old • <?php echo e($file->sex); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="lg:col-span-1">
                            <div class="space-y-2">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-envelope text-blue-600 w-4 mr-2"></i>
                                    <span class="text-gray-900"><?php echo e($file->email); ?></span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-phone text-green-600 w-4 mr-2"></i>
                                    <span class="text-gray-900"><?php echo e($file->phone_number); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Medical Tests & Billing Information -->
                        <div class="lg:col-span-1">
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Medical Tests</p>
                                    <?php
                                        $allTests = $file->all_selected_tests;
                                    ?>
                                    <?php if($allTests->count() > 0): ?>
                                        <div class="space-y-1">
                                            <?php $__currentLoopData = $allTests->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="flex items-center">
                                                    <span class="text-sm font-semibold text-gray-900"><?php echo e($test['test_name']); ?></span>
                                                    <?php if($test['is_primary']): ?>
                                                        <span class="ml-1 inline-flex items-center px-1 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                            <i class="fas fa-star mr-1"></i>Primary
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="text-xs text-gray-600"><?php echo e($test['category_name']); ?> • ₱<?php echo e(number_format($test['price'], 2)); ?></p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($allTests->count() > 2): ?>
                                                <p class="text-xs text-blue-600 font-medium">+<?php echo e($allTests->count() - 2); ?> more test(s)</p>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-sm text-gray-500">No tests selected</p>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Billing</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        <?php echo e($file->billing_type === 'Company' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800'); ?>">
                                        <?php echo e($file->billing_type); ?>

                                    </span>
                                    <?php if($file->company_name): ?>
                                        <p class="text-xs text-gray-600 mt-1"><?php echo e($file->company_name); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Summary & Actions -->
                        <div class="lg:col-span-1">
                            <div class="flex flex-col items-end justify-between h-full">
                                <!-- Summary -->
                                <div class="text-right mb-4">
                                    <div class="bg-green-50 rounded-lg p-3 border-l-4 border-green-600">
                                        <?php
                                            $pricePerPatient = $allTests->sum('price');
                                            $totalPrice = $file->total_price ?? 0;
                                            $patientCount = $pricePerPatient > 0 ? round($totalPrice / $pricePerPatient) : 1;
                                        ?>
                                        <p class="text-xs font-medium text-green-700 uppercase tracking-wider mb-1">Price Per Patient</p>
                                        <p class="text-lg font-bold text-green-900">₱<?php echo e(number_format($pricePerPatient, 2)); ?></p>
                                        <p class="text-xs text-green-600 mt-1"><?php echo e($patientCount); ?> patient(s)</p>
                                    </div>
                                    <div class="bg-emerald-50 rounded-lg p-3 border-l-4 border-emerald-600 mt-3">
                                        <p class="text-xs font-medium text-emerald-700 uppercase tracking-wider mb-1">Total Price</p>
                                        <p class="text-xl font-bold text-emerald-900">₱<?php echo e(number_format($totalPrice, 2)); ?></p>
                                        <?php if($allTests->count() > 1): ?>
                                            <p class="text-xs text-emerald-600 mt-1"><?php echo e($allTests->count()); ?> tests selected</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div>
                                    <a href="<?php echo e(route('company.pre-employment.show', $file)); ?>" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                        <i class="fas fa-eye mr-2"></i>
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-tie text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No pre-employment records found</h3>
                    <p class="text-gray-600 mb-6">Get started by creating your first pre-employment record.</p>
                    <a href="<?php echo e(route('company.pre-employment.create')); ?>" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Create First Record
                    </a>
                </div>
                <?php endif; ?>

                <!-- Pagination -->
                <?php if(isset($files) && $files instanceof \Illuminate\Pagination\LengthAwarePaginator && $files->hasPages()): ?>
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <?php echo e($files->links()); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.company', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/company/pre-employment/index.blade.php ENDPATH**/ ?>