<?php $__env->startSection('title', 'Pre-Employment X-Ray - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'Pre-Employment X-Ray'); ?>
<?php $__env->startSection('page-description', 'X-Ray services for pre-employment medical examinations'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Header Section -->
    <div class="content-card rounded-xl shadow-xl border-2 border-gray-200">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-briefcase text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Pre-Employment X-Ray Services</h2>
                        <p class="text-blue-100 text-sm">X-Ray examinations for pre-employment medical records</p>
                    </div>
                </div>
                <div class="px-4 py-2 bg-white/10 text-white rounded-lg backdrop-blur-sm border border-white/20 font-medium">
                    <i class="fas fa-x-ray mr-2"></i><?php echo e($preEmployments->count()); ?> Records
                </div>
            </div>
        </div>
    </div>

    <!-- X-Ray Status Tabs -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <?php
            $currentTab = request('xray_status', 'needs_attention');
        ?>
        
        <!-- Tab Navigation -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex space-x-1">
                    <a href="<?php echo e(request()->fullUrlWithQuery(['xray_status' => 'needs_attention'])); ?>" 
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 <?php echo e($currentTab === 'needs_attention' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50'); ?>">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Needs Attention
                        <?php
                            $needsAttentionCount = \App\Models\PreEmploymentRecord::where('status', 'approved')
                                ->where(function($query) {
                                    // Check medical test relationships OR other_exams column for X-ray services
                                    $query->whereHas('medicalTest', function($q) {
                                        $q->where(function($subQ) {
                                            $subQ->where('name', 'like', '%Pre-Employment%')
                                                 ->orWhere('name', 'like', '%X-ray%')
                                                 ->orWhere('name', 'like', '%Chest%')
                                                 ->orWhere('name', 'like', '%Radiology%');
                                        });
                                    })->orWhereHas('medicalTests', function($q) {
                                        $q->where(function($subQ) {
                                            $subQ->where('name', 'like', '%Pre-Employment%')
                                                 ->orWhere('name', 'like', '%X-ray%')
                                                 ->orWhere('name', 'like', '%Chest%')
                                                 ->orWhere('name', 'like', '%Radiology%');
                                        });
                                    })->orWhere(function($q) {
                                        // Also check other_exams column for X-ray services
                                        $q->where('other_exams', 'like', '%Pre-Employment%')
                                          ->orWhere('other_exams', 'like', '%X-ray%')
                                          ->orWhere('other_exams', 'like', '%Chest%')
                                          ->orWhere('other_exams', 'like', '%Radiology%');
                                    });
                                })
                                ->whereDoesntHave('medicalChecklist', function($q) {
                                    $q->whereNotNull('chest_xray_done_by');
                                })
                                ->count();
                        ?>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full <?php echo e($currentTab === 'needs_attention' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600'); ?>">
                            <?php echo e($needsAttentionCount); ?>

                        </span>
                    </a>
                    
                    <a href="<?php echo e(request()->fullUrlWithQuery(['xray_status' => 'xray_completed'])); ?>" 
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 <?php echo e($currentTab === 'xray_completed' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50'); ?>">
                        <i class="fas fa-check-circle mr-2"></i>
                        X-Ray Completed
                        <?php
                            $completedCount = \App\Models\PreEmploymentRecord::where('status', 'approved')
                                ->where(function($query) {
                                    // Check medical test relationships OR other_exams column for X-ray services
                                    $query->whereHas('medicalTest', function($q) {
                                        $q->where(function($subQ) {
                                            $subQ->where('name', 'like', '%Pre-Employment%')
                                                 ->orWhere('name', 'like', '%X-ray%')
                                                 ->orWhere('name', 'like', '%Chest%')
                                                 ->orWhere('name', 'like', '%Radiology%');
                                        });
                                    })->orWhereHas('medicalTests', function($q) {
                                        $q->where(function($subQ) {
                                            $subQ->where('name', 'like', '%Pre-Employment%')
                                                 ->orWhere('name', 'like', '%X-ray%')
                                                 ->orWhere('name', 'like', '%Chest%')
                                                 ->orWhere('name', 'like', '%Radiology%');
                                        });
                                    })->orWhere(function($q) {
                                        // Also check other_exams column for X-ray services
                                        $q->where('other_exams', 'like', '%Pre-Employment%')
                                          ->orWhere('other_exams', 'like', '%X-ray%')
                                          ->orWhere('other_exams', 'like', '%Chest%')
                                          ->orWhere('other_exams', 'like', '%Radiology%');
                                    });
                                })
                                ->whereHas('medicalChecklist', function($q) {
                                    $q->whereNotNull('chest_xray_done_by')
                                      ->where('chest_xray_done_by', '!=', '');
                                })
                                ->count();
                        ?>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full <?php echo e($currentTab === 'xray_completed' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600'); ?>">
                            <?php echo e($completedCount); ?>

                        </span>
                    </a>
                </div>
                
                <a href="<?php echo e(route('radtech.pre-employment-xray')); ?>" class="text-sm text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-times mr-1"></i>Clear All Filters
                </a>
            </div>
        </div>

        <!-- Additional Filters -->
        <div class="p-6">
            <form method="GET" action="<?php echo e(route('radtech.pre-employment-xray')); ?>" class="space-y-6">
                <!-- Preserve current tab -->
                <input type="hidden" name="xray_status" value="<?php echo e($currentTab); ?>">
                
                <!-- Preserve search query -->
                <?php if(request('search')): ?>
                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <?php endif; ?>
                
                <!-- Filter Row: Company and Gender -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Company Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                        <select name="company" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">All Companies</option>
                            <?php
                                $companies = $preEmployments->pluck('company_name')->filter()->unique()->sort()->values();
                            ?>
                            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($company); ?>" <?php echo e(request('company') === $company ? 'selected' : ''); ?>>
                                    <?php echo e($company); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Gender Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">All Genders</option>
                            <option value="male" <?php echo e(request('gender') === 'male' ? 'selected' : ''); ?>>Male</option>
                            <option value="female" <?php echo e(request('gender') === 'female' ? 'selected' : ''); ?>>Female</option>
                        </select>
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>Apply Filters
                        </button>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['company' => null, 'gender' => null, 'search' => null])); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-undo mr-2"></i>Reset Filters
                        </a>
                    </div>
                    
                    <!-- Active Filters Display -->
                    <?php if(request()->hasAny(['company', 'gender', 'search'])): ?>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Active filters:</span>
                            <?php if(request('search')): ?>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                    Search: "<?php echo e(request('search')); ?>"
                                    <a href="<?php echo e(request()->fullUrlWithQuery(['search' => null])); ?>" class="ml-1 text-blue-600 hover:text-blue-800">×</a>
                                </span>
                            <?php endif; ?>
                            <?php if(request('company')): ?>
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                    Company: <?php echo e(request('company')); ?>

                                    <a href="<?php echo e(request()->fullUrlWithQuery(['company' => null])); ?>" class="ml-1 text-green-600 hover:text-green-800">×</a>
                                </span>
                            <?php endif; ?>
                            <?php if(request('gender')): ?>
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">
                                    Gender: <?php echo e(ucfirst(request('gender'))); ?>

                                    <a href="<?php echo e(request()->fullUrlWithQuery(['gender' => null])); ?>" class="ml-1 text-purple-600 hover:text-purple-800">×</a>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Pre-Employment Records Section -->
    <div class="content-card rounded-xl shadow-xl border-2 border-gray-200">
        <div class="p-0">
            <?php if($preEmployments->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Applicant</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Medical Test</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Age & Gender</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php $__currentLoopData = $preEmployments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preEmployment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-blue-600 font-semibold text-sm">
                                                    <?php echo e(substr($preEmployment->first_name, 0, 1)); ?><?php echo e(substr($preEmployment->last_name, 0, 1)); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900"><?php echo e($preEmployment->first_name); ?> <?php echo e($preEmployment->last_name); ?></p>
                                                <p class="text-xs text-gray-500">Record ID: #<?php echo e($preEmployment->id); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm text-gray-900 font-medium"><?php echo e($preEmployment->company_name); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo e($preEmployment->position ?? 'N/A'); ?></p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php if($preEmployment->medicalTestCategory): ?>
                                                <span class="font-medium"><?php echo e($preEmployment->medicalTestCategory->name); ?></span>
                                                <?php if($preEmployment->medicalTest): ?>
                                                    <p class="text-xs text-gray-500"><?php echo e($preEmployment->medicalTest->name); ?></p>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-gray-500"><?php echo e($preEmployment->medical_exam_type ?? 'Standard Exam'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium"><?php echo e($preEmployment->age ?? 'N/A'); ?> years old</p>
                                            <p class="text-xs text-gray-500"><?php echo e($preEmployment->sex ?? 'Not specified'); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                            $statusClass = match($preEmployment->status) {
                                                'approved' => 'bg-green-100 text-green-800',
                                                'declined' => 'bg-red-100 text-red-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        ?>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full <?php echo e($statusClass); ?>">
                                            <i class="fas fa-check-circle mr-1"></i><?php echo e(ucfirst($preEmployment->status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="<?php echo e(route('radtech.medical-checklist.pre-employment', $preEmployment->id)); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium inline-flex items-center">
                                            <i class="fas fa-x-ray mr-2"></i>Medical Checklist
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-briefcase text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Pre-Employment Records</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no pre-employment records requiring X-ray. New records will appear here once approved.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Records</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($preEmployments->count()); ?></p>
                </div>
            </div>
        </div>

        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Approved</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($preEmployments->where('status', 'approved')->count()); ?></p>
                </div>
            </div>
        </div>

        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-x-ray text-cyan-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">X-Ray Required</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($preEmployments->count()); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .content-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .content-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.radtech', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/radtech/pre-employment-xray.blade.php ENDPATH**/ ?>