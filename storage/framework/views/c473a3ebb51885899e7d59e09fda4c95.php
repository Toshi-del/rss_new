<?php $__env->startSection('title', 'Edit Pre-Employment Examination'); ?>
<?php $__env->startSection('page-title', 'Edit Pre-Employment Examination'); ?>
<?php $__env->startSection('page-description', 'Update and manage employment medical screening results'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8" style="font-family: 'Poppins', sans-serif;">
    
    <!-- Success Message -->
    <?php if(session('success')): ?>
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-emerald-600">
        <div class="px-8 py-6 bg-emerald-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-white font-medium"><?php echo e(session('success')); ?></p>
                    </div>
                </div>
                <button type="button" class="text-emerald-200 hover:text-white transition-colors duration-200" onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-violet-600">
        <div class="px-8 py-6 bg-violet-600">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-briefcase mr-3"></i>Pre-Employment Medical Examination
                    </h1>
                    <p class="text-violet-100">Employment medical screening and health assessment certificate</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-violet-700 rounded-lg px-4 py-2">
                        <p class="text-violet-200 text-sm font-medium">Exam ID</p>
                        <p class="text-white text-lg font-bold">#<?php echo e($examination->id); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Form Container -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Applicant Information Section -->
        <?php if($examination->preEmploymentRecord): ?>
        <div class="px-8 py-6 bg-violet-600 border-l-4 border-violet-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-user-tie mr-3"></i>Applicant Information
                    </h2>
                    <p class="text-violet-100 mt-1">Job applicant details and company information</p>
                </div>
            </div>
        </div>
        
        <div class="p-8 bg-violet-50">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg p-4 border-l-4 border-violet-600 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Full Name</label>
                    <div class="text-lg font-bold text-violet-900"><?php echo e($examination->preEmploymentRecord->full_name ?? ($examination->preEmploymentRecord->first_name . ' ' . $examination->preEmploymentRecord->last_name)); ?></div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-emerald-600 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Age</label>
                    <div class="text-lg font-bold text-emerald-900"><?php echo e($examination->preEmploymentRecord->age ?? 'N/A'); ?> years</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-blue-600 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Sex</label>
                    <div class="text-lg font-bold text-blue-900"><?php echo e($examination->preEmploymentRecord->sex ? ucfirst($examination->preEmploymentRecord->sex) : 'N/A'); ?></div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-orange-600 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Company</label>
                    <div class="text-sm font-semibold text-orange-900 truncate"><?php echo e($examination->preEmploymentRecord->company_name ?? 'N/A'); ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Form Section -->
        <div class="p-8">
            <form action="<?php echo e(route('doctor.pre-employment.update', $examination->id)); ?>" method="POST" class="space-y-8">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                
                <!-- Medical History Section -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-emerald-600">
                    <div class="px-6 py-4 bg-emerald-600">
                        <div class="flex items-center">
                            <i class="fas fa-notes-medical text-white text-xl mr-3"></i>
                            <h3 class="text-lg font-bold text-white" style="font-family: 'Poppins', sans-serif;">Medical History Review</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-emerald-50">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-hospital mr-2 text-emerald-600"></i>Illness / Hospitalization
                            </label>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 min-h-[4rem] text-sm text-gray-700">
                                <?php echo e($preEmployment->illness_history ?: 'No illness or hospitalization history recorded'); ?>

                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user-injured mr-2 text-orange-600"></i>Accidents / Operations
                            </label>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 min-h-[4rem] text-sm text-gray-700">
                                <?php echo e($preEmployment->accidents_operations ?: 'No accidents or surgical operations recorded'); ?>

                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clipboard-list mr-2 text-blue-600"></i>Past Medical History
                            </label>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 min-h-[4rem] text-sm text-gray-700">
                                <?php echo e($preEmployment->past_medical_history ?: 'No past medical conditions recorded'); ?>

                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <label class="block text-sm font-semibold text-gray-700 mb-4">
                            <i class="fas fa-users mr-2 text-violet-600"></i>Family Medical History
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            <?php
                                $family = $preEmployment->family_history ?? [];
                                $options = ['asthma','arthritis','migraine','diabetes','heart_disease','tuberculosis','allergies','anemia','cancer','insanity','hypertension','epilepsy'];
                            ?>
                            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="inline-flex items-center p-3 rounded-lg border transition-colors duration-200 <?php echo e(in_array($opt, $family ?? []) ? 'bg-emerald-100 border-emerald-300 text-emerald-800' : 'bg-gray-50 border-gray-200 text-gray-600'); ?>">
                                    <input type="checkbox" name="family_history[]" value="<?php echo e($opt); ?>" class="mr-3 text-emerald-600 focus:ring-emerald-500" <?php echo e(in_array($opt, $family ?? []) ? 'checked' : ''); ?> disabled>
                                    <span class="text-sm font-medium"><?php echo e(str_replace('_', ' ', ucwords($opt))); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- Personal History Section -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-600">
                    <div class="px-6 py-4 bg-blue-600">
                        <div class="flex items-center">
                            <i class="fas fa-user-check text-white text-xl mr-3"></i>
                            <h3 class="text-lg font-bold text-white" style="font-family: 'Poppins', sans-serif;">Personal History & Habits</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-blue-50">
                    
                    <div class="bg-white rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <?php
                                $habits = $preEmployment->personal_habits ?? [];
                                $habitOptions = [
                                    'alcohol' => ['icon' => 'fas fa-wine-bottle', 'color' => 'red'],
                                    'cigarettes' => ['icon' => 'fas fa-smoking', 'color' => 'orange'],
                                    'coffee_tea' => ['icon' => 'fas fa-coffee', 'color' => 'amber']
                                ];
                            ?>
                            <?php $__currentLoopData = $habitOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $habit => $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center p-4 rounded-lg border transition-colors duration-200 <?php echo e(in_array($habit, $habits ?? []) ? 'bg-blue-100 border-blue-300' : 'bg-gray-50 border-gray-200'); ?>">
                                    <i class="<?php echo e($config['icon']); ?> text-<?php echo e($config['color']); ?>-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-700 mr-3"><?php echo e(str_replace('_', ' ', ucwords($habit))); ?></span>
                                    <i class="fas <?php echo e(in_array($habit, $habits ?? []) ? 'fa-check-circle text-green-600' : 'fa-times-circle text-gray-400'); ?>"></i>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- Physical Examination Section -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-orange-600">
                    <div class="px-6 py-4 bg-orange-600">
                        <div class="flex items-center">
                            <i class="fas fa-stethoscope text-white text-xl mr-3"></i>
                            <h3 class="text-lg font-bold text-white" style="font-family: 'Poppins', sans-serif;">Physical Examination Results</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-orange-50">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php 
                            $phys = $preEmployment->physical_exam ?? [];
                            $vitals = [
                                'temp' => ['label' => 'Temperature', 'icon' => 'fas fa-thermometer-half', 'unit' => '°C', 'color' => 'red'],
                                'height' => ['label' => 'Height', 'icon' => 'fas fa-ruler-vertical', 'unit' => 'cm', 'color' => 'blue'],
                                'heart_rate' => ['label' => 'Heart Rate', 'icon' => 'fas fa-heartbeat', 'unit' => 'bpm', 'color' => 'pink'],
                                'weight' => ['label' => 'Weight', 'icon' => 'fas fa-weight', 'unit' => 'kg', 'color' => 'green']
                            ];
                        ?>
                        <?php $__currentLoopData = $vitals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vital): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white rounded-lg p-4 border-l-4 border-<?php echo e($vital['color']); ?>-500">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="<?php echo e($vital['icon']); ?> text-<?php echo e($vital['color']); ?>-600 mr-2"></i><?php echo e($vital['label']); ?>

                                </label>
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                    <?php echo e($phys[$key] ?? 'Not recorded'); ?>

                                    <?php if(isset($phys[$key]) && $phys[$key]): ?>
                                        <span class="text-xs text-gray-500 ml-1"><?php echo e($vital['unit']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    </div>
                </div>
                <!-- Skin Identification Marks Section -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-pink-600">
                    <div class="px-6 py-4 bg-pink-600">
                        <div class="flex items-center">
                            <i class="fas fa-search text-white text-xl mr-3"></i>
                            <h3 class="text-lg font-bold text-white" style="font-family: 'Poppins', sans-serif;">Skin Identification Marks</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-pink-50">
                    
                    <div class="bg-white rounded-lg p-4">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-sm text-gray-700 min-h-[4rem]">
                            <?php echo e($preEmployment->skin_marks ?: 'No identifying marks, scars, or tattoos recorded'); ?>

                        </div>
                    </div>
                    </div>
                </div>
                <!-- Visual Assessment & Findings Section -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-indigo-600">
                    <div class="px-6 py-4 bg-indigo-600">
                        <div class="flex items-center">
                            <i class="fas fa-eye text-white text-xl mr-3"></i>
                            <h3 class="text-lg font-bold text-white" style="font-family: 'Poppins', sans-serif;">Visual Assessment & General Findings</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-indigo-50">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="bg-white rounded-lg p-4 border-l-4 border-blue-500">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-glasses mr-2 text-blue-600"></i>Visual Acuity
                            </label>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                <?php echo e($preEmployment->visual ?: 'Visual acuity not tested'); ?>

                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 border-l-4 border-green-500">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-palette mr-2 text-green-600"></i>Ishihara Test
                            </label>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                <?php echo e($preEmployment->ishihara_test ?: 'Color vision test not performed'); ?>

                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 border-l-4 border-purple-500">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clipboard-check mr-2 text-purple-600"></i>General Findings
                            </label>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                <?php echo e($preEmployment->findings ?: 'No significant findings recorded'); ?>

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- Laboratory Examination Report Section -->
                <div class="bg-teal-50 rounded-xl p-6 border-l-4 border-teal-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-flask text-teal-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-teal-900" style="font-family: 'Poppins', sans-serif;">Laboratory Examination Report</h3>
                    </div>
                    
                    <?php
                        $lab = $preEmployment->lab_report ?? [];
                        $labFields = [
                            'urinalysis' => ['icon' => 'fas fa-vial', 'color' => 'yellow'],
                            'cbc' => ['icon' => 'fas fa-tint', 'color' => 'red'],
                            'xray' => ['icon' => 'fas fa-x-ray', 'color' => 'gray'],
                            'fecalysis' => ['icon' => 'fas fa-microscope', 'color' => 'brown'],
                            'blood_chemistry' => ['icon' => 'fas fa-heartbeat', 'color' => 'pink'],
                            'others' => ['icon' => 'fas fa-plus-circle', 'color' => 'indigo']
                        ];
                    ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <?php $__currentLoopData = $labFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white rounded-lg p-4 border-l-4 border-<?php echo e($config['color']); ?>-500">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="<?php echo e($config['icon']); ?> text-<?php echo e($config['color']); ?>-600 mr-2"></i><?php echo e(str_replace('_', ' ', ucwords($field))); ?>

                                </label>
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                    <?php echo e(data_get($lab, $field, 'Test not performed')); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <!-- Additional Laboratory Tests -->
                    <div class="bg-white rounded-lg p-4">
                        <h4 class="text-md font-semibold text-gray-700 mb-4">
                            <i class="fas fa-plus-square text-teal-600 mr-2"></i>Additional Laboratory Tests
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-orange-500">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-shield-virus text-orange-600 mr-2"></i>HBsAg Screening
                                </label>
                                <div class="bg-white p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                    <?php echo e(data_get($lab, 'hbsag_screening', 'Screening not performed')); ?>

                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-purple-500">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-virus text-purple-600 mr-2"></i>HEPA A IGG & IGM
                                </label>
                                <div class="bg-white p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                    <?php echo e(data_get($lab, 'hepa_a_igg_igm', 'Test not performed')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Physical Findings Section -->
                <div class="bg-cyan-50 rounded-xl p-6 border-l-4 border-cyan-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-user-md text-cyan-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-cyan-900" style="font-family: 'Poppins', sans-serif;">Physical Examination Findings</h3>
                    </div>
                    
                    <?php
                        $physicalRows = [
                            'Neck' => ['icon' => 'fas fa-head-side-cough', 'color' => 'blue'],
                            'Chest-Breast Axilla' => ['icon' => 'fas fa-lungs', 'color' => 'green'],
                            'Lungs' => ['icon' => 'fas fa-lungs-virus', 'color' => 'teal'],
                            'Heart' => ['icon' => 'fas fa-heartbeat', 'color' => 'red'],
                            'Abdomen' => ['icon' => 'fas fa-stomach', 'color' => 'orange'],
                            'Extremities' => ['icon' => 'fas fa-hand-paper', 'color' => 'purple'],
                            'Anus-Rectum' => ['icon' => 'fas fa-circle', 'color' => 'gray'],
                            'GUT' => ['icon' => 'fas fa-pills', 'color' => 'yellow'],
                            'Inguinal / Genital' => ['icon' => 'fas fa-user-circle', 'color' => 'pink']
                        ];
                    ?>
                    
                    <div class="space-y-4">
                        <?php $__currentLoopData = $physicalRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row => $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                <div class="flex items-center">
                                    <i class="<?php echo e($config['icon']); ?> text-<?php echo e($config['color']); ?>-600 mr-3"></i>
                                    <span class="font-semibold text-gray-700"><?php echo e($row); ?></span>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Result</label>
                                    <input type="text" name="physical_findings[<?php echo e($row); ?>][result]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-sm" value="<?php echo e(old('physical_findings.'.$row.'.result', data_get($preEmployment->physical_findings, $row.'.result', ''))); ?>" placeholder="Enter result">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Findings</label>
                                    <input type="text" name="physical_findings[<?php echo e($row); ?>][findings]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-sm" value="<?php echo e(old('physical_findings.'.$row.'.findings', data_get($preEmployment->physical_findings, $row.'.findings', ''))); ?>" placeholder="Enter findings">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <!-- Laboratory Test Results Section -->
                <div class="bg-lime-50 rounded-xl p-6 border-l-4 border-lime-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-microscope text-lime-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-lime-900" style="font-family: 'Poppins', sans-serif;">Laboratory Test Results</h3>
                    </div>
                    
                    <?php
                        $labRows = [
                            'Chest X-Ray' => ['icon' => 'fas fa-x-ray', 'color' => 'gray'],
                            'Urinalysis' => ['icon' => 'fas fa-vial', 'color' => 'yellow'],
                            'Fecalysis' => ['icon' => 'fas fa-microscope', 'color' => 'brown'],
                            'CBC' => ['icon' => 'fas fa-tint', 'color' => 'red'],
                            'Drug Test' => ['icon' => 'fas fa-pills', 'color' => 'orange'],
                            'HBsAg Screening' => ['icon' => 'fas fa-shield-virus', 'color' => 'purple'],
                            'HEPA A IGG & IGM' => ['icon' => 'fas fa-virus', 'color' => 'pink'],
                            'Others' => ['icon' => 'fas fa-plus-circle', 'color' => 'indigo']
                        ];
                    ?>
                    
                    <div class="space-y-4">
                        <?php $__currentLoopData = $labRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row => $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                <div class="flex items-center">
                                    <i class="<?php echo e($config['icon']); ?> text-<?php echo e($config['color']); ?>-600 mr-3"></i>
                                    <span class="font-semibold text-gray-700"><?php echo e($row); ?></span>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Result</label>
                                    <?php
                                        $testKey = strtolower(str_replace([' ', '-', '&'], ['_', '_', '_'], $row));
                                        $testKey = str_replace('chest_x_ray', 'xray', $testKey);
                                        $testKey = str_replace('hepa_a_igg___igm', 'hepa_a_igg_igm', $testKey);
                                    ?>
                                    <input type="text" name="lab_report[<?php echo e($testKey); ?>]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 text-sm" value="<?php echo e(old('lab_report.'.$testKey, data_get($preEmployment->lab_report, $testKey, ''))); ?>" placeholder="Enter test result">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Findings</label>
                                    <?php
                                        $findingsKey = $testKey . '_findings';
                                    ?>
                                    <input type="text" name="lab_report[<?php echo e($findingsKey); ?>]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 text-sm" value="<?php echo e(old('lab_report.'.$findingsKey, data_get($preEmployment->lab_report, $findingsKey, ''))); ?>" placeholder="Enter findings">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <!-- ECG Section -->
                <div class="bg-red-50 rounded-xl p-6 border-l-4 border-red-600">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-heartbeat text-red-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-red-900" style="font-family: 'Poppins', sans-serif;">Electrocardiogram (ECG)</h3>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-chart-line text-red-600 mr-2"></i>ECG Results
                        </label>
                        <input type="text" name="ecg" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" value="<?php echo e(old('ecg', $preEmployment->ecg ?? '')); ?>" placeholder="Enter ECG findings and interpretation">
                    </div>
                </div>
                
                <!-- Physician Signature & Submit Section -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-gray-600">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-user-md text-gray-600 mr-3"></i>Physician Authorization
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Complete employment medical screening and authorize certificate</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                        <div class="bg-white rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-signature text-gray-600 mr-2"></i>Physician's Signature
                            </label>
                            <div class="border-b-2 border-gray-300 pb-4">
                                <p class="text-xs text-gray-500">Digital signature will be applied upon submission</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i class="fas fa-save mr-3"></i>
                                Save Medical Certificate
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.doctor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/doctor/pre-employment-edit.blade.php ENDPATH**/ ?>