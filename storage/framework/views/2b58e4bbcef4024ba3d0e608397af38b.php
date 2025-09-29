<?php $__env->startSection('title', 'X-Ray Gallery'); ?>
<?php $__env->startSection('page-title', 'X-Ray Gallery'); ?>
<?php $__env->startSection('page-description', 'Browse and review all X-ray images'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border-2 border-white/20">
                        <i class="fas fa-images text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">X-Ray Image Gallery</h2>
                        <p class="text-purple-100 text-sm">Complete collection of chest X-ray images</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-white/90 text-sm">Total Images</div>
                    <div class="text-white font-bold text-3xl"><?php echo e($checklists->total()); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- X-Ray Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $checklists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checklist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- X-Ray Image -->
                <div class="relative aspect-square bg-gray-900">
                    <img src="<?php echo e(asset('storage/' . $checklist->xray_image_path)); ?>" 
                         alt="X-Ray Image" 
                         class="w-full h-full object-contain">
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 bg-purple-600 text-white text-xs font-bold rounded-full shadow-lg">
                            <i class="fas fa-x-ray mr-1"></i>
                            X-Ray
                        </span>
                    </div>
                </div>

                <!-- Patient Info -->
                <div class="p-4 space-y-3">
                    <div>
                        <div class="font-bold text-gray-900 text-lg"><?php echo e($checklist->name ?? 'Unknown Patient'); ?></div>
                        <div class="text-sm text-gray-500">
                            <?php if($checklist->preEmploymentRecord): ?>
                                <span class="inline-flex items-center">
                                    <i class="fas fa-briefcase mr-1"></i>
                                    Pre-Employment
                                </span>
                            <?php elseif($checklist->patient): ?>
                                <span class="inline-flex items-center">
                                    <i class="fas fa-user-md mr-1"></i>
                                    Annual Physical
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center">
                                    <i class="fas fa-file-medical mr-1"></i>
                                    General
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-gray-600">
                        <div>
                            <i class="fas fa-calendar mr-1"></i>
                            <?php echo e($checklist->date ? $checklist->date->format('M d, Y') : 'N/A'); ?>

                        </div>
                        <div>
                            <i class="fas fa-user-md mr-1"></i>
                            <?php echo e($checklist->chest_xray_done_by ?? 'N/A'); ?>

                        </div>
                    </div>

                    <!-- View Button -->
                    <a href="<?php echo e(asset('storage/' . $checklist->xray_image_path)); ?>" 
                       target="_blank"
                       class="block w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors text-center shadow-sm">
                        <i class="fas fa-expand mr-2"></i>
                        View Full Size
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-12">
                    <div class="flex flex-col items-center justify-center space-y-4">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-images text-gray-400 text-4xl"></i>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-500 font-medium text-xl">No X-ray images found</p>
                            <p class="text-gray-400 text-sm mt-2">X-ray images will appear here once uploaded by RadTech</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($checklists->hasPages()): ?>
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
            <?php echo e($checklists->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.radiologist', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/radiologist/xray-gallery.blade.php ENDPATH**/ ?>