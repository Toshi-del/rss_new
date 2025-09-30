<?php $__env->startSection('title', 'Company Accounts & Patients'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Header Section -->
    <div class="content-card rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-building text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Company Accounts & Patients</h1>
                    <p class="text-sm text-gray-600">Manage company accounts and their associated patients</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <input type="text" 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="Search companies...">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button onclick="openAddCompanyModal()" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Add Company</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700"><?php echo e(session('error')); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <div class="text-sm text-red-700">
                        <ul class="list-disc list-inside">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Pending Company Account Notifications -->
    <?php if($pendingCompanyUsers->count() > 0): ?>
    <div class="content-card rounded-lg p-6 bg-yellow-50 border-l-4 border-yellow-400">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                </div>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-medium text-yellow-800 mb-2">
                    Pending Company Account Approvals (<?php echo e($pendingCompanyUsers->count()); ?>)
                </h3>
                <p class="text-sm text-yellow-700 mb-4">
                    The following company accounts are waiting for approval:
                </p>
                
                <div class="space-y-3">
                    <?php $__currentLoopData = $pendingCompanyUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pendingUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-lg p-4 border border-yellow-200">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900"><?php echo e($pendingUser->fname); ?> <?php echo e($pendingUser->lname); ?></h4>
                                        <p class="text-sm text-gray-600"><?php echo e($pendingUser->email); ?></p>
                                        <?php if($pendingUser->company): ?>
                                            <p class="text-xs text-gray-500">Company: <?php echo e($pendingUser->company); ?></p>
                                        <?php endif; ?>
                                        <p class="text-xs text-gray-400">Registered: <?php echo e($pendingUser->created_at->format('M j, Y g:i A')); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <form method="POST" action="<?php echo e(route('admin.company-accounts.approve', $pendingUser->id)); ?>" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" 
                                            class="px-3 py-1 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition-colors duration-200 flex items-center space-x-1"
                                            onclick="return confirm('Are you sure you want to approve this company account?')">
                                        <i class="fas fa-check text-xs"></i>
                                        <span>Approve</span>
                                    </button>
                                </form>
                                <button onclick="openRejectModal(<?php echo e($pendingUser->id); ?>, '<?php echo e($pendingUser->fname); ?> <?php echo e($pendingUser->lname); ?>')"
                                        class="px-3 py-1 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition-colors duration-200 flex items-center space-x-1">
                                    <i class="fas fa-times text-xs"></i>
                                    <span>Reject</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Companies List -->
    <div class="space-y-4">
        <?php $__currentLoopData = $companyData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="content-card rounded-lg overflow-hidden hover:shadow-lg transition-all duration-200">
                <!-- Company Header -->
                <div class="bg-blue-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center">
                                <i class="fas fa-building text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-white"><?php echo e($entry['company']->company ?? $entry['company']->name ?? 'N/A'); ?></h3>
                                <p class="text-blue-100 text-sm"><?php echo e($entry['company']->email); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <!-- Stats -->
                            <div class="flex items-center space-x-4 text-white">
                                <div class="text-center">
                                    <div class="text-2xl font-bold"><?php echo e(count($entry['patients'])); ?></div>
                                    <div class="text-xs text-blue-100">Patients</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold"><?php echo e(count($entry['preEmployments'])); ?></div>
                                    <div class="text-xs text-blue-100">Records</div>
                                </div>
                            </div>
                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <button onclick="openEditCompanyModal(<?php echo e($idx); ?>)" 
                                        class="p-2 bg-white/10 hover:bg-white/20 rounded-lg transition-colors duration-200" 
                                        title="Edit Company">
                                    <i class="fas fa-edit text-white"></i>
                                </button>
                                <button onclick="openDeleteCompanyModal(<?php echo e($idx); ?>)" 
                                        class="p-2 bg-white/10 hover:bg-red-500/20 rounded-lg transition-colors duration-200" 
                                        title="Delete Company">
                                    <i class="fas fa-trash text-white"></i>
                                </button>
                                <button onclick="toggleCompanyDetails(<?php echo e($idx); ?>)" 
                                        class="p-2 bg-white/10 hover:bg-white/20 rounded-lg transition-colors duration-200" 
                                        title="View Details">
                                    <i class="fas fa-chevron-down text-white company-toggle-<?php echo e($idx); ?>"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Details (Collapsible) -->
                <div id="company-details-<?php echo e($idx); ?>" class="hidden">
                    <div class="p-6">
                        <!-- Tabs Navigation -->
                        <div class="flex border-b border-gray-200 mb-6">
                            <button onclick="switchTab(<?php echo e($idx); ?>, 'patients')" 
                                    class="tab-button-<?php echo e($idx); ?> px-6 py-3 text-sm font-medium border-b-2 border-blue-600 text-blue-600 bg-blue-50 rounded-t-lg" 
                                    data-tab="patients">
                                <i class="fas fa-users mr-2"></i>Patients
                            </button>
                            <button onclick="switchTab(<?php echo e($idx); ?>, 'records')" 
                                    class="tab-button-<?php echo e($idx); ?> px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 rounded-t-lg ml-2" 
                                    data-tab="records">
                                <i class="fas fa-briefcase-medical mr-2"></i>Pre-Employment Records
                            </button>
                        </div>

                        <!-- Patients Tab -->
                        <div id="patients-tab-content-<?php echo e($idx); ?>" class="tab-content-<?php echo e($idx); ?>">
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-lg font-semibold text-gray-900">Patients (<?php echo e(count($entry['patients'])); ?>)</h4>
                                    <button onclick="openAddPatientModal(<?php echo e($idx); ?>)" 
                                            class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors duration-200 flex items-center space-x-2">
                                        <i class="fas fa-user-plus"></i>
                                        <span>Add Patient</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full bg-white rounded-lg overflow-hidden shadow-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Full Name</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Age/Sex</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Phone</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <?php $__empty_1 = true; $__currentLoopData = $entry['patients']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patientIdx => $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                                            <?php echo e(strtoupper(substr($patient->getFullNameAttribute(), 0, 2))); ?>

                                                        </div>
                                                        <div class="font-medium text-gray-900"><?php echo e($patient->getFullNameAttribute()); ?></div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($patient->getAgeSexAttribute()); ?></td>
                                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($patient->email); ?></td>
                                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($patient->phone); ?></td>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center space-x-2">
                                                        <button onclick="openEditPatientModal(<?php echo e($idx); ?>, <?php echo e($patientIdx); ?>)" 
                                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                                                title="Edit Patient">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button onclick="openDeletePatientModal(<?php echo e($idx); ?>, <?php echo e($patientIdx); ?>)" 
                                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                                                                title="Delete Patient">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                                                    <p>No patients found for this company.</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Records Tab -->
                        <div id="records-tab-content-<?php echo e($idx); ?>" class="tab-content-<?php echo e($idx); ?> hidden">
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-lg font-semibold text-gray-900">Pre-Employment Records (<?php echo e(count($entry['preEmployments'])); ?>)</h4>
                                    <button onclick="openAddRecordModal(<?php echo e($idx); ?>)" 
                                            class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200 flex items-center space-x-2">
                                        <i class="fas fa-file-plus"></i>
                                        <span>Add Record</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full bg-white rounded-lg overflow-hidden shadow-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Full Name</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Age/Sex</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Phone</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <?php $__empty_1 = true; $__currentLoopData = $entry['preEmployments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recordIdx => $pre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center text-white font-semibold">
                                                            <?php echo e(strtoupper(substr($pre->full_name, 0, 2))); ?>

                                                        </div>
                                                        <div class="font-medium text-gray-900"><?php echo e($pre->full_name); ?></div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($pre->age); ?> / <?php echo e($pre->sex); ?></td>
                                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($pre->email); ?></td>
                                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($pre->phone_number); ?></td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                        <?php if(strtolower($pre->status) === 'approved'): ?> bg-green-100 text-green-800
                                                        <?php elseif(strtolower($pre->status) === 'pending'): ?> bg-yellow-100 text-yellow-800
                                                        <?php elseif(strtolower($pre->status) === 'declined'): ?> bg-red-100 text-red-800
                                                        <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                                        <i class="fas fa-circle text-xs mr-1"></i>
                                                        <?php echo e(ucfirst($pre->status)); ?>

                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center space-x-2">
                                                        <button onclick="openEditRecordModal(<?php echo e($idx); ?>, <?php echo e($recordIdx); ?>)" 
                                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                                                title="Edit Record">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button onclick="openDeleteRecordModal(<?php echo e($idx); ?>, <?php echo e($recordIdx); ?>)" 
                                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                                                                title="Delete Record">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                                    <i class="fas fa-briefcase-medical text-4xl text-gray-300 mb-4"></i>
                                                    <p>No pre-employment records found for this company.</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<!-- Modals -->
<!-- Add Company Modal -->
<div id="addCompanyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Add New Company</h3>
                <button onclick="closeModal('addCompanyModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addCompanyForm">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                        <input type="text" name="company_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal('addCompanyModal')" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">Add Company</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Company Modal -->
<div id="editCompanyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-10 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Edit Company Account</h3>
                <button onclick="closeModal('editCompanyModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="editCompanyForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="space-y-4">
                    <div>
                        <label for="edit_fname" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="fname" id="edit_fname" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="edit_lname" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="lname" id="edit_lname" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="edit_email" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="edit_company" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                        <input type="text" name="company" id="edit_company" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="edit_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" id="edit_phone" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal('editCompanyModal')" 
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Update Company
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Company Modal -->
<div id="deleteCompanyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Delete Company</h3>
                <button onclick="closeModal('deleteCompanyModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-900 font-medium">Are you sure you want to delete <span id="deleteCompanyName"></span>?</p>
                        <p class="text-sm text-gray-500">This action cannot be undone and will delete all associated data.</p>
                    </div>
                </div>
            </div>
            
            <form id="deleteCompanyForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('deleteCompanyModal')" 
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                        Delete Company
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Company Account Modal -->
<div id="rejectCompanyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Reject Company Account</h3>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="rejectCompanyForm" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-times text-red-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">Reject account for <span id="rejectUserName"></span>?</p>
                            <p class="text-sm text-gray-500">This will prevent them from accessing company features.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for Rejection (Optional)
                    </label>
                    <textarea name="reason" id="rejection_reason" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent resize-vertical"
                              placeholder="Enter reason for rejection..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" 
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                        Reject Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Company Management JavaScript - Updated <?php echo e(now()); ?>

console.log('JavaScript loaded at:', new Date().toISOString());
// Toggle company details
function toggleCompanyDetails(idx) {
    const details = document.getElementById(`company-details-${idx}`);
    const toggle = document.querySelector(`.company-toggle-${idx}`);
    
    if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        toggle.classList.remove('fa-chevron-down');
        toggle.classList.add('fa-chevron-up');
    } else {
        details.classList.add('hidden');
        toggle.classList.remove('fa-chevron-up');
        toggle.classList.add('fa-chevron-down');
    }
}

// Switch tabs
function switchTab(companyIdx, tabName) {
    // Hide all tab contents
    document.querySelectorAll(`.tab-content-${companyIdx}`).forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tab buttons
    document.querySelectorAll(`.tab-button-${companyIdx}`).forEach(button => {
        button.classList.remove('border-blue-600', 'text-blue-600', 'bg-blue-50');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(`${tabName}-tab-content-${companyIdx}`).classList.remove('hidden');
    
    // Add active state to selected tab button
    const activeButton = document.querySelector(`.tab-button-${companyIdx}[data-tab="${tabName}"]`);
    activeButton.classList.add('border-blue-600', 'text-blue-600', 'bg-blue-50');
    activeButton.classList.remove('border-transparent', 'text-gray-500');
}

// Modal management functions
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function openAddCompanyModal() {
    openModal('addCompanyModal');
}

// Company account rejection functions
function openRejectModal(userId, userName) {
    document.getElementById('rejectUserName').textContent = userName;
    document.getElementById('rejectCompanyForm').action = `/admin/company-accounts/${userId}/reject`;
    document.getElementById('rejectCompanyModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectCompanyModal').classList.add('hidden');
    document.getElementById('rejection_reason').value = '';
}

// Company management functions
function openEditCompanyModal(idx) {
    const companyData = <?php echo json_encode($companyData, 15, 512) ?>;
    const company = companyData[idx].company;
    
    // Populate form fields
    document.getElementById('edit_fname').value = company.fname || '';
    document.getElementById('edit_lname').value = company.lname || '';
    document.getElementById('edit_email').value = company.email || '';
    document.getElementById('edit_company').value = company.company || '';
    document.getElementById('edit_phone').value = company.phone || '';
    
    // Set form action
    document.getElementById('editCompanyForm').action = `/admin/company-accounts/${company.id}/update`;
    
    // Show modal
    openModal('editCompanyModal');
}

function openDeleteCompanyModal(idx) {
    const companyData = <?php echo json_encode($companyData, 15, 512) ?>;
    const company = companyData[idx].company;
    
    console.log('=== DELETE COMPANY DEBUG ===');
    console.log('Delete company:', company);
    console.log('Company ID:', company.id);
    console.log('Index:', idx);
    
    // Set company name in modal
    document.getElementById('deleteCompanyName').textContent = company.company || `${company.fname} ${company.lname}`;
    
    // Set form action - CORRECTED URL WITHOUT /delete
    const formAction = `/admin/company-accounts/${company.id}`;
    const form = document.getElementById('deleteCompanyForm');
    form.action = formAction;
    
    console.log('Form action set to:', formAction);
    console.log('Form element:', form);
    console.log('Form method:', form.method);
    console.log('Current timestamp:', new Date().getTime());
    
    // Show modal
    openModal('deleteCompanyModal');
}

// Add form submit debugging
document.addEventListener('DOMContentLoaded', function() {
    const deleteForm = document.getElementById('deleteCompanyForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            console.log('=== FORM SUBMIT DEBUG ===');
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);
            console.log('Form elements:', this.elements);
            console.log('Submitting form...');
        });
    }
});

// Placeholder functions for other modals
function openAddPatientModal(idx) { console.log('Add patient to company:', idx); }
function openEditPatientModal(companyIdx, patientIdx) { console.log('Edit patient:', companyIdx, patientIdx); }
function openDeletePatientModal(companyIdx, patientIdx) { console.log('Delete patient:', companyIdx, patientIdx); }
function openAddRecordModal(idx) { console.log('Add record to company:', idx); }
function openEditRecordModal(companyIdx, recordIdx) { console.log('Edit record:', companyIdx, recordIdx); }
function openDeleteRecordModal(companyIdx, recordIdx) { console.log('Delete record:', companyIdx, recordIdx); }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/admin/accounts-and-patients.blade.php ENDPATH**/ ?>