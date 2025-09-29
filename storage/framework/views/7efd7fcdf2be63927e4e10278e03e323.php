<?php $__env->startSection('title', 'OPD Walk-in Patients - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'OPD Walk-in Patients'); ?>
<?php $__env->startSection('page-description', 'Outpatient department walk-in consultations and examinations'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-emerald-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-emerald-800 font-medium"><?php echo e(session('success')); ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-red-800 font-medium"><?php echo e(session('error')); ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-walking text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">OPD Walk-in Patients</h2>
                        <p class="text-amber-100 text-sm">Outpatient department consultations and medical examinations</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-white/90 text-sm">Total Patients</div>
                    <div class="text-white font-bold text-2xl"><?php echo e($opdPatients->count()); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <?php
            $totalPatients = $opdPatients->count();
            $completedCount = 0;
            $pendingCount = 0;
            $todayCount = 0;
            
            foreach($opdPatients as $patient) {
                $opdExam = \App\Models\OpdExamination::where('user_id', $patient->id)->first();
                $medicalChecklist = \App\Models\MedicalChecklist::where('user_id', $patient->id)
                    ->where('examination_type', 'opd')
                    ->first();
                    
                if($opdExam && $medicalChecklist) {
                    $completedCount++;
                } else {
                    $pendingCount++;
                }
                
                if($patient->created_at->isToday()) {
                    $todayCount++;
                }
            }
        ?>
        
        <div class="content-card rounded-xl p-6 border-l-4 border-amber-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Patients</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($totalPatients); ?></p>
                    <p class="text-xs text-amber-600 mt-1">Walk-in patients</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-amber-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="content-card rounded-xl p-6 border-l-4 border-emerald-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Completed</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($completedCount); ?></p>
                    <p class="text-xs text-emerald-600 mt-1">Examinations done</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="content-card rounded-xl p-6 border-l-4 border-red-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Pending</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($pendingCount); ?></p>
                    <p class="text-xs text-red-600 mt-1">Awaiting examination</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-red-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="content-card rounded-xl p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Today's Visits</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($todayCount); ?></p>
                    <p class="text-xs text-blue-600 mt-1">New registrations</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-day text-blue-600 text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- OPD Patients Table -->
    <div class="content-card rounded-xl shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-table text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">OPD Walk-in Patients</h3>
                        <p class="text-amber-100 text-sm">Outpatient consultation records and examination status</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button class="px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors backdrop-blur-sm border border-white/20 font-medium">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <button class="px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors backdrop-blur-sm border border-white/20 font-medium">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-0">
            <?php if($opdPatients->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Patient</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Demographics</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Contact Info</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Registration</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php $__currentLoopData = $opdPatients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $opdExam = \App\Models\OpdExamination::where('user_id', $patient->id)->first();
                                    $medicalChecklist = \App\Models\MedicalChecklist::where('user_id', $patient->id)
                                        ->where('examination_type', 'opd')
                                        ->first();
                                    $isCompleted = $opdExam && $medicalChecklist;
                                    $canSendToDoctor = $isCompleted;
                                ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                                                <span class="text-amber-600 font-semibold text-sm">
                                                    <?php echo e(substr($patient->fname, 0, 1)); ?><?php echo e(substr($patient->lname, 0, 1)); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900"><?php echo e($patient->fname); ?> <?php echo e($patient->lname); ?></p>
                                                <p class="text-xs text-gray-500">Patient ID: #<?php echo e($patient->id); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium"><?php echo e($patient->age); ?> years old</p>
                                            <p class="text-xs text-gray-500"><?php echo e(ucfirst($patient->gender ?? 'N/A')); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium"><?php echo e($patient->email); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo e($patient->phone ?? 'No phone'); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium"><?php echo e($patient->created_at->format('M d, Y')); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo e($patient->created_at->format('g:i A')); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if($isCompleted): ?>
                                            <span class="px-3 py-1 text-xs font-medium bg-emerald-100 text-emerald-800 rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>Completed
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <!-- Send to Doctor -->
                                            <?php if($canSendToDoctor): ?>
                                                <form action="<?php echo e(route('nurse.opd.send-to-doctor', $patient->id)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors" title="Send to Doctor">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <button type="button" class="p-2 text-gray-400 cursor-not-allowed rounded-lg" title="Complete examination and medical checklist first" disabled>
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            <?php endif; ?>

                                            <!-- Examination -->
                                            <?php if($opdExam): ?>
                                                <a href="<?php echo e(route('nurse.opd.edit', $opdExam->id)); ?>" class="p-2 text-emerald-600 hover:text-emerald-900 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit Examination">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('nurse.opd.create', ['user_id' => $patient->id])); ?>" class="p-2 text-emerald-600 hover:text-emerald-900 hover:bg-emerald-50 rounded-lg transition-colors" title="Create Examination">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            <?php endif; ?>

                                            <!-- Medical Checklist -->
                                            <a href="<?php echo e(route('nurse.medical-checklist.opd', $patient->id)); ?>" class="p-2 text-amber-600 hover:text-amber-900 hover:bg-amber-50 rounded-lg transition-colors" title="Medical Checklist">
                                                <i class="fas fa-clipboard-list"></i>
                                            </a>

                                            <!-- View Details -->
                                            <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
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
                        <i class="fas fa-walking text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No OPD Walk-in Patients</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no outpatient walk-in patients to display. New walk-in registrations will appear here.</p>
                    <button class="px-6 py-3 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors font-medium">
                        <i class="fas fa-user-plus mr-2"></i>Register New Patient
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth animations to content cards
        const contentCards = document.querySelectorAll('.content-card');
        contentCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-fade-in-up');
        });

        // Auto-hide alert messages after 5 seconds
        const alerts = document.querySelectorAll('[class*="bg-emerald-50"], [class*="bg-red-50"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });

        // Add confirmation for send to doctor actions
        const sendForms = document.querySelectorAll('form[action*="send-to-doctor"]');
        sendForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to send this examination to the doctor?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>

<style>
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nurse', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/nurse/opd.blade.php ENDPATH**/ ?>