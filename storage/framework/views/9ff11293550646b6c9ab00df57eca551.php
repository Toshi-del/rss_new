<?php $__env->startSection('title', 'Edit Inventory Item'); ?>
<?php $__env->startSection('page-title', 'Edit Inventory Item'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-6">
    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="<?php echo e(route('admin.inventory.index')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-lg border border-gray-200 transition-all duration-150 shadow-sm">
                    <i class="fas fa-arrow-left mr-2 text-sm"></i>
                    Back to Inventory
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Item</h1>
                    <p class="text-sm text-gray-600 mt-1">Update the details for "<?php echo e($inventory->item_name); ?>"</p>
                </div>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-blue-600 px-8 py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Update Item Information</h2>
                        <p class="text-blue-100 text-sm mt-1">Modify the details for this inventory item</p>
                    </div>
                </div>
            </div>

            <form action="<?php echo e(route('admin.inventory.update', $inventory)); ?>" method="POST" class="p-8 space-y-8">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Basic Information Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Item Name -->
                    <div class="space-y-2">
                        <label for="item_name" class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-tag text-gray-400 mr-2"></i>
                            Item Name
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" 
                               name="item_name" 
                               id="item_name" 
                               value="<?php echo e(old('item_name', $inventory->item_name)); ?>" 
                               placeholder="Enter item name (e.g., Surgical Gloves, Stethoscope)"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 <?php $__errorArgs = ['item_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               required>
                        <?php $__errorArgs = ['item_name'];
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

                    <!-- Category -->
                    <div class="space-y-2">
                        <label for="category" class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-layer-group text-gray-400 mr-2"></i>
                            Category
                            <span class="text-gray-500 text-xs ml-2">(Optional)</span>
                        </label>
                        <input type="text" 
                               name="category" 
                               id="category" 
                               value="<?php echo e(old('category', $inventory->category)); ?>" 
                               placeholder="e.g., Medical Supplies, Equipment, Medications"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['category'];
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
                </div>

                <!-- Quantity and Status Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Item Quantity -->
                    <div class="space-y-2">
                        <label for="item_quantity" class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-cubes text-gray-400 mr-2"></i>
                            Quantity
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="number" 
                               name="item_quantity" 
                               id="item_quantity" 
                               value="<?php echo e(old('item_quantity', $inventory->item_quantity)); ?>" 
                               min="0"
                               placeholder="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 <?php $__errorArgs = ['item_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               required>
                        <?php $__errorArgs = ['item_quantity'];
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

                    <!-- Minimum Stock -->
                    <div class="space-y-2">
                        <label for="minimum_stock" class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-exclamation-triangle text-gray-400 mr-2"></i>
                            Minimum Stock
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="number" 
                               name="minimum_stock" 
                               id="minimum_stock" 
                               value="<?php echo e(old('minimum_stock', $inventory->minimum_stock)); ?>" 
                               min="0"
                               placeholder="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 <?php $__errorArgs = ['minimum_stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               required>
                        <p class="text-xs text-gray-500 mt-1">Alert when stock falls below this level</p>
                        <?php $__errorArgs = ['minimum_stock'];
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

                    <!-- Item Status -->
                    <div class="space-y-2">
                        <label for="item_status" class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-toggle-on text-gray-400 mr-2"></i>
                            Status
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <select name="item_status" 
                                id="item_status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 <?php $__errorArgs = ['item_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                required>
                            <option value="active" <?php echo e(old('item_status', $inventory->item_status) == 'active' ? 'selected' : ''); ?>>Active</option>
                            <option value="inactive" <?php echo e(old('item_status', $inventory->item_status) == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                            <option value="out_of_stock" <?php echo e(old('item_status', $inventory->item_status) == 'out_of_stock' ? 'selected' : ''); ?>>Out of Stock</option>
                        </select>
                        <?php $__errorArgs = ['item_status'];
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
                              placeholder="Provide a detailed description of the item, its specifications, or usage notes..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 resize-none <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description', $inventory->description)); ?></textarea>
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

                <!-- Additional Information Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Unit Price -->
                    <div class="space-y-2">
                        <label for="unit_price" class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-peso-sign text-gray-400 mr-2"></i>
                            Unit Price
                            <span class="text-gray-500 text-xs ml-2">(Optional)</span>
                        </label>
                        <input type="number" 
                               name="unit_price" 
                               id="unit_price" 
                               value="<?php echo e(old('unit_price', $inventory->unit_price)); ?>" 
                               min="0"
                               step="0.01"
                               placeholder="0.00"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 <?php $__errorArgs = ['unit_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['unit_price'];
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

                    <!-- Supplier -->
                    <div class="space-y-2">
                        <label for="supplier" class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-truck text-gray-400 mr-2"></i>
                            Supplier
                            <span class="text-gray-500 text-xs ml-2">(Optional)</span>
                        </label>
                        <input type="text" 
                               name="supplier" 
                               id="supplier" 
                               value="<?php echo e(old('supplier', $inventory->supplier)); ?>" 
                               placeholder="e.g., Medical Supply Co., ABC Pharmaceuticals"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 <?php $__errorArgs = ['supplier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['supplier'];
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

                    <!-- Expiry Date -->
                    <div class="space-y-2">
                        <label for="expiry_date" class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                            Expiry Date
                            <span class="text-gray-500 text-xs ml-2">(Optional)</span>
                        </label>
                        <input type="date" 
                               name="expiry_date" 
                               id="expiry_date" 
                               value="<?php echo e(old('expiry_date', $inventory->expiry_date ? $inventory->expiry_date->format('Y-m-d') : '')); ?>" 
                               min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 <?php $__errorArgs = ['expiry_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['expiry_date'];
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
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="<?php echo e(route('admin.inventory.index')); ?>" 
                       class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-all duration-150 border border-gray-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-150 shadow-md hover:shadow-lg">
                        <i class="fas fa-save mr-2"></i>
                        Update Item
                    </button>
                </div>
            </form>
        </div>

        <!-- Current Item Info -->
        <div class="bg-white/60 backdrop-blur-sm rounded-xl border border-white/20 p-6">
            <div class="flex items-start space-x-4">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Current Item Status</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-calendar-plus text-gray-400"></i>
                            <span class="text-gray-600">Added: <?php echo e($inventory->created_at->format('M d, Y')); ?></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-sync-alt text-gray-400"></i>
                            <span class="text-gray-600">Last Updated: <?php echo e($inventory->updated_at->diffForHumans()); ?></span>
                        </div>
                        <?php if($inventory->is_low_stock): ?>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-exclamation-triangle text-red-500"></i>
                                <span class="text-red-600 font-medium">Low Stock Alert</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/admin/inventory/edit.blade.php ENDPATH**/ ?>