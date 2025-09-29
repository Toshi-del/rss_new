

<?php $__env->startSection('title', 'Create Medical Test Category'); ?>
<?php $__env->startSection('page-title', 'Create Medical Test Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-6">
    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="<?php echo e(route('medical-test-categories.index')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-lg border border-gray-200 transition-all duration-150 shadow-sm">
                    <i class="fas fa-arrow-left mr-2 text-sm"></i>
                    Back to Categories
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Create New Category</h1>
                    <p class="text-sm text-gray-600 mt-1">Add a new medical test category to organize your examinations</p>
                </div>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-blue-600 px-8 py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Category Information</h2>
                        <p class="text-blue-100 text-sm mt-1">Fill in the details for the new medical test category</p>
                    </div>
                </div>
            </div>

            <form action="<?php echo e(route('medical-test-categories.store')); ?>" method="POST" class="p-8 space-y-8">
                <?php echo csrf_field(); ?>

                <!-- Category Name -->
                <div class="space-y-2">
                    <label for="name" class="flex items-center text-sm font-semibold text-gray-700">
                        <i class="fas fa-tag text-gray-400 mr-2"></i>
                        Category Name
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="<?php echo e(old('name')); ?>" 
                           placeholder="Enter category name (e.g., Blood Tests, X-Ray Examinations)"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="flex items-center space-x-2 mt-2">
                            <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
                            <p class="text-sm text-red-600"><?php echo e($message); ?></p>
                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label for="description" class="flex items-center text-sm font-semibold text-gray-700">
                        <i class="fas fa-align-left text-gray-400 mr-2"></i>
                        Description
                        <span class="text-gray-500 text-xs ml-2">(Optional)</span>
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4" 
                              placeholder="Provide a brief description of this category and what types of tests it includes..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 resize-none <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="flex items-center space-x-2 mt-2">
                            <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
                            <p class="text-sm text-red-600"><?php echo e($message); ?></p>
                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Settings Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sort Order -->
                    <div class="space-y-2">
                        <label for="sort_order" class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-sort-numeric-up text-gray-400 mr-2"></i>
                            Sort Order
                        </label>
                        <input type="number" 
                               name="sort_order" 
                               id="sort_order" 
                               value="<?php echo e(old('sort_order', 0)); ?>" 
                               min="0"
                               placeholder="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <p class="text-xs text-gray-500 mt-1">Lower numbers appear first in the list</p>
                        <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="flex items-center space-x-2 mt-2">
                                <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
                                <p class="text-sm text-red-600"><?php echo e($message); ?></p>
                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Active Status -->
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-toggle-on text-gray-400 mr-2"></i>
                            Status
                        </label>
                        <div class="flex items-center space-x-4 mt-3">
                            <label class="inline-flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       id="is_active" 
                                       value="1" 
                                       <?php echo e(old('is_active', true) ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition-all duration-150">
                                <span class="ml-3 text-sm font-medium text-gray-700">Active Category</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Active categories are available for creating medical tests</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="<?php echo e(route('medical-test-categories.index')); ?>" 
                       class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-all duration-150 border border-gray-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-150 shadow-md hover:shadow-lg">
                        <i class="fas fa-plus mr-2"></i>
                        Create Category
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="bg-white/60 backdrop-blur-sm rounded-xl border border-white/20 p-6">
            <div class="flex items-start space-x-4">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Tips for Creating Categories</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-green-500 text-xs"></i>
                            <span>Use clear, descriptive names that are easy to understand</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-green-500 text-xs"></i>
                            <span>Group related medical tests together for better organization</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-green-500 text-xs"></i>
                            <span>Use sort order to arrange categories in your preferred sequence</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-green-500 text-xs"></i>
                            <span>Add descriptions to help staff understand the category's purpose</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/admin/medical-test-categories/create.blade.php ENDPATH**/ ?>