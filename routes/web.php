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
    Route::get('/admin/report', [AdminController::class, 'report'])->name('admin.report');
    Route::post('admin/appointments/{id}/approve', [App\Http\Controllers\AdminController::class, 'approveAppointment'])->name('admin.appointments.approve');
    Route::post('admin/appointments/{id}/decline', [App\Http\Controllers\AdminController::class, 'declineAppointment'])->name('admin.appointments.decline');
    Route::post('admin/pre-employment/{id}/approve', [App\Http\Controllers\AdminController::class, 'approvePreEmployment'])->name('admin.pre-employment.approve');
    Route::post('admin/pre-employment/{id}/decline', [App\Http\Controllers\AdminController::class, 'declinePreEmployment'])->name('admin.pre-employment.decline');
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
    Route::get('/doctor/annual-physical', [DoctorController::class, 'annualPhysical'])->name('doctor.annual-physical');
});

Route::middleware(['auth', 'role:nurse'])->group(function () {
    Route::get('/nurse/dashboard', [NurseController::class, 'dashboard'])->name('nurse.dashboard');
    Route::get('/nurse/appointments', [NurseController::class, 'appointments'])->name('nurse.appointments');
    Route::get('/nurse/pre-employment', [NurseController::class, 'preEmployment'])->name('nurse.pre-employment');
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
