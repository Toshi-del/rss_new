<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== EMAIL SETUP GUIDE ===\n\n";

echo "❌ PROBLEM: Emails are not being sent because the mailer is configured to use 'log' driver.\n";
echo "✅ SOLUTION: You need to create a .env file with proper email configuration.\n\n";

echo "📧 CURRENT CONFIGURATION:\n";
echo "- Mail Driver: " . config('mail.default') . " (This should be 'smtp')\n";
echo "- SMTP Host: " . config('mail.mailers.smtp.host') . "\n";
echo "- SMTP Port: " . config('mail.mailers.smtp.port') . "\n";
echo "- From Address: " . config('mail.from.address') . "\n";
echo "- From Name: " . config('mail.from.name') . "\n\n";

echo "🔧 STEPS TO FIX:\n\n";

echo "1. Create a .env file in your project root with these settings:\n\n";

echo "For Gmail (Recommended):\n";
echo "----------------------------------------\n";
echo "MAIL_MAILER=smtp\n";
echo "MAIL_HOST=smtp.gmail.com\n";
echo "MAIL_PORT=587\n";
echo "MAIL_USERNAME=your-email@gmail.com\n";
echo "MAIL_PASSWORD=your-app-password\n";
echo "MAIL_ENCRYPTION=tls\n";
echo "MAIL_FROM_ADDRESS=your-email@gmail.com\n";
echo "MAIL_FROM_NAME=\"RSS Citi Health Services\"\n";
echo "----------------------------------------\n\n";

echo "2. For Gmail setup:\n";
echo "   a. Enable 2-Factor Authentication on your Google account\n";
echo "   b. Generate an App Password: Google Account → Security → App passwords\n";
echo "   c. Use the App Password (not your regular password) in MAIL_PASSWORD\n\n";

echo "3. Alternative - Use Mailtrap for testing:\n";
echo "----------------------------------------\n";
echo "MAIL_MAILER=smtp\n";
echo "MAIL_HOST=sandbox.smtp.mailtrap.io\n";
echo "MAIL_PORT=2525\n";
echo "MAIL_USERNAME=your-mailtrap-username\n";
echo "MAIL_PASSWORD=your-mailtrap-password\n";
echo "MAIL_ENCRYPTION=tls\n";
echo "MAIL_FROM_ADDRESS=test@mailtrap.io\n";
echo "MAIL_FROM_NAME=\"RSS Citi Health Services\"\n";
echo "----------------------------------------\n\n";

echo "4. After creating .env file, run:\n";
echo "   php artisan config:clear\n";
echo "   php artisan config:cache\n\n";

echo "5. Test the email functionality again.\n\n";

echo "📋 QUICK TEST COMMANDS:\n";
echo "php artisan tinker\n";
echo "Mail::raw('Test email', function(\$message) { \$message->to('your-email@example.com')->subject('Test'); });\n\n";

echo "=== END GUIDE ===\n";
