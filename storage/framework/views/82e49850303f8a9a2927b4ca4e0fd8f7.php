<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Register - RSS Citi Health Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <style>
        .page-transition { position: fixed; inset: 0; background-color: #ffffff; z-index: 50; opacity: 0; pointer-events: none; transition: opacity .3s ease-in-out; }
        .page-transition.active { opacity: .5; pointer-events: all; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center space-x-2 text-xl font-bold text-blue-600 hover:text-blue-700">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-md grid place-items-center">
                        <i class="fa-solid fa-wave-square text-white text-sm"></i>
                    </div>
                    <span class="hidden sm:block">RSS Citi Health Services</span>
                </a>
                <div class="flex items-center space-x-4">
                    <a href="<?php echo e(route('login')); ?>" class="text-gray-700 hover:text-blue-600 font-medium">Login</a>
                    <a href="/" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r <?php echo e(($isOpd ?? false) ? 'from-green-600 to-green-700' : (($isCorporate ?? false) ? 'from-blue-600 to-indigo-600' : 'from-blue-600 to-indigo-600')); ?> text-white p-8 text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl grid place-items-center">
                        <i class="fa-solid <?php echo e(($isOpd ?? false) ? 'fa-user' : (($isCorporate ?? false) ? 'fa-building' : 'fa-user-plus')); ?> text-2xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold">RSS Citi Health Services</h1>
                </div>
                <h2 class="text-2xl font-semibold mb-2">
                    <?php if($isOpd ?? false): ?>
                        OPD Walk-in Registration
                    <?php elseif($isCorporate ?? false): ?>
                        Corporate Registration
                    <?php else: ?>
                        Create Your Account
                    <?php endif; ?>
                </h2>
                <p class="<?php echo e(($isOpd ?? false) ? 'text-green-100' : (($isCorporate ?? false) ? 'text-blue-100' : 'text-blue-100')); ?>">
                    <?php if($isOpd ?? false): ?>
                        Quick registration for walk-in patients
                    <?php elseif($isCorporate ?? false): ?>
                        Register your organization for healthcare services
                    <?php else: ?>
                        Join our healthcare platform and take control of your health
                    <?php endif; ?>
                </p>
            </div>
            
            <!-- Form Content -->
            <div class="p-8">
                <!-- Duplicate Prevention Notice -->
                <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="flex items-start">
                        <i class="fa-solid fa-shield-halved text-blue-600 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold text-blue-800 mb-1">Account Security</h4>
                            <p class="text-sm text-blue-700">We prevent duplicate accounts with the same name and contact information to protect your data and ensure account integrity.</p>
                        </div>
                    </div>
                </div>
                
                <?php 
                    $isCorporate = request('corporate') == 1 || ($isCorporateRegistration ?? false);
                    $isOpd = request('opd') == 1 || ($isOpdRegistration ?? false);
                ?>
                <form method="POST" action="<?php echo e(route('register.attempt')); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <?php if($isOpd ?? false): ?>
                        <input type="hidden" name="opd" value="1">
                    <?php endif; ?>
                    <?php if($isCorporate ?? false): ?>
                        <input type="hidden" name="corporate" value="1">
                    <?php endif; ?>
                    
                    <!-- Personal Information Section -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fa-solid fa-user text-blue-600 mr-2"></i>
                            Personal Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label for="fname" class="block text-sm font-semibold text-gray-700 mb-2">First Name *</label>
                                <div class="relative">
                                    <input type="text" name="fname" id="fname" value="<?php echo e(old('fname')); ?>" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['fname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Enter your first name">
                                    <i class="fa-solid fa-user absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <?php $__errorArgs = ['fname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="lname" class="block text-sm font-semibold text-gray-700 mb-2">Last Name *</label>
                                <div class="relative">
                                    <input type="text" name="lname" id="lname" value="<?php echo e(old('lname')); ?>" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['lname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Enter your last name">
                                    <i class="fa-solid fa-user absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <?php $__errorArgs = ['lname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="mname" class="block text-sm font-semibold text-gray-700 mb-2">Middle Name</label>
                                <div class="relative">
                                    <input type="text" name="mname" id="mname" value="<?php echo e(old('mname')); ?>" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['mname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Enter your middle name">
                                    <i class="fa-solid fa-user absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <?php $__errorArgs = ['mname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fa-solid fa-address-book text-blue-600 mr-2"></i>
                            Contact Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                <div class="relative">
                                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Enter your email address">
                                    <i class="fa-solid fa-envelope absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                                <div class="relative">
                                    <input type="tel" name="phone" id="phone" value="<?php echo e(old('phone')); ?>" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Enter your phone number">
                                    <i class="fa-solid fa-phone absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="birthday" class="block text-sm font-semibold text-gray-700 mb-2">Birthday *</label>
                            <div class="relative">
                                <input type="date" name="birthday" id="birthday" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['birthday'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('birthday')); ?>">
                                <i class="fa-solid fa-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            <?php $__errorArgs = ['birthday'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                    <?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Role-specific Information Section -->
                    <?php if($isOpd ?? false): ?>
                        <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fa-solid fa-user text-green-600 mr-2"></i>
                                OPD Walk-in Patient Information
                            </h3>
                            
                            <div class="p-4 bg-green-100 rounded-lg">
                                <p class="text-sm text-green-800 flex items-start">
                                    <i class="fa-solid fa-info-circle mr-2 mt-0.5"></i>
                                    <span>By registering as an OPD patient, you will have quick access to walk-in services from 8:00 AM to 5:00 PM, Monday through Saturday. No appointment necessary for general consultations.</span>
                                </p>
                            </div>
                        </div>
                    <?php elseif($isCorporate ?? false): ?>
                        <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fa-solid fa-building text-blue-600 mr-2"></i>
                                Company Information
                            </h3>
                            
                            <div>
                                <label for="company" class="block text-sm font-semibold text-gray-700 mb-2">Company Name *</label>
                                <div class="relative">
                                    <input type="text" name="company" id="company" value="<?php echo e(old('company')); ?>" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Enter your company name">
                                    <i class="fa-solid fa-building absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <?php $__errorArgs = ['company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                           
                            <div class="mt-4 p-4 bg-blue-100 rounded-lg">
                                <p class="text-sm text-blue-800 flex items-start">
                                    <i class="fa-solid fa-info-circle mr-2 mt-0.5"></i>
                                    <span>By registering, you will be assigned the "Company" role and can manage your organization's health records.</span>
                                </p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fa-solid fa-building text-blue-600 mr-2"></i>
                                Company Affiliation (Optional)
                            </h3>
                            
                            <div>
                                <label for="company" class="block text-sm font-semibold text-gray-700 mb-2">Company</label>
                                <div class="relative">
                                    <input type="text" name="company" id="company" value="<?php echo e(old('company')); ?>" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Enter your company name (optional)">
                                    <i class="fa-solid fa-building absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <?php $__errorArgs = ['company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div class="mt-4 p-4 bg-gray-100 rounded-lg">
                                <p class="text-sm text-gray-700 flex items-start">
                                    <i class="fa-solid fa-info-circle mr-2 mt-0.5"></i>
                                    <span>By registering, you will be assigned the "Patient" role by default. Other roles (Admin, Company, Doctor, Med Technician) can be assigned by administrators.</span>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Security Section -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fa-solid fa-lock text-blue-600 mr-2"></i>
                            Security
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password *</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Create a strong password">
                                    <i class="fa-solid fa-lock absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password *</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                           placeholder="Confirm your password">
                                    <i class="fa-solid fa-lock absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit" class="w-full bg-gradient-to-r <?php echo e(($isOpd ?? false) ? 'from-green-600 to-green-700 hover:from-green-700 hover:to-green-800' : (($isCorporate ?? false) ? 'from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700' : 'from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700')); ?> text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <i class="fa-solid <?php echo e(($isOpd ?? false) ? 'fa-user' : (($isCorporate ?? false) ? 'fa-building' : 'fa-user-plus')); ?> mr-2"></i>
                            <?php if($isOpd ?? false): ?>
                                Register as OPD Patient
                            <?php elseif($isCorporate ?? false): ?>
                                Register Company
                            <?php else: ?>
                                Create Account
                            <?php endif; ?>
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Already have an account? 
                        <a href="<?php echo e(route('login')); ?>" class="text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Transition Element -->
    <div class="page-transition"></div>

    <script>
        // Page transitions
        function initPageTransitions(){ 
            const links=document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"]):not([onclick])'); 
            links.forEach(link=>{ 
                link.addEventListener('click',e=>{ 
                    if(link.hostname===window.location.hostname){ 
                        e.preventDefault(); 
                        const t=document.querySelector('.page-transition'); 
                        t.classList.add('active'); 
                        document.body.style.opacity='0.8'; 
                        setTimeout(()=>{ window.location.href=link.href; },300); 
                    } 
                }); 
            }); 
            window.addEventListener('pageshow',()=>{ 
                document.body.style.opacity='1'; 
                document.querySelector('.page-transition').classList.remove('active'); 
            }); 
        }
        
        document.addEventListener('DOMContentLoaded',()=>{ 
            initPageTransitions(); 
        });
    </script>
</body>
</html> <?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/auth/register.blade.php ENDPATH**/ ?>