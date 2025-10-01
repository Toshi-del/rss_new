<!DOCTYPE html>
     <html>
     <head>
         <meta charset="utf-8">
         <title>Registration Invitation</title>
     </head>
     <body>
         <h1>Welcome to RSS Citi Health Services!</h1>
         <p>Dear <?php echo e($name); ?>,</p>
         <p>Congratulations! You have passed your pre-employment medical examination.</p>
         <p>
             <a href="<?php echo e(route('register', ['email' => $email, 'type' => 'patient', 'record_id' => $record_id])); ?>">
                 Complete Registration
             </a>
         </p>
         <p>Thanks,<br><?php echo e(config('app.name')); ?></p>
     </body>
     </html><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/emails/registration-invitation.blade.php ENDPATH**/ ?>