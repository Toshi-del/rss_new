<?php $__env->startSection('title', 'Radiologist Dashboard'); ?>
<?php $__env->startSection('page-title', 'Radiologist Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Recent X-Ray Images</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php $__empty_1 = true; $__currentLoopData = $checklists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="border rounded p-3">
                    <div class="text-sm font-medium mb-2"><?php echo e($c->name ?? 'Unnamed'); ?> (<?php echo e($c->date?->format('Y-m-d')); ?>)</div>
                    <?php if($c->xray_image_path): ?>
                        <img src="<?php echo e(asset('storage/' . $c->xray_image_path)); ?>" alt="X-Ray" class="w-full h-40 object-contain bg-gray-50 border rounded">
                    <?php else: ?>
                        <div class="text-gray-500">No image</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-gray-500">No X-ray images found.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Pre-Employment Chest X-Ray</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600">
                    <th class="py-2">Name</th>
                    <th class="py-2">Company</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $preEmployments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t">
                        <td class="py-2"><?php echo e($row['name']); ?></td>
                        <td class="py-2"><?php echo e($row['company'] ?? '—'); ?></td>
                        <td class="py-2 space-x-2">
                            <a href="<?php echo e(route('radiologist.pre-employment.show', $row['id'])); ?>" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="3" class="py-4 text-gray-500">No records</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Annual Physical Chest X-Ray</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600">
                    <th class="py-2">Name</th>
                    <th class="py-2">Company</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $annuals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t">
                        <td class="py-2"><?php echo e($row['name']); ?></td>
                        <td class="py-2"><?php echo e($row['company'] ?? '—'); ?></td>
                        <td class="py-2 space-x-2">
                            <a href="<?php echo e(route('radiologist.annual-physical.show', $row['id'])); ?>" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="3" class="py-4 text-gray-500">No records</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.radtech', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/radiologist/dashboard.blade.php ENDPATH**/ ?>