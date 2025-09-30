<?php $__env->startSection('title', 'Tests - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'Tests'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-6">
    <div class="max-w-7xl mx-auto space-y-8">
        
        <!-- Pre-Employment Examinations Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-blue-600 px-8 py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-briefcase text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Pre-Employment Examinations</h2>
                        <p class="text-blue-100 text-sm mt-1">Medical examinations for employment candidates</p>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                    <span>ID</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user text-gray-400"></i>
                                    <span>Name</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-building text-gray-400"></i>
                                    <span>Company</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                    <span>Date</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-info-circle text-gray-400"></i>
                                    <span>Status</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-cogs text-gray-400"></i>
                                    <span>Action</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $preEmploymentResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 rounded-lg text-sm font-semibold">
                                            <?php echo e($exam->id); ?>

                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900"><?php echo e($exam->name); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-building text-gray-400 text-sm"></i>
                                        <span class="text-sm text-gray-700 font-medium"><?php echo e($exam->company_name); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                                        <span class="text-sm text-gray-700"><?php echo e(\Carbon\Carbon::parse($exam->date)->format('M d, Y')); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <?php
                                        $status = $exam->status ?? 'Pending';
                                    ?>
                                    <?php if($status === 'Completed'): ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                            <i class="fas fa-check-circle mr-1.5 text-xs"></i>
                                            Completed
                                        </span>
                                    <?php elseif($status === 'In Progress'): ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                            <i class="fas fa-clock mr-1.5 text-xs"></i>
                                            In Progress
                                        </span>
                                    <?php elseif($status === 'Sent'): ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 border border-purple-200">
                                            <i class="fas fa-paper-plane mr-1.5 text-xs"></i>
                                            Sent
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <i class="fas fa-clock mr-1.5 text-xs"></i>
                                            Pending
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-5">
                                    <button onclick="openPreEmploymentViewModal(<?php echo e($exam->id); ?>)" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-all duration-150 shadow-md hover:shadow-lg">
                                        <i class="fas fa-eye mr-2 text-xs"></i>
                                        View & Send
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-briefcase text-gray-400 text-2xl"></i>
                                        </div>
                                        <div class="text-gray-500 text-sm">No pre-employment examinations found</div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Annual Physical Examinations Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-emerald-600 px-8 py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-heartbeat text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Annual Physical Examinations</h2>
                        <p class="text-emerald-100 text-sm mt-1">Yearly health checkups and medical assessments</p>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                    <span>ID</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user text-gray-400"></i>
                                    <span>Name</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                    <span>Date</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-info-circle text-gray-400"></i>
                                    <span>Status</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-cogs text-gray-400"></i>
                                    <span>Action</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $annualPhysicalResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-emerald-100 text-emerald-700 rounded-lg text-sm font-semibold">
                                            <?php echo e($exam->id); ?>

                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900"><?php echo e($exam->name); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                                        <span class="text-sm text-gray-700"><?php echo e(\Carbon\Carbon::parse($exam->date)->format('M d, Y')); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <?php
                                        $status = $exam->status ?? 'Pending';
                                    ?>
                                    <?php if($status === 'Completed'): ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                            <i class="fas fa-check-circle mr-1.5 text-xs"></i>
                                            Completed
                                        </span>
                                    <?php elseif($status === 'In Progress'): ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                            <i class="fas fa-clock mr-1.5 text-xs"></i>
                                            In Progress
                                        </span>
                                    <?php elseif($status === 'Sent'): ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 border border-purple-200">
                                            <i class="fas fa-paper-plane mr-1.5 text-xs"></i>
                                            Sent
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <i class="fas fa-clock mr-1.5 text-xs"></i>
                                            Pending
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-5">
                                    <button onclick="openAnnualPhysicalViewModal(<?php echo e($exam->id); ?>)" 
                                            class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-all duration-150 shadow-md hover:shadow-lg">
                                        <i class="fas fa-eye mr-2 text-xs"></i>
                                        View & Send
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-heartbeat text-gray-400 text-2xl"></i>
                                        </div>
                                        <div class="text-gray-500 text-sm">No annual physical examinations found</div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Pre-Employment View Modal -->
<div id="preEmploymentExamModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 transform transition-all duration-300">
        <div class="bg-blue-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-briefcase text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Pre-Employment Examination Details</h3>
                </div>
                <button onclick="closePreEmploymentExamModal()" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <!-- Billing Section -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 mb-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-receipt text-green-600 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-green-800">Billing Information</h4>
                        <p class="text-sm text-green-600">Review charges before sending to company</p>
                    </div>
                </div>
                
                <div id="preEmploymentBillingDetails" class="space-y-4">
                    <div class="bg-white rounded-lg p-4 border border-green-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Patient Name</label>
                                <div id="billingPatientName" class="text-lg font-semibold text-gray-900">Loading...</div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Company</label>
                                <div id="billingCompanyName" class="text-lg font-semibold text-gray-900">Loading...</div>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Medical Test</label>
                                    <div id="billingTestName" class="text-base font-medium text-gray-800">Loading...</div>
                                </div>
                                <div class="text-right">
                                    <label class="text-sm font-medium text-gray-600">Total Amount</label>
                                    <div id="billingTotalAmount" class="text-2xl font-bold text-green-600">₱0.00</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="billingConfirmed" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                <label for="billingConfirmed" class="text-sm font-medium text-gray-700">
                                    I confirm the billing information is correct
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center justify-end space-x-3">
                <button type="button" 
                        onclick="closePreEmploymentExamModal()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Close
                </button>
                <button type="button" 
                        id="sendPreEmploymentBtn"
                        onclick="sendPreEmploymentToCompany()"
                        disabled
                        class="px-6 py-2 bg-gray-400 text-white rounded-lg font-medium transition-all duration-150 shadow-md cursor-not-allowed">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Send to Company
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Annual Physical View Modal -->
<div id="annualPhysicalExamModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 transform transition-all duration-300">
        <div class="bg-emerald-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heartbeat text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Annual Physical Examination Details</h3>
                </div>
                <button onclick="closeAnnualPhysicalExamModal()" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <!-- Billing Section -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 mb-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-receipt text-green-600 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-green-800">Billing Information</h4>
                        <p class="text-sm text-green-600">Review charges before sending to company</p>
                    </div>
                </div>
                
                <div id="annualPhysicalBillingDetails" class="space-y-4">
                    <div class="bg-white rounded-lg p-4 border border-green-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Patient Name</label>
                                <div id="annualBillingPatientName" class="text-lg font-semibold text-gray-900">Loading...</div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Company</label>
                                <div id="annualBillingCompanyName" class="text-lg font-semibold text-gray-900">Loading...</div>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Medical Test</label>
                                    <div id="annualBillingTestName" class="text-base font-medium text-gray-800">Loading...</div>
                                </div>
                                <div class="text-right">
                                    <label class="text-sm font-medium text-gray-600">Total Amount</label>
                                    <div id="annualBillingTotalAmount" class="text-2xl font-bold text-green-600">₱0.00</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="annualBillingConfirmed" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                <label for="annualBillingConfirmed" class="text-sm font-medium text-gray-700">
                                    I confirm the billing information is correct
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center justify-end space-x-3">
                <button type="button" 
                        onclick="closeAnnualPhysicalExamModal()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Close
                </button>
                <button type="button" 
                        id="sendAnnualPhysicalBtn"
                        onclick="sendAnnualPhysicalToCompany()"
                        disabled
                        class="px-6 py-2 bg-gray-400 text-white rounded-lg font-medium transition-all duration-150 shadow-md cursor-not-allowed">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Send to Company
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentExamId = null;
let currentExamType = null;

function openPreEmploymentViewModal(examId) {
    currentExamId = examId;
    currentExamType = 'pre_employment';
    document.getElementById('preEmploymentExamModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    loadPreEmploymentBillingData(examId);
}

function closePreEmploymentExamModal() {
    document.getElementById('preEmploymentExamModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentExamId = null;
    currentExamType = null;
    resetBillingForm('pre_employment');
}

function openAnnualPhysicalViewModal(examId) {
    currentExamId = examId;
    currentExamType = 'annual_physical';
    document.getElementById('annualPhysicalExamModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    loadAnnualPhysicalBillingData(examId);
}

function closeAnnualPhysicalExamModal() {
    document.getElementById('annualPhysicalExamModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentExamId = null;
    currentExamType = null;
    resetBillingForm('annual_physical');
}

// Load billing data for pre-employment examination
async function loadPreEmploymentBillingData(examId) {
    try {
        const response = await fetch(`/admin/examinations/pre-employment/${examId}/billing`);
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('billingPatientName').textContent = data.patient_name;
            document.getElementById('billingCompanyName').textContent = data.company_name;
            document.getElementById('billingTestName').textContent = data.test_name;
            document.getElementById('billingTotalAmount').textContent = `₱${parseFloat(data.total_amount).toLocaleString('en-US', {minimumFractionDigits: 2})}`;
        } else {
            showBillingError('pre_employment', data.message || 'Failed to load billing data');
        }
    } catch (error) {
        console.error('Error loading pre-employment billing data:', error);
        showBillingError('pre_employment', 'Failed to load billing data');
    }
}

// Load billing data for annual physical examination
async function loadAnnualPhysicalBillingData(examId) {
    try {
        const response = await fetch(`/admin/examinations/annual-physical/${examId}/billing`);
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('annualBillingPatientName').textContent = data.patient_name;
            document.getElementById('annualBillingCompanyName').textContent = data.company_name;
            document.getElementById('annualBillingTestName').textContent = data.test_name;
            document.getElementById('annualBillingTotalAmount').textContent = `₱${parseFloat(data.total_amount).toLocaleString('en-US', {minimumFractionDigits: 2})}`;
        } else {
            showBillingError('annual_physical', data.message || 'Failed to load billing data');
        }
    } catch (error) {
        console.error('Error loading annual physical billing data:', error);
        showBillingError('annual_physical', 'Failed to load billing data');
    }
}

// Show billing error
function showBillingError(type, message) {
    const prefix = type === 'pre_employment' ? '' : 'annual';
    document.getElementById(`${prefix}billingPatientName`).textContent = 'Error loading data';
    document.getElementById(`${prefix}billingCompanyName`).textContent = message;
    document.getElementById(`${prefix}billingTestName`).textContent = 'N/A';
    document.getElementById(`${prefix}billingTotalAmount`).textContent = '₱0.00';
}

// Reset billing form
function resetBillingForm(type) {
    const prefix = type === 'pre_employment' ? '' : 'annual';
    document.getElementById(`${prefix}billingPatientName`).textContent = 'Loading...';
    document.getElementById(`${prefix}billingCompanyName`).textContent = 'Loading...';
    document.getElementById(`${prefix}billingTestName`).textContent = 'Loading...';
    document.getElementById(`${prefix}billingTotalAmount`).textContent = '₱0.00';
    document.getElementById(`${prefix === '' ? 'billingConfirmed' : 'annualBillingConfirmed'}`).checked = false;
    updateSendButton(type);
}

// Send pre-employment examination to company
async function sendPreEmploymentToCompany() {
    if (!currentExamId || !document.getElementById('billingConfirmed').checked) {
        return;
    }
    
    try {
        const response = await fetch(`/admin/examinations/pre-employment/${currentExamId}/send`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Pre-employment examination sent to company successfully!');
            closePreEmploymentExamModal();
            location.reload(); // Refresh the page to update the status
        } else {
            alert('Error: ' + (data.message || 'Failed to send examination'));
        }
    } catch (error) {
        console.error('Error sending pre-employment examination:', error);
        alert('Failed to send examination to company');
    }
}

// Send annual physical examination to company
async function sendAnnualPhysicalToCompany() {
    if (!currentExamId || !document.getElementById('annualBillingConfirmed').checked) {
        return;
    }
    
    try {
        const response = await fetch(`/admin/examinations/annual-physical/${currentExamId}/send`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Annual physical examination sent to company successfully!');
            closeAnnualPhysicalExamModal();
            location.reload(); // Refresh the page to update the status
        } else {
            alert('Error: ' + (data.message || 'Failed to send examination'));
        }
    } catch (error) {
        console.error('Error sending annual physical examination:', error);
        alert('Failed to send examination to company');
    }
}

// Update send button state based on billing confirmation
function updateSendButton(type) {
    const checkboxId = type === 'pre_employment' ? 'billingConfirmed' : 'annualBillingConfirmed';
    const buttonId = type === 'pre_employment' ? 'sendPreEmploymentBtn' : 'sendAnnualPhysicalBtn';
    
    const checkbox = document.getElementById(checkboxId);
    const button = document.getElementById(buttonId);
    
    if (checkbox && button) {
        if (checkbox.checked) {
            button.disabled = false;
            button.classList.remove('bg-gray-400', 'cursor-not-allowed');
            button.classList.add(type === 'pre_employment' ? 'bg-blue-600' : 'bg-emerald-600');
            button.classList.add(type === 'pre_employment' ? 'hover:bg-blue-700' : 'hover:bg-emerald-700');
        } else {
            button.disabled = true;
            button.classList.add('bg-gray-400', 'cursor-not-allowed');
            button.classList.remove(type === 'pre_employment' ? 'bg-blue-600' : 'bg-emerald-600');
            button.classList.remove(type === 'pre_employment' ? 'hover:bg-blue-700' : 'hover:bg-emerald-700');
        }
    }
}

// Event listeners for billing confirmation checkboxes
document.addEventListener('DOMContentLoaded', function() {
    const preEmploymentCheckbox = document.getElementById('billingConfirmed');
    const annualPhysicalCheckbox = document.getElementById('annualBillingConfirmed');
    
    if (preEmploymentCheckbox) {
        preEmploymentCheckbox.addEventListener('change', function() {
            updateSendButton('pre_employment');
        });
    }
    
    if (annualPhysicalCheckbox) {
        annualPhysicalCheckbox.addEventListener('change', function() {
            updateSendButton('annual_physical');
        });
    }
});

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const modals = ['preEmploymentExamModal', 'annualPhysicalExamModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentExamId = null;
        }
    });
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = ['preEmploymentExamModal', 'annualPhysicalExamModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (!modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                currentExamId = null;
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/admin/tests.blade.php ENDPATH**/ ?>