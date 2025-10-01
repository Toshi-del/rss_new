<?php $__env->startSection('title', 'Annual Physical X-Ray - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'Annual Physical X-Ray'); ?>
<?php $__env->startSection('page-description', 'X-Ray services for annual physical medical examinations'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Header Section -->
    <div class="content-card rounded-xl shadow-xl border-2 border-gray-200">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-user-md text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Annual Physical X-Ray Services</h2>
                        <p class="text-emerald-100 text-sm">X-Ray examinations for annual physical medical records</p>
                    </div>
                </div>
                <div class="px-4 py-2 bg-white/10 text-white rounded-lg backdrop-blur-sm border border-white/20 font-medium">
                    <i class="fas fa-x-ray mr-2"></i><?php echo e($patients->count()); ?> Patients
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
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 <?php echo e($currentTab === 'needs_attention' ? 'bg-emerald-600 text-white' : 'text-gray-600 hover:text-emerald-600 hover:bg-emerald-50'); ?>">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Needs Attention
                        <?php
                            $needsAttentionCount = \App\Models\Patient::where('status', 'approved')
                                ->whereDoesntHave('medicalChecklists', function($q) {
                                    $q->where('examination_type', 'annual-physical')
                                      ->whereNotNull('chest_xray_done_by')
                                      ->where('chest_xray_done_by', '!=', '');
                                })
                                ->count();
                        ?>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full <?php echo e($currentTab === 'needs_attention' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600'); ?>">
                            <?php echo e($needsAttentionCount); ?>

                        </span>
                    </a>
                    
                    <a href="<?php echo e(request()->fullUrlWithQuery(['xray_status' => 'xray_completed'])); ?>" 
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 <?php echo e($currentTab === 'xray_completed' ? 'bg-emerald-600 text-white' : 'text-gray-600 hover:text-emerald-600 hover:bg-emerald-50'); ?>">
                        <i class="fas fa-check-circle mr-2"></i>
                        X-Ray Completed
                        <?php
                            $completedCount = \App\Models\Patient::where('status', 'approved')
                                ->whereHas('medicalChecklists', function($q) {
                                    $q->where('examination_type', 'annual-physical')
                                      ->whereNotNull('chest_xray_done_by')
                                      ->where('chest_xray_done_by', '!=', '');
                                })
                                ->count();
                        ?>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full <?php echo e($currentTab === 'xray_completed' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600'); ?>">
                            <?php echo e($completedCount); ?>

                        </span>
                    </a>
                </div>
                
                <a href="<?php echo e(route('radtech.annual-physical-xray')); ?>" class="text-sm text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-times mr-1"></i>Clear All Filters
                </a>
            </div>
        </div>

        <!-- Additional Filters -->
        <div class="p-6">
            <form method="GET" action="<?php echo e(route('radtech.annual-physical-xray')); ?>" class="space-y-6">
                <!-- Preserve current tab -->
                <input type="hidden" name="xray_status" value="<?php echo e($currentTab); ?>">
                
                <!-- Preserve search query -->
                <?php if(request('search')): ?>
                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <?php endif; ?>
                
                <!-- Filter Row: Gender only -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Gender Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">All Genders</option>
                            <option value="male" <?php echo e(request('gender') === 'male' ? 'selected' : ''); ?>>Male</option>
                            <option value="female" <?php echo e(request('gender') === 'female' ? 'selected' : ''); ?>>Female</option>
                        </select>
                    </div>

                    <!-- Placeholder -->
                    <div></div>
                </div>

                <!-- Filter Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>Apply Filters
                        </button>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['gender' => null, 'search' => null])); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-undo mr-2"></i>Reset Filters
                        </a>
                    </div>
                    
                    <!-- Active Filters Display -->
                    <?php if(request()->hasAny(['gender', 'search'])): ?>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Active filters:</span>
                            <?php if(request('search')): ?>
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs">
                                    Search: "<?php echo e(request('search')); ?>"
                                    <a href="<?php echo e(request()->fullUrlWithQuery(['search' => null])); ?>" class="ml-1 text-emerald-600 hover:text-emerald-800">×</a>
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

    <!-- Annual Physical Patients Section -->
    <div class="content-card rounded-xl shadow-xl border-2 border-gray-200">
        <div class="p-0">
            <?php if($patients->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Patient</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Age & Gender</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Registration Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                                <span class="text-emerald-600 font-semibold text-sm">
                                                    <?php echo e(substr($patient->first_name, 0, 1)); ?><?php echo e(substr($patient->last_name, 0, 1)); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900"><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></p>
                                                <p class="text-xs text-gray-500">Patient ID: #<?php echo e($patient->id); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm text-gray-900"><?php echo e($patient->email); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo e($patient->phone ?? 'No phone'); ?></p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium"><?php echo e($patient->age ?? 'N/A'); ?> years old</p>
                                            <p class="text-xs text-gray-500"><?php echo e($patient->sex ?? 'Not specified'); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium"><?php echo e($patient->created_at->format('M d, Y')); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo e($patient->created_at->diffForHumans()); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                            $statusClass = match($patient->status) {
                                                'approved' => 'bg-green-100 text-green-800',
                                                'declined' => 'bg-red-100 text-red-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        ?>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full <?php echo e($statusClass); ?>">
                                            <i class="fas fa-check-circle mr-1"></i><?php echo e(ucfirst($patient->status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="<?php echo e(route('radtech.medical-checklist.annual-physical', $patient->id)); ?>" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition-colors duration-200 font-medium inline-flex items-center">
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
                        <i class="fas fa-user-times text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Annual Physical Patients</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no annual physical patients requiring X-ray. New patients will appear here once approved.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="content-card rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-emerald-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Patients</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($patients->count()); ?></p>
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
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($patients->where('status', 'approved')->count()); ?></p>
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
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($patients->count()); ?></p>
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

<?php echo $__env->make('layouts.radtech', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/radtech/annual-physical-xray.blade.php ENDPATH**/ ?>