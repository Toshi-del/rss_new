<?php $__env->startSection('title', 'View Medical Test Category'); ?>
<?php $__env->startSection('page-title', 'View Medical Test Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-6">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="<?php echo e(route('admin.medical-test-categories.index')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-lg border border-gray-200 transition-all duration-150 shadow-sm">
                    <i class="fas fa-arrow-left mr-2 text-sm"></i>
                    Back to Categories
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900"><?php echo e($category->name); ?></h1>
                    <p class="text-sm text-gray-600 mt-1">Category details and associated medical tests</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="<?php echo e(route('admin.medical-test-categories.edit', $category)); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-all duration-150 shadow-sm">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Category
                </a>
            </div>
        </div>

        <!-- Category Overview Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-cyan-600 px-8 py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-layer-group text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Category Information</h2>
                        <p class="text-cyan-100 text-sm mt-1">Detailed information about this medical test category</p>
                    </div>
                </div>
            </div>

            <!-- Category Details Grid -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Category Name -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tag text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Category Name</p>
                                <p class="text-lg font-bold text-gray-900"><?php echo e($category->name); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-<?php echo e($category->is_active ? 'green' : 'red'); ?>-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-<?php echo e($category->is_active ? 'check-circle' : 'times-circle'); ?> text-<?php echo e($category->is_active ? 'green' : 'red'); ?>-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold <?php echo e($category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <i class="fas fa-circle mr-1.5 text-xs"></i>
                                    <?php echo e($category->is_active ? 'Active' : 'Inactive'); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Tests -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-vial text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Tests</p>
                                <p class="text-lg font-bold text-gray-900"><?php echo e($category->medical_tests_count ?? 0); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Sort Order -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-sort-numeric-up text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Sort Order</p>
                                <p class="text-lg font-bold text-gray-900"><?php echo e($category->sort_order); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Created Date -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-plus text-yellow-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Created Date</p>
                                <p class="text-lg font-bold text-gray-900"><?php echo e($category->created_at->format('M d, Y')); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($category->created_at->format('g:i A')); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-sync-alt text-orange-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Last Updated</p>
                                <p class="text-lg font-bold text-gray-900"><?php echo e($category->updated_at->format('M d, Y')); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($category->updated_at->format('g:i A')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <?php if($category->description): ?>
                <div class="mt-8 p-6 bg-blue-50 rounded-xl border border-blue-100">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-align-left text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-2">Description</h3>
                            <p class="text-gray-700 leading-relaxed"><?php echo e($category->description); ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Medical Tests Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-blue-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-vial text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Medical Tests</h2>
                            <p class="text-blue-100 text-sm mt-1"><?php echo e($category->medical_tests_count ?? 0); ?> tests in this category</p>
                        </div>
                    </div>
                    <a href="<?php echo e(route('medical-tests.create', ['category_id' => $category->id])); ?>" 
                       class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg font-medium transition-all duration-150 border border-white/20">
                        <i class="fas fa-plus mr-2"></i>
                        Add Test
                    </a>
                </div>
            </div>
            
            <?php if($category->medicalTests && $category->medicalTests->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50/50">
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-flask text-gray-500"></i>
                                        <span>Test Name</span>
                                    </div>
                                </th>
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-align-left text-gray-500"></i>
                                        <span>Description</span>
                                    </div>
                                </th>
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-toggle-on text-gray-500"></i>
                                        <span>Status</span>
                                    </div>
                                </th>
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-sort-numeric-down text-gray-500"></i>
                                        <span>Order</span>
                                    </div>
                                </th>
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-dollar-sign text-gray-500"></i>
                                        <span>Price</span>
                                    </div>
                                </th>
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-calendar text-gray-500"></i>
                                        <span>Created</span>
                                    </div>
                                </th>
                                <th class="px-8 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center justify-center space-x-2">
                                        <i class="fas fa-cog text-gray-500"></i>
                                        <span>Actions</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__currentLoopData = $category->medicalTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-blue-50/30 transition-colors duration-150">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-vial text-blue-600"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900"><?php echo e($test->name); ?></div>
                                                <div class="text-xs text-gray-500">ID: <?php echo e($test->id); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-sm text-gray-700 leading-relaxed max-w-xs">
                                            <?php echo e(Str::limit($test->description, 80)); ?>

                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <?php if($test->is_active): ?>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1.5 text-xs"></i>
                                                Active
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1.5 text-xs"></i>
                                                Inactive
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <span class="text-sm font-semibold text-gray-700"><?php echo e($test->sort_order); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-peso-sign text-green-600 text-xs"></i>
                                            </div>
                                            <div class="text-sm font-semibold text-gray-900">
                                                <?php if($test->price): ?>
                                                    ₱<?php echo e(number_format($test->price, 2)); ?>

                                                <?php else: ?>
                                                    <span class="text-gray-400 italic">Not set</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-sm text-gray-600">
                                            <div class="font-medium"><?php echo e($test->created_at->format('M d, Y')); ?></div>
                                            <div class="text-xs text-gray-500"><?php echo e($test->created_at->format('g:i A')); ?></div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center justify-center space-x-3">
                                            <a href="<?php echo e(route('medical-tests.edit', $test->id)); ?>" 
                                               class="w-8 h-8 bg-indigo-100 hover:bg-indigo-200 text-indigo-600 rounded-lg flex items-center justify-center transition-colors duration-150"
                                               title="Edit Test">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <button type="button" 
                                                    onclick="openDeleteModal(<?php echo e($test->id); ?>, '<?php echo e($test->name); ?>')"
                                                    class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition-colors duration-150"
                                                    title="Delete Test">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="px-8 py-16 text-center">
                    <div class="w-20 h-20 mx-auto bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-vial text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">No Medical Tests Found</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto leading-relaxed">This category doesn't have any medical tests yet. Create your first test to get started with organizing medical examinations.</p>
                    <a href="<?php echo e(route('medical-tests.create', ['category_id' => $category->id])); ?>" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors duration-150 shadow-lg hover:shadow-xl">
                        <i class="fas fa-plus mr-2"></i>
                        Create First Medical Test
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" style="display: none;">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Medical Test</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete the medical test "<span id="testName" class="font-semibold text-gray-900"></span>"? 
                    This action cannot be undone.
                </p>
            </div>
            <div class="flex justify-center space-x-3 mt-4">
                <button onclick="closeDeleteModal()" 
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" 
                            class="bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openDeleteModal(testId, testName) {
    document.getElementById('testName').textContent = testName;
    document.getElementById('deleteForm').action = `/admin/medical-tests/${testId}`;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/admin/medical-test-categories/show.blade.php ENDPATH**/ ?>