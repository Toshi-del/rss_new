

<?php $__env->startSection('title', 'Request Equipment'); ?>
<?php $__env->startSection('page-title', 'Request Equipment'); ?>
<?php $__env->startSection('page-description', 'Submit a new equipment request for medical supplies'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-emerald-600"></i>
            </div>
            <div>
                <p class="text-emerald-800 font-medium"><?php echo e(session('success')); ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-emerald-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div>
                <p class="text-red-800 font-medium"><?php echo e(session('error')); ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-emerald-600 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Equipment Request</h3>
                        <p class="text-emerald-100 text-sm">Request medical supplies and equipment for your department</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?php echo e(route('nurse.pre-employment')); ?>" 
                       class="inline-flex items-center px-4 py-2 bg-white/10 text-white font-medium rounded-xl hover:bg-white/20 transition-all duration-200 border border-white/20 backdrop-blur-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Pre-Employment
                    </a>
                    
                    <a href="<?php echo e(route('nurse.equipment-requests.index')); ?>" 
                       class="inline-flex items-center px-4 py-2 bg-white/10 text-white font-medium rounded-xl hover:bg-white/20 transition-all duration-200 border border-white/20 backdrop-blur-sm">
                        <i class="fas fa-list mr-2"></i>
                        View All Requests
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Request Form -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Equipment Request Form</h2>
            <p class="text-sm text-gray-600 mt-1">Fill out the form below to request medical equipment and supplies</p>
        </div>
        
        <form action="<?php echo e(route('nurse.equipment-requests.store')); ?>" method="POST" class="p-6 space-y-6">
            <?php echo csrf_field(); ?>
            
            <!-- Request Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                    <select name="department" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Select Department</option>
                        <option value="nurse" <?php echo e(old('department') == 'nurse' ? 'selected' : ''); ?>>Nursing Department</option>
                        <option value="doctor" <?php echo e(old('department') == 'doctor' ? 'selected' : ''); ?>>Medical Department</option>
                        <option value="lab" <?php echo e(old('department') == 'lab' ? 'selected' : ''); ?>>Laboratory</option>
                        <option value="admin" <?php echo e(old('department') == 'admin' ? 'selected' : ''); ?>>Administration</option>
                    </select>
                    <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Priority Level</label>
                    <select name="priority" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Select Priority</option>
                        <option value="low" <?php echo e(old('priority') == 'low' ? 'selected' : ''); ?>>Low - Can wait</option>
                        <option value="medium" <?php echo e(old('priority') == 'medium' ? 'selected' : ''); ?>>Medium - Needed soon</option>
                        <option value="high" <?php echo e(old('priority') == 'high' ? 'selected' : ''); ?>>High - Urgent</option>
                    </select>
                    <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Purpose</label>
                    <input type="text" name="purpose" value="<?php echo e(old('purpose')); ?>" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           placeholder="Brief description of the purpose">
                    <?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Needed</label>
                    <input type="date" name="date_needed" value="<?php echo e(old('date_needed')); ?>" required
                           min="<?php echo e(date('Y-m-d')); ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <?php $__errorArgs = ['date_needed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Equipment Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Select Equipment</label>
                <?php $__errorArgs = ['equipment_items'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mb-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                
                <div class="border border-gray-200 rounded-lg p-4 max-h-80 overflow-y-auto">
                    <?php if($inventory && $inventory->count() > 0): ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php $__currentLoopData = $inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="equipment-item border border-gray-200 rounded-lg p-3 hover:bg-gray-50 transition-colors">
                                    <label class="flex items-start space-x-3 cursor-pointer">
                                        <input type="checkbox" name="equipment_items[]" value="<?php echo e($item->id); ?>" 
                                               class="equipment-checkbox mt-1 h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                                               <?php echo e(in_array($item->id, old('equipment_items', [])) ? 'checked' : ''); ?>>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2 mb-1">
                                                <div class="w-6 h-6 bg-emerald-100 rounded-md flex items-center justify-center">
                                                    <i class="fas fa-box text-emerald-600 text-xs"></i>
                                                </div>
                                                <h4 class="text-sm font-medium text-gray-900 truncate"><?php echo e($item->name); ?></h4>
                                            </div>
                                            <?php if($item->description): ?>
                                                <p class="text-xs text-gray-600 mb-2 line-clamp-2"><?php echo e($item->description); ?></p>
                                            <?php endif; ?>
                                            <div class="flex items-center justify-between text-xs">
                                                <span class="text-gray-500"><?php echo e($item->category); ?></span>
                                                <span class="text-emerald-600 font-medium"><?php echo e($item->current_quantity); ?> <?php echo e($item->unit); ?></span>
                                            </div>
                                            <div class="mt-2">
                                                <input type="number" name="quantities[<?php echo e($item->id); ?>]" 
                                                       value="<?php echo e(old('quantities.'.$item->id, 1)); ?>"
                                                       min="1" max="<?php echo e($item->current_quantity); ?>"
                                                       class="quantity-input w-full px-2 py-1 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500"
                                                       placeholder="Quantity" disabled>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-box-open text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Equipment Available</h3>
                            <p class="text-sm text-gray-500">There are currently no equipment items available for request.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                <textarea name="notes" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                          placeholder="Any additional information or special requirements..."><?php echo e(old('notes')); ?></textarea>
                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('nurse.pre-employment')); ?>" 
                   class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.equipment-checkbox');
    
    checkboxes.forEach(checkbox => {
        const quantityInput = checkbox.closest('.equipment-item').querySelector('.quantity-input');
        
        // Initialize state based on checkbox
        if (checkbox.checked) {
            quantityInput.disabled = false;
        }
        
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                quantityInput.disabled = false;
                if (!quantityInput.value) {
                    quantityInput.value = '1';
                }
                quantityInput.focus();
                quantityInput.closest('.equipment-item').classList.add('bg-emerald-50', 'border-emerald-300');
            } else {
                quantityInput.disabled = true;
                quantityInput.closest('.equipment-item').classList.remove('bg-emerald-50', 'border-emerald-300');
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nurse', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/nurse/equipment-requests/create.blade.php ENDPATH**/ ?>