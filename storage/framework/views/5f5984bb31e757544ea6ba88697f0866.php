<?php $__env->startSection('title', 'Pathologist Dashboard'); ?>
<?php $__env->startSection('page-title', 'Laboratory Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Success/Error Messages -->
<?php if(session('success')): ?>
<div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 flex items-center space-x-3">
    <div class="flex-shrink-0">
        <i class="fas fa-check-circle text-green-600 text-xl"></i>
    </div>
    <div>
        <p class="text-green-800 font-medium"><?php echo e(session('success')); ?></p>
    </div>
    <button onclick="this.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800">
        <i class="fas fa-times"></i>
    </button>
</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 flex items-center space-x-3">
    <div class="flex-shrink-0">
        <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
    </div>
    <div>
        <p class="text-red-800 font-medium"><?php echo e(session('error')); ?></p>
    </div>
    <button onclick="this.parentElement.remove()" class="ml-auto text-red-600 hover:text-red-800">
        <i class="fas fa-times"></i>
    </button>
</div>
<?php endif; ?>

<!-- Welcome Section -->
<div class="content-card welcome-gradient rounded-2xl p-8 mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl flex items-center justify-center">
                <i class="fas fa-microscope text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold mb-2 text-white">Welcome back, Dr. <?php echo e(Auth::user()->fname); ?>!</h1>
                <p class="text-white/90 text-lg">Here's what's happening in your laboratory today.</p>
            </div>
        </div>
        <div class="text-right bg-white/10 rounded-2xl p-4">
            <p class="text-2xl font-bold text-white"><?php echo e(now()->format('M d, Y')); ?></p>
            <p class="text-white/80"><?php echo e(now()->format('l')); ?></p>
        </div>
    </div>
</div>

<!-- Laboratory Metrics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Patients -->
    <div class="content-card rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border-l-4 border-teal-500">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-teal-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-users text-teal-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900"><?php echo e($metrics['total_patients']); ?></h3>
                <p class="text-sm text-gray-600">Total Patients</p>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <i class="fas fa-arrow-up mr-1"></i>
            <span>+12% from last month</span>
        </div>
    </div>

    <!-- Pre-Employment Records -->
    <div class="content-card rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border-l-4 border-orange-500">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-briefcase text-orange-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900"><?php echo e($metrics['total_pre_employment']); ?></h3>
                <p class="text-sm text-gray-600">Pre-Employment</p>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <i class="fas fa-arrow-up mr-1"></i>
            <span>+8% from last month</span>
        </div>
    </div>

    <!-- Pending Lab Requests -->
    <div class="content-card rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border-l-4 border-yellow-500">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-flask text-yellow-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900"><?php echo e($metrics['pending_lab_requests']); ?></h3>
                <p class="text-sm text-gray-600">Pending Requests</p>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-yellow-600">
            <i class="fas fa-clock mr-1"></i>
            <span>Awaiting processing</span>
        </div>
    </div>

    <!-- Completed Today -->
    <div class="content-card rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border-l-4 border-green-500">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-check-double text-green-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900"><?php echo e($metrics['completed_today']); ?></h3>
                <p class="text-sm text-gray-600">Completed Today</p>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <i class="fas fa-check-circle mr-1"></i>
            <span>Lab results ready</span>
        </div>
    </div>
</div>

<!-- Laboratory Analytics -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Lab Performance -->
    <div class="content-card rounded-2xl p-6">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-line text-teal-600 text-lg"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Lab Performance</h3>
        </div>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-vial text-yellow-600"></i>
                    <span class="text-sm font-medium text-gray-800">Samples in Process</span>
                </div>
                <span class="text-lg font-bold text-yellow-600"><?php echo e($metrics['blood_samples_in_process']); ?></span>
            </div>
            <div class="flex items-center justify-between p-3 bg-purple-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-clipboard-check text-purple-600"></i>
                    <span class="text-sm font-medium text-gray-800">Results to Review</span>
                </div>
                <span class="text-lg font-bold text-purple-600"><?php echo e($metrics['results_to_review']); ?></span>
            </div>
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span class="text-sm font-medium text-gray-800">Monthly Completed</span>
                </div>
                <span class="text-lg font-bold text-green-600"><?php echo e($metrics['monthly_completed']); ?></span>
            </div>
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-clock text-blue-600"></i>
                    <span class="text-sm font-medium text-gray-800">Avg. Processing Time</span>
                </div>
                <span class="text-lg font-bold text-blue-600"><?php echo e($metrics['average_processing_time']); ?>h</span>
            </div>
        </div>
    </div>

    <!-- Blood Chemistry Tests -->
    <div class="content-card rounded-2xl p-6">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-flask text-red-600 text-lg"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Blood Chemistry Tests</h3>
        </div>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $bloodChemistryTests->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                    <div>
                        <p class="font-semibold text-gray-900"><?php echo e($test->name); ?></p>
                        <?php if($test->normal_range): ?>
                            <p class="text-xs text-gray-500"><?php echo e($test->normal_range); ?></p>
                        <?php endif; ?>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full <?php echo e($test->is_active ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-800 border border-gray-200'); ?>">
                        <?php echo e($test->is_active ? 'Active' : 'Inactive'); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-flask text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">No blood chemistry tests available</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pending Tasks -->
    <div class="content-card rounded-2xl p-6">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-tasks text-orange-600 text-lg"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Pending Tasks</h3>
        </div>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition-colors duration-200">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-file-medical text-emerald-600"></i>
                    <span class="text-sm font-semibold text-gray-800">Annual Physical</span>
                </div>
                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full border border-emerald-200">
                    <?php echo e($pendingTasks['pending_annual_physical']); ?>

                </span>
            </div>
            <div class="flex items-center justify-between p-3 bg-orange-50 rounded-xl hover:bg-orange-100 transition-colors duration-200">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-briefcase text-orange-600"></i>
                    <span class="text-sm font-semibold text-gray-800">Pre-Employment</span>
                </div>
                <span class="bg-orange-100 text-orange-800 text-xs font-bold px-3 py-1 rounded-full border border-orange-200">
                    <?php echo e($pendingTasks['pending_pre_employment']); ?>

                </span>
            </div>
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-colors duration-200">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-flask text-yellow-600"></i>
                    <span class="text-sm font-semibold text-gray-800">Lab Requests</span>
                </div>
                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full border border-yellow-200">
                    <?php echo e($pendingTasks['pending_lab_requests']); ?>

                </span>
            </div>
            <div class="flex items-center justify-between p-3 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors duration-200">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-clipboard-check text-purple-600"></i>
                    <span class="text-sm font-semibold text-gray-800">Results Review</span>
                </div>
                <span class="bg-purple-100 text-purple-800 text-xs font-bold px-3 py-1 rounded-full border border-purple-200">
                    <?php echo e($pendingTasks['results_to_review']); ?>

                </span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Laboratory Activities -->
<div class="content-card rounded-2xl mb-8 overflow-hidden">
    <div class="welcome-gradient px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-history text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Recent Laboratory Activities</h2>
                    <p class="text-white/90 text-sm">Latest updates and completed tasks</p>
                </div>
            </div>
            <a href="#" class="text-white/90 hover:text-white text-sm font-semibold bg-white/10 hover:bg-white/20 px-3 py-1 rounded-lg transition-colors duration-200">
                View All
            </a>
        </div>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                    <div class="w-12 h-12 bg-<?php echo e($activity['color']); ?>-100 rounded-xl flex items-center justify-center">
                        <i class="<?php echo e($activity['icon']); ?> text-<?php echo e($activity['color']); ?>-600 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900"><?php echo e($activity['title']); ?></h4>
                        <p class="text-sm text-gray-600"><?php echo e($activity['description']); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-700"><?php echo e($activity['time']->diffForHumans()); ?></p>
                        <p class="text-xs text-gray-500"><?php echo e($activity['time']->format('M d, h:i A')); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-history text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">No recent activities</p>
                    <p class="text-gray-400 text-sm">Laboratory activities will appear here when available</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="<?php echo e(route('pathologist.annual-physical')); ?>" class="content-card rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border border-gray-200 hover:border-emerald-300 group">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center group-hover:bg-emerald-200 transition-colors duration-200">
                <i class="fas fa-file-medical text-emerald-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 group-hover:text-emerald-700 transition-colors duration-200">Annual Physical</h3>
                <p class="text-sm text-gray-600">Review and manage patient examinations</p>
            </div>
        </div>
    </a>

    <a href="<?php echo e(route('pathologist.pre-employment')); ?>" class="content-card rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border border-gray-200 hover:border-orange-300 group">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center group-hover:bg-orange-200 transition-colors duration-200">
                <i class="fas fa-briefcase text-orange-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 group-hover:text-orange-700 transition-colors duration-200">Pre-Employment</h3>
                <p class="text-sm text-gray-600">Process employment medical records</p>
            </div>
        </div>
    </a>

    <a href="<?php echo e(route('pathologist.medical-checklist')); ?>" class="content-card rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border border-gray-200 hover:border-purple-300 group">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center group-hover:bg-purple-200 transition-colors duration-200">
                <i class="fas fa-clipboard-list text-purple-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 group-hover:text-purple-700 transition-colors duration-200">Medical Checklist</h3>
                <p class="text-sm text-gray-600">Create and manage medical checklists</p>
            </div>
        </div>
    </a>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Enhanced dashboard functionality
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh dashboard data every 5 minutes
    setInterval(function() {
        // You can implement AJAX refresh here if needed
        console.log('Pathologist dashboard data refresh...');
    }, 300000);

    // Add enhanced hover effects for metric cards (removed transforms)
    document.querySelectorAll('.content-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.boxShadow = '';
        });
    });

    // Add click feedback for interactive elements (removed transforms)
    document.querySelectorAll('a.content-card').forEach(link => {
        link.addEventListener('click', function(e) {
            // Add visual feedback without transforms
            this.style.opacity = '0.9';
            setTimeout(() => {
                this.style.opacity = '';
            }, 150);
        });
    });

    // Add smooth animations for pending task items (removed transforms)
    document.querySelectorAll('[class*="bg-"][class*="-50"]').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.backgroundColor = this.style.backgroundColor || this.classList.contains('bg-emerald-50') ? '#d1fae5' : 
                                        this.classList.contains('bg-orange-50') ? '#fff7ed' :
                                        this.classList.contains('bg-yellow-50') ? '#fefce8' :
                                        this.classList.contains('bg-purple-50') ? '#faf5ff' : '';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });

    console.log('Pathologist dashboard initialized with enhanced interactions');
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pathologist', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/pathologist/dashboard.blade.php ENDPATH**/ ?>