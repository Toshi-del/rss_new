<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyPreEmploymentController;
use App\Http\Controllers\CompanyAppointmentController;
use App\Http\Controllers\CompanyAccountInvitationController;

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PatientController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Role-based Dashboard Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/patients', [AdminController::class, 'patients'])->name('admin.patients');
    Route::get('/admin/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::get('/admin/pre-employment', [AdminController::class, 'preEmployment'])->name('admin.pre-employment');
    Route::get('/admin/tests', [AdminController::class, 'tests'])->name('admin.tests');
    Route::get('/admin/messages', [AdminController::class, 'messages'])->name('admin.messages');
    Route::get('/admin/messages/fetch', [AdminController::class, 'fetchMessages']);
    Route::post('/admin/messages/send', [AdminController::class, 'sendMessage']);
    Route::post('/admin/messages/mark-read', [AdminController::class, 'markAsRead']);
    Route::get('/admin/chat-users', [AdminController::class, 'chatUsers']);
    Route::get('/admin/report', [AdminController::class, 'report'])->name('admin.report');
    Route::post('admin/appointments/{id}/approve', [App\Http\Controllers\AdminController::class, 'approveAppointment'])->name('admin.appointments.approve');
    Route::post('admin/appointments/{id}/decline', [App\Http\Controllers\AdminController::class, 'declineAppointment'])->name('admin.appointments.decline');
    Route::post('admin/pre-employment/{id}/approve', [App\Http\Controllers\AdminController::class, 'approvePreEmployment'])->name('admin.pre-employment.approve');
    Route::post('admin/pre-employment/{id}/decline', [App\Http\Controllers\AdminController::class, 'declinePreEmployment'])->name('admin.pre-employment.decline');
Route::post('admin/pre-employment/{id}/send-email', [App\Http\Controllers\AdminController::class, 'sendRegistrationEmail'])->name('admin.pre-employment.send-email');
Route::post('admin/fix-invalid-emails', [App\Http\Controllers\AdminController::class, 'fixInvalidEmails'])->name('admin.fix-invalid-emails');
Route::patch('admin/pre-employment/{id}/update-email', [App\Http\Controllers\AdminController::class, 'updateRecordEmail'])->name('admin.pre-employment.update-email');
    Route::get('/admin/accounts-and-patients', [AdminController::class, 'companyAccountsAndPatients'])->name('admin.accounts-and-patients');
});

Route::middleware(['auth', 'role:company'])->group(function () {
    Route::get('/company/dashboard', [CompanyController::class, 'dashboard'])->name('company.dashboard');
    
    // Settings Routes
    Route::get('/company/settings', [CompanyController::class, 'settings'])->name('company.settings');
    Route::put('/company/settings', [CompanyController::class, 'updateSettings'])->name('company.settings.update');
    
    // Medical Results Routes
    Route::get('/company/medical-results', [CompanyController::class, 'medicalResults'])->name('company.medical-results');
    
    // Pre-Employment Routes
    Route::get('/company/pre-employment', [CompanyPreEmploymentController::class, 'index'])->name('company.pre-employment.index');
    Route::get('/company/pre-employment/create', [CompanyPreEmploymentController::class, 'create'])->name('company.pre-employment.create');
    Route::post('/company/pre-employment', [CompanyPreEmploymentController::class, 'store'])->name('company.pre-employment.store');
    Route::get('/company/pre-employment/{id}', [CompanyPreEmploymentController::class, 'show'])->name('company.pre-employment.show');
    
    // Appointment Routes
    Route::get('/company/appointments', [CompanyAppointmentController::class, 'index'])->name('company.appointments.index');
    Route::get('/company/appointments/create', [CompanyAppointmentController::class, 'create'])->name('company.appointments.create');
    Route::post('/company/appointments', [CompanyAppointmentController::class, 'store'])->name('company.appointments.store');
    Route::get('/company/appointments/{appointment}', [CompanyAppointmentController::class, 'show'])->name('company.appointments.show');
    Route::get('/company/appointments/{appointment}/edit', [CompanyAppointmentController::class, 'edit'])->name('company.appointments.edit');
    Route::put('/company/appointments/{appointment}', [CompanyAppointmentController::class, 'update'])->name('company.appointments.update');
    Route::delete('/company/appointments/{appointment}', [CompanyAppointmentController::class, 'destroy'])->name('company.appointments.destroy');
    Route::get('/company/appointments/events', [CompanyAppointmentController::class, 'events'])->name('company.appointments.events');
    
    // Account Invitation Routes
    Route::get('/company/account-invitations', [CompanyAccountInvitationController::class, 'index'])->name('company.account-invitations.index');
    Route::get('/company/account-invitations/create', [CompanyAccountInvitationController::class, 'create'])->name('company.account-invitations.create');
    Route::post('/company/account-invitations', [CompanyAccountInvitationController::class, 'store'])->name('company.account-invitations.store');
    Route::delete('/company/account-invitations/{invitation}', [CompanyAccountInvitationController::class, 'destroy'])->name('company.account-invitations.destroy');
    
    // Company Chat Routes
    Route::get('/company/messages', [CompanyController::class, 'messages'])->name('company.messages');
    Route::get('/company/messages/fetch', [CompanyController::class, 'fetchMessages']);
    Route::post('/company/messages/send', [CompanyController::class, 'sendMessage']);
    Route::post('/company/messages/mark-read', [CompanyController::class, 'markAsRead']);
    Route::get('/company/chat-users', [CompanyController::class, 'chatUsers']);
});



// Debug route to test authentication
Route::get('/debug-auth', function() {
    if (Auth::check()) {
        $user = Auth::user();
        return response()->json([
            'authenticated' => true,
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'has_company_role' => $user->hasRole('company')
        ]);
    } else {
        return response()->json([
            'authenticated' => false
        ]);
    }
});

Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/pre-employment', [DoctorController::class, 'preEmployment'])->name('doctor.pre-employment');
    Route::get('/doctor/pre-employment/{id}/edit', [DoctorController::class, 'editPreEmployment'])->name('doctor.pre-employment.edit');
    Route::patch('/doctor/pre-employment/{id}', [DoctorController::class, 'updatePreEmployment'])->name('doctor.pre-employment.update');
    Route::get('/doctor/annual-physical', [DoctorController::class, 'annualPhysical'])->name('doctor.annual-physical');
    Route::get('/doctor/annual-physical/{id}/edit', [DoctorController::class, 'editAnnualPhysical'])->name('doctor.annual-physical.edit');
    Route::patch('/doctor/annual-physical/{id}', [DoctorController::class, 'updateAnnualPhysical'])->name('doctor.annual-physical.update');
    Route::get('/doctor/pre-employment/{record}/examination', [DoctorController::class, 'editExaminationByRecordId'])->name('doctor.pre-employment.examination.edit');
    
    // Medical Checklist Routes
    Route::get('/doctor/medical-checklist/pre-employment/{recordId}', [DoctorController::class, 'showMedicalChecklistPreEmployment'])->name('doctor.medical-checklist.pre-employment');
    Route::get('/doctor/medical-checklist/annual-physical/{patientId}', [DoctorController::class, 'showMedicalChecklistAnnualPhysical'])->name('doctor.medical-checklist.annual-physical');
    Route::post('/doctor/medical-checklist', [DoctorController::class, 'storeMedicalChecklist'])->name('doctor.medical-checklist.store');
    Route::patch('/doctor/medical-checklist/{id}', [DoctorController::class, 'updateMedicalChecklist'])->name('doctor.medical-checklist.update');
    
    // Doctor Chat Routes
    Route::get('/doctor/messages', [DoctorController::class, 'messages'])->name('doctor.messages');
    Route::get('/doctor/messages/fetch', [DoctorController::class, 'fetchMessages']);
    Route::post('/doctor/messages/send', [DoctorController::class, 'sendMessage']);
    Route::post('/doctor/messages/mark-read', [DoctorController::class, 'markAsRead']);
    Route::get('/doctor/chat-users', [DoctorController::class, 'chatUsers']);
});

// Debug route to check users (temporary)
Route::get('/debug-users', function() {
    $users = \App\Models\User::select('id', 'fname', 'lname', 'role', 'company')->get();
    return response()->json($users);
});

Route::middleware(['auth', 'role:nurse'])->group(function () {
    Route::get('/nurse/dashboard', [NurseController::class, 'dashboard'])->name('nurse.dashboard');
    Route::get('/nurse/appointments', [NurseController::class, 'appointments'])->name('nurse.appointments');
    Route::get('/nurse/pre-employment', [NurseController::class, 'preEmployment'])->name('nurse.pre-employment');
    Route::get('/nurse/annual-physical', [NurseController::class, 'annualPhysical'])->name('nurse.annual-physical');
    
    // Nurse Pre-Employment Edit Routes
    Route::get('/nurse/pre-employment/{id}/edit', [NurseController::class, 'editPreEmployment'])->name('nurse.pre-employment.edit');
    Route::patch('/nurse/pre-employment/{id}', [NurseController::class, 'updatePreEmployment'])->name('nurse.pre-employment.update');
    
    // Nurse Annual Physical Edit Routes
    Route::get('/nurse/annual-physical/{id}/edit', [NurseController::class, 'editAnnualPhysical'])->name('nurse.annual-physical.edit');
    Route::patch('/nurse/annual-physical/{id}', [NurseController::class, 'updateAnnualPhysical'])->name('nurse.annual-physical.update');
    
    // Nurse Medical Checklist Routes
    Route::get('/nurse/medical-checklist/pre-employment/{recordId}', [NurseController::class, 'showMedicalChecklistPreEmployment'])->name('nurse.medical-checklist.pre-employment');
    Route::get('/nurse/medical-checklist/annual-physical/{patientId}', [NurseController::class, 'showMedicalChecklistAnnualPhysical'])->name('nurse.medical-checklist.annual-physical');
    Route::post('/nurse/medical-checklist', [NurseController::class, 'storeMedicalChecklist'])->name('nurse.medical-checklist.store');
    Route::patch('/nurse/medical-checklist/{id}', [NurseController::class, 'updateMedicalChecklist'])->name('nurse.medical-checklist.update');

    // Nurse Messaging Routes
    Route::get('/nurse/messages', [NurseController::class, 'messages'])->name('nurse.messages');
    Route::get('/nurse/messages/fetch', [NurseController::class, 'fetchMessages']);
    Route::post('/nurse/messages/send', [NurseController::class, 'sendMessage']);
    Route::post('/nurse/messages/mark-read', [NurseController::class, 'markAsRead']);
    Route::get('/nurse/chat-users', [NurseController::class, 'chatUsers']);
});

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient/profile', [PatientController::class, 'profile'])->name('patient.profile');
    Route::put('/patient/profile', [PatientController::class, 'updateProfile'])->name('patient.profile.update');
});



// Public invitation routes
Route::get('/invitation/{token}', [App\Http\Controllers\CompanyAccountInvitationController::class, 'accept'])->name('invitation.accept');
Route::post('/invitation/{token}', [App\Http\Controllers\CompanyAccountInvitationController::class, 'processInvitation'])->name('invitation.process');

// Default route - redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});
