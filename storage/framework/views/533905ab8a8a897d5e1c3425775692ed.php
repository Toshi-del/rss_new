<?php $__env->startSection('title', 'Account Invitations'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-user-plus mr-3"></i>Account Invitations
                        </h1>
                        <p class="text-blue-100">Create and manage patient account invitation links</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-500 rounded-lg px-4 py-2">
                            <p class="text-blue-100 text-sm font-medium">Total Invitations</p>
                            <p class="text-white text-xl font-bold"><?php echo e($invitations->total() ?? $invitations->count()); ?></p>
                        </div>
                        <a href="<?php echo e(route('company.account-invitations.create')); ?>" 
                           class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-lg text-sm font-bold hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 transition-all duration-200 shadow-sm">
                            <i class="fas fa-plus mr-2"></i>
                            Create New Invitation
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

        <!-- Invitation URL Display -->
        <?php if(session('invitation_url')): ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-green-600 to-green-700 border-l-4 border-green-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-link mr-3"></i>Invitation Link Created!
                        </h2>
                        <p class="text-green-100">Share this secure link with the invited person</p>
                    </div>
                    <button onclick="copyToClipboard('<?php echo e(session('invitation_url')); ?>')" 
                            class="inline-flex items-center px-6 py-3 bg-white text-green-600 rounded-lg text-sm font-bold hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-600 transition-all duration-200 shadow-sm">
                        <i class="fas fa-copy mr-2"></i>
                        Copy Link
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-green-600">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Invitation URL:</label>
                    <div class="flex items-center space-x-3">
                        <code class="flex-1 text-sm bg-white p-3 rounded border border-gray-300 break-all font-mono"><?php echo e(session('invitation_url')); ?></code>
                        <button onclick="copyToClipboard('<?php echo e(session('invitation_url')); ?>')" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors duration-200">
                            <i class="fas fa-copy mr-1"></i>
                            Copy
                        </button>
                    </div>
                    <div class="mt-3 flex items-center text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                        <span>This link will expire in 7 days. The invited person can use it to create their account.</span>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Invitations List -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-purple-600 to-purple-700 border-l-4 border-purple-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-list mr-3"></i>Recent Invitations
                </h2>
                <p class="text-purple-100 mt-1">Manage and track your invitation links</p>
            </div>
            
            <?php if($invitations->count() > 0): ?>
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <?php $__currentLoopData = $invitations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invitation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-50 rounded-xl p-6 border-l-4 
                        <?php if($invitation->is_used): ?> border-green-600 
                        <?php elseif($invitation->isExpired()): ?> border-red-600 
                        <?php else: ?> border-yellow-600 <?php endif; ?> 
                        hover:shadow-md transition-shadow duration-200">
                        
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 
                                    <?php if($invitation->is_used): ?> bg-green-600 
                                    <?php elseif($invitation->isExpired()): ?> bg-red-600 
                                    <?php else: ?> bg-yellow-600 <?php endif; ?> 
                                    rounded-full flex items-center justify-center mr-4">
                                    <?php if($invitation->is_used): ?>
                                        <i class="fas fa-check text-white text-lg"></i>
                                    <?php elseif($invitation->isExpired()): ?>
                                        <i class="fas fa-times text-white text-lg"></i>
                                    <?php else: ?>
                                        <i class="fas fa-clock text-white text-lg"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">
                                        <?php if($invitation->email): ?>
                                            <?php echo e($invitation->email); ?>

                                        <?php else: ?>
                                            <span class="text-gray-500">Invitation #<?php echo e($invitation->id); ?></span>
                                        <?php endif; ?>
                                    </h3>
                                    <p class="text-gray-600 text-sm">
                                        <?php if($invitation->email): ?>
                                            Account registered
                                        <?php else: ?>
                                            Awaiting registration
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                <?php if($invitation->is_used): ?> bg-green-100 text-green-800 
                                <?php elseif($invitation->isExpired()): ?> bg-red-100 text-red-800 
                                <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                                <?php if($invitation->is_used): ?>
                                    <i class="fas fa-check mr-1"></i>Used
                                <?php elseif($invitation->isExpired()): ?>
                                    <i class="fas fa-exclamation-triangle mr-1"></i>Expired
                                <?php else: ?>
                                    <i class="fas fa-clock mr-1"></i>Active
                                <?php endif; ?>
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-white rounded-lg p-3">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Created</p>
                                <p class="text-sm font-semibold text-gray-900"><?php echo e($invitation->created_at->format('M d, Y')); ?></p>
                                <p class="text-xs text-gray-600"><?php echo e($invitation->created_at->format('g:i A')); ?></p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Expires</p>
                                <p class="text-sm font-semibold text-gray-900"><?php echo e($invitation->expires_at->format('M d, Y')); ?></p>
                                <p class="text-xs text-gray-600"><?php echo e($invitation->expires_at->format('g:i A')); ?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex space-x-2">
                                <?php if(!$invitation->is_used && !$invitation->isExpired()): ?>
                                    <button onclick="copyInvitationLink('<?php echo e(route('invitation.accept', ['token' => $invitation->token])); ?>')" 
                                            class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors duration-200">
                                        <i class="fas fa-copy mr-1"></i>Copy Link
                                    </button>
                                <?php endif; ?>
                                <form action="<?php echo e(route('company.account-invitations.destroy', $invitation)); ?>" 
                                      method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors duration-200"
                                            onclick="return confirm('Are you sure you want to delete this invitation?')">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                            
                            <?php if(!$invitation->is_used && !$invitation->isExpired()): ?>
                                <div class="text-right">
                                    <?php
                                        $hoursLeft = $invitation->expires_at->diffInHours(now());
                                        $daysLeft = $invitation->expires_at->diffInDays(now());
                                    ?>
                                    <p class="text-xs text-gray-500">
                                        <?php if($daysLeft > 0): ?>
                                            <?php echo e($daysLeft); ?> day(s) left
                                        <?php else: ?>
                                            <?php echo e($hoursLeft); ?> hour(s) left
                                        <?php endif; ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <!-- Pagination -->
                <?php if(method_exists($invitations, 'links')): ?>
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <?php echo e($invitations->links()); ?>

                </div>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <!-- Enhanced Empty State -->
            <div class="p-12 text-center">
                <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-plus text-purple-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No Invitations Yet</h3>
                <p class="text-gray-600 mb-6">Create your first account invitation link to get started with patient onboarding.</p>
                <div class="space-y-4">
                    <a href="<?php echo e(route('company.account-invitations.create')); ?>" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Create First Invitation
                    </a>
                    <div class="bg-blue-50 rounded-lg p-4 max-w-md mx-auto">
                        <p class="text-blue-800 text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            Invitation links allow patients to create secure accounts and access their medical information.
                        </p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showNotification('Link copied to clipboard!', 'success');
    }, function(err) {
        console.error('Could not copy text: ', err);
        showNotification('Failed to copy link. Please try again.', 'error');
    });
}

function copyInvitationLink(url) {
    copyToClipboard(url);
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
        type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('[class*="hover:shadow-md"]');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/company/account-invitations/index.blade.php ENDPATH**/ ?>