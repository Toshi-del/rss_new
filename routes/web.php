<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyPreEmploymentController;
use App\Http\Controllers\CompanyAppointmentController;
use App\Http\Controllers\EmployeeController;

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
});

Route::middleware(['auth', 'role:company'])->group(function () {
    Route::get('/company/dashboard', [CompanyController::class, 'dashboard'])->name('company.dashboard');
    
    // Settings Routes
    Route::get('/company/settings', [CompanyController::class, 'settings'])->name('company.settings');
    Route::put('/company/settings', [CompanyController::class, 'updateSettings'])->name('company.settings.update');
    
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
    
    // Employee Routes
    Route::get('/company/employees', [EmployeeController::class, 'index'])->name('company.employees.index');
    Route::get('/company/employees/create', [EmployeeController::class, 'create'])->name('company.employees.create');
    Route::post('/company/employees/generate-link', [EmployeeController::class, 'generateLink'])->name('company.employees.generate-link');
    Route::get('/company/employees/{id}', [EmployeeController::class, 'show'])->name('company.employees.show');
    Route::delete('/company/employees/{id}', [EmployeeController::class, 'destroy'])->name('company.employees.destroy');
    

});

// Public Employee Registration Routes (No authentication required)
Route::get('/company/employees/register', [EmployeeController::class, 'showRegisterForm'])->name('company.employees.register');
Route::post('/company/employees/register', [EmployeeController::class, 'register'])->name('company.employees.register.store');

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



// Default route - redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});
