<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PreEmploymentRecord;
use App\Mail\RegistrationInvitation;
use Illuminate\Support\Facades\Mail;

echo "=== EMAIL SENDING TEST ===\n\n";

// Check current configuration
echo "📧 Current Mail Configuration:\n";
echo "- Driver: " . config('mail.default') . "\n";
echo "- Host: " . config('mail.mailers.smtp.host') . "\n";
echo "- Port: " . config('mail.mailers.smtp.port') . "\n";
echo "- Username: " . (config('mail.mailers.smtp.username') ? 'Set' : 'Not set') . "\n";
echo "- Password: " . (config('mail.mailers.smtp.password') ? 'Set' : 'Not set') . "\n";
echo "- From: " . config('mail.from.address') . "\n";
echo "- From Name: " . config('mail.from.name') . "\n\n";

if (config('mail.default') === 'log') {
    echo "❌ ERROR: Mail driver is set to 'log'. Emails will only be logged, not sent.\n";
    echo "Please create a .env file with proper SMTP configuration.\n";
    exit(1);
}

// Get test record
$testRecord = PreEmploymentRecord::where('status', 'approved')
    ->whereNotNull('email')
    ->first();

if (!$testRecord) {
    echo "❌ No approved pre-employment records found.\n";
    exit(1);
}

echo "📋 Testing with record:\n";
echo "- ID: " . $testRecord->id . "\n";
echo "- Name: " . ($testRecord->full_name ?? $testRecord->first_name . ' ' . $testRecord->last_name) . "\n";
echo "- Email: " . $testRecord->email . "\n\n";

echo "📤 Sending test email...\n";

try {
    Mail::to($testRecord->email)->send(new RegistrationInvitation(
        $testRecord->email,
        $testRecord->full_name ?? ($testRecord->first_name . ' ' . $testRecord->last_name),
        $testRecord->id
    ));
    
    echo "✅ Email sent successfully!\n";
    echo "Check the recipient's inbox: " . $testRecord->email . "\n";
    echo "Subject: Complete Your Registration - RSS Citi Health Services\n";
    
} catch (\Exception $e) {
    echo "❌ Email sending failed:\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nCommon issues:\n";
    echo "1. Check your .env file configuration\n";
    echo "2. Verify SMTP credentials\n";
    echo "3. For Gmail: Use App Password, not regular password\n";
    echo "4. Check firewall/antivirus blocking SMTP\n";
}

echo "\n=== TEST COMPLETE ===\n";
