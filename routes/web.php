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
use App\Http\Controllers\RadtechController;
use App\Http\Controllers\PleboController;
use App\Http\Controllers\RadiologistController;
use App\Http\Controllers\PathologistController;
use App\Http\Controllers\EcgtechController;
use App\Http\Controllers\OpdController;

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
    
    // Examination view and send routes
    Route::get('/admin/view-pre-employment-examination/{id}', [AdminController::class, 'viewPreEmploymentExamination'])->name('admin.view-pre-employment-examination');
    Route::get('/admin/view-annual-physical-examination/{id}', [AdminController::class, 'viewAnnualPhysicalExamination'])->name('admin.view-annual-physical-examination');
    Route::post('/admin/send-pre-employment-examination/{id}', [AdminController::class, 'sendPreEmploymentExamination'])->name('admin.send-pre-employment-examination');
    Route::post('/admin/send-annual-physical-examination/{id}', [AdminController::class, 'sendAnnualPhysicalExamination'])->name('admin.send-annual-physical-examination');
    
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
    Route::post('admin/pre-employment/send-all-emails', [AdminController::class, 'sendAllRegistrationEmails'])->name('admin.pre-employment.send-all-emails');
    Route::get('/admin/accounts-and-patients', [AdminController::class, 'companyAccountsAndPatients'])->name('admin.accounts-and-patients');
    Route::delete('/admin/company/{id}', [AdminController::class, 'deleteCompany'])->name('admin.delete-company');
    
    // Admin - Medical Staff Management
    Route::get('/admin/medical-staff', [AdminController::class, 'medicalStaff'])->name('admin.medical-staff');
    Route::post('/admin/medical-staff', [AdminController::class, 'storeMedicalStaff'])->name('admin.medical-staff.store');
    Route::put('/admin/medical-staff/{id}', [AdminController::class, 'updateMedicalStaff'])->name('admin.medical-staff.update');
    Route::delete('/admin/medical-staff/{id}', [AdminController::class, 'destroyMedicalStaff'])->name('admin.medical-staff.destroy');
    
    // Medical Test Management Routes
    Route::resource('admin/medical-test-categories', App\Http\Controllers\Admin\MedicalTestCategoryController::class);
    Route::resource('admin/medical-tests', App\Http\Controllers\Admin\MedicalTestController::class)->except(['index']);
    
    // Inventory Management Routes
    Route::resource('admin/inventory', App\Http\Controllers\Admin\InventoryController::class);

    // Admin OPD entries
    Route::get('/admin/opd', [AdminController::class, 'opd'])->name('admin.opd');
    Route::post('/admin/opd/{id}/approve', [AdminController::class, 'approveOpd'])->name('admin.opd.approve');
    Route::post('/admin/opd/{id}/decline', [AdminController::class, 'declineOpd'])->name('admin.opd.decline');
    Route::post('/admin/opd/{id}/done', [AdminController::class, 'markOpdDone'])->name('admin.opd.mark-done');
    Route::post('/admin/opd/{id}/send-results', [AdminController::class, 'sendOpdResults'])->name('admin.opd.send-results');
});

Route::middleware(['auth', 'role:company'])->group(function () {
    Route::get('/company/dashboard', [CompanyController::class, 'dashboard'])->name('company.dashboard');
    
    // Settings Routes
    Route::get('/company/settings', [CompanyController::class, 'settings'])->name('company.settings');
    Route::put('/company/settings', [CompanyController::class, 'updateSettings'])->name('company.settings.update');
    
    // Medical Results Routes
    Route::get('/company/medical-results', [CompanyController::class, 'medicalResults'])->name('company.medical-results');
    
    // Sent Results View Routes
    Route::get('/company/view-sent-pre-employment/{id}', [CompanyController::class, 'viewSentPreEmployment'])->name('company.view-sent-pre-employment');
    Route::get('/company/view-sent-annual-physical/{id}', [CompanyController::class, 'viewSentAnnualPhysical'])->name('company.view-sent-annual-physical');
    Route::get('/company/download-sent-pre-employment/{id}', [CompanyController::class, 'downloadSentPreEmployment'])->name('company.download-sent-pre-employment');
    Route::get('/company/download-sent-annual-physical/{id}', [CompanyController::class, 'downloadSentAnnualPhysical'])->name('company.download-sent-annual-physical');
    
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
    Route::post('/doctor/pre-employment/{record}/submit', [DoctorController::class, 'submitPreEmploymentByRecordId'])->name('doctor.pre-employment.by-record.submit');
    Route::get('/doctor/annual-physical/patient/{patientId}/edit', [DoctorController::class, 'editAnnualPhysicalByPatientId'])->name('doctor.annual-physical.by-patient.edit');
    Route::post('/doctor/annual-physical/patient/{patientId}/submit', [DoctorController::class, 'submitAnnualPhysicalByPatientId'])->name('doctor.annual-physical.by-patient.submit');
    
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

Route::middleware(['auth', 'role:opd'])->group(function () {
    Route::get('/opd/dashboard', [OpdController::class, 'dashboard'])->name('opd.dashboard');
    Route::get('/opd/medical-test-categories', [OpdController::class, 'medicalTestCategories'])->name('opd.medical-test-categories');
    Route::get('/opd/medical-tests', [OpdController::class, 'medicalTests'])->name('opd.medical-tests');
    Route::get('/opd/incoming-tests', [OpdController::class, 'incomingTests'])->name('opd.incoming-tests');
    Route::post('/opd/incoming-tests/add/{testId}', [OpdController::class, 'addIncomingTest'])->name('opd.incoming-tests.add');
    Route::post('/opd/incoming-tests/remove/{testId}', [OpdController::class, 'removeIncomingTest'])->name('opd.incoming-tests.remove');
    // OPD Result preview (UI only)
    Route::get('/opd/result', function(){
        return view('opd.result');
    })->name('opd.result');
});

// Debug route to check users (temporary)
Route::get('/debug-users', function() {
    $users = \App\Models\User::select('id', 'fname', 'lname', 'role', 'company')->get();
    return response()->json($users);
});

// Debug route to check patients for an appointment
Route::get('/debug-patients/{appointmentId}', function($appointmentId) {
    $appointment = App\Models\Appointment::with('patients')->find($appointmentId);
    if (!$appointment) {
        return 'Appointment not found';
    }
    
    return response()->json([
        'appointment_id' => $appointment->id,
        'patients_count' => $appointment->patients->count(),
        'patients' => $appointment->patients->map(function($patient) {
            return [
                'id' => $patient->id,
                'name' => $patient->first_name . ' ' . $patient->last_name,
                'email' => $patient->email,
                'appointment_id' => $patient->appointment_id
            ];
        }),
        'patients_data' => $appointment->patients_data
    ]);
});

Route::middleware(['auth', 'role:nurse'])->group(function () {
    Route::get('/nurse/dashboard', [NurseController::class, 'dashboard'])->name('nurse.dashboard');
    Route::get('/nurse/appointments', [NurseController::class, 'appointments'])->name('nurse.appointments');
    Route::get('/nurse/pre-employment', [NurseController::class, 'preEmployment'])->name('nurse.pre-employment');
    Route::get('/nurse/pre-employment/create', [NurseController::class, 'createPreEmployment'])->name('nurse.pre-employment.create');
    Route::post('/nurse/pre-employment', [NurseController::class, 'storePreEmployment'])->name('nurse.pre-employment.store');
    Route::get('/nurse/annual-physical', [NurseController::class, 'annualPhysical'])->name('nurse.annual-physical');
    Route::get('/nurse/annual-physical/create', [NurseController::class, 'createAnnualPhysical'])->name('nurse.annual-physical.create');
    Route::post('/nurse/annual-physical', [NurseController::class, 'storeAnnualPhysical'])->name('nurse.annual-physical.store');
    
    // Nurse Pre-Employment Edit Routes
    Route::get('/nurse/pre-employment/{id}/edit', [NurseController::class, 'editPreEmployment'])->name('nurse.pre-employment.edit');
    Route::patch('/nurse/pre-employment/{id}', [NurseController::class, 'updatePreEmployment'])->name('nurse.pre-employment.update');
    Route::post('/nurse/pre-employment/{recordId}/send', [NurseController::class, 'sendPreEmploymentToDoctor'])->name('nurse.pre-employment.send-to-doctor');
    
    // Nurse Annual Physical Edit Routes
    Route::get('/nurse/annual-physical/{id}/edit', [NurseController::class, 'editAnnualPhysical'])->name('nurse.annual-physical.edit');
    Route::patch('/nurse/annual-physical/{id}', [NurseController::class, 'updateAnnualPhysical'])->name('nurse.annual-physical.update');
    Route::post('/nurse/annual-physical/patient/{patientId}/send', [NurseController::class, 'sendAnnualPhysicalToDoctor'])->name('nurse.annual-physical.send-to-doctor');
    
    // Nurse Medical Checklist Routes
    Route::get('/nurse/medical-checklist/pre-employment/{recordId}', [NurseController::class, 'showMedicalChecklistPreEmployment'])->name('nurse.medical-checklist.pre-employment');
    Route::get('/nurse/medical-checklist/annual-physical/{patientId}', [NurseController::class, 'showMedicalChecklistAnnualPhysical'])->name('nurse.medical-checklist.annual-physical');
    Route::post('/nurse/medical-checklist', [NurseController::class, 'storeMedicalChecklist'])->name('nurse.medical-checklist.store');
    Route::patch('/nurse/medical-checklist/{id}', [NurseController::class, 'updateMedicalChecklist'])->name('nurse.medical-checklist.update');

    // Nurse OPD Routes
    Route::get('/nurse/opd-examinations', [NurseController::class, 'opdExaminations'])->name('nurse.opd-examinations');
    Route::get('/nurse/opd-examinations/create', [NurseController::class, 'createOpdExamination'])->name('nurse.opd-examinations.create');
    Route::post('/nurse/opd-examinations', [NurseController::class, 'storeOpdExamination'])->name('nurse.opd-examinations.store');
    Route::get('/nurse/opd-examinations/{id}/edit', [NurseController::class, 'editOpdExamination'])->name('nurse.opd-examinations.edit');
    Route::patch('/nurse/opd-examinations/{id}', [NurseController::class, 'updateOpdExamination'])->name('nurse.opd-examinations.update');
    Route::get('/nurse/opd-medical-checklist/{opdTestId}', [NurseController::class, 'showOpdMedicalChecklist'])->name('nurse.opd-medical-checklist');
    Route::post('/nurse/opd-examinations/{opdTestId}/send', [NurseController::class, 'sendOpdExaminationToDoctor'])->name('nurse.opd-examinations.send-to-doctor');

    // Nurse Messaging Routes
    Route::get('/nurse/messages', [NurseController::class, 'messages'])->name('nurse.messages');
    Route::get('/nurse/messages/fetch', [NurseController::class, 'fetchMessages']);
    Route::post('/nurse/messages/send', [NurseController::class, 'sendMessage']);
    Route::post('/nurse/messages/mark-read', [NurseController::class, 'markAsRead']);
    Route::get('/nurse/chat-users', [NurseController::class, 'chatUsers']);
});

Route::middleware(['auth', 'role:radtech'])->group(function () {
    Route::get('/radtech/dashboard', [RadtechController::class, 'dashboard'])->name('radtech.dashboard');
    
    // Radtech Medical Checklist Routes
    Route::get('/radtech/medical-checklist/pre-employment/{recordId}', [RadtechController::class, 'showMedicalChecklistPreEmployment'])->name('radtech.medical-checklist.pre-employment');
    Route::get('/radtech/medical-checklist/annual-physical/{patientId}', [RadtechController::class, 'showMedicalChecklistAnnualPhysical'])->name('radtech.medical-checklist.annual-physical');
    Route::post('/radtech/medical-checklist', [RadtechController::class, 'storeMedicalChecklist'])->name('radtech.medical-checklist.store');
    Route::patch('/radtech/medical-checklist/{id}', [RadtechController::class, 'updateMedicalChecklist'])->name('radtech.medical-checklist.update');
    // Radtech send-to-doctor actions
    Route::post('/radtech/pre-employment/{recordId}/send', [RadtechController::class, 'sendPreEmploymentToDoctor'])->name('radtech.pre-employment.send-to-doctor');
    Route::post('/radtech/annual-physical/patient/{patientId}/send', [RadtechController::class, 'sendAnnualPhysicalToDoctor'])->name('radtech.annual-physical.send-to-doctor');
});

Route::middleware(['auth', 'role:plebo'])->group(function () {
    Route::get('/plebo/dashboard', [PleboController::class, 'dashboard'])->name('plebo.dashboard');
    Route::get('/plebo/pre-employment', [PleboController::class, 'preEmployment'])->name('plebo.pre-employment');
    Route::get('/plebo/annual-physical', [PleboController::class, 'annualPhysical'])->name('plebo.annual-physical');
    Route::post('/plebo/pre-employment/{recordId}/send', [PleboController::class, 'sendPreEmploymentToDoctor'])->name('plebo.pre-employment.send-to-doctor');
    Route::post('/plebo/annual-physical/patient/{patientId}/send', [PleboController::class, 'sendAnnualPhysicalToDoctor'])->name('plebo.annual-physical.send-to-doctor');
    Route::get('/plebo/medical-checklist/pre-employment/{recordId}', [PleboController::class, 'showMedicalChecklistPreEmployment'])->name('plebo.medical-checklist.pre-employment');
    Route::get('/plebo/medical-checklist/annual-physical/{patientId}', [PleboController::class, 'showMedicalChecklistAnnualPhysical'])->name('plebo.medical-checklist.annual-physical');
    Route::post('/plebo/medical-checklist', [PleboController::class, 'storeMedicalChecklist'])->name('plebo.medical-checklist.store');
    Route::patch('/plebo/medical-checklist/{id}', [PleboController::class, 'updateMedicalChecklist'])->name('plebo.medical-checklist.update');
});

Route::middleware(['auth', 'role:radiologist'])->group(function () {
    Route::get('/radiologist/dashboard', [RadiologistController::class, 'dashboard'])->name('radiologist.dashboard');
    Route::get('/radiologist/pre-employment/{id}', [RadiologistController::class, 'showPreEmployment'])->name('radiologist.pre-employment.show');
    Route::patch('/radiologist/pre-employment/{id}', [RadiologistController::class, 'updatePreEmployment'])->name('radiologist.pre-employment.update');
    Route::get('/radiologist/annual-physical/{id}', [RadiologistController::class, 'showAnnualPhysical'])->name('radiologist.annual-physical.show');
    Route::patch('/radiologist/annual-physical/{id}', [RadiologistController::class, 'updateAnnualPhysical'])->name('radiologist.annual-physical.update');
    // Radiologist "send to doctor" not required; radiologist updates findings only.
});

Route::middleware(['auth', 'role:ecgtech'])->group(function () {
    // Dashboard
    Route::get('/ecgtech/dashboard', [EcgtechController::class, 'dashboard'])->name('ecgtech.dashboard');
    
    // Pre-Employment
    Route::get('/ecgtech/pre-employment', [EcgtechController::class, 'preEmployment'])->name('ecgtech.pre-employment');
    Route::post('/ecgtech/pre-employment/{recordId}/send-to-doctor', [EcgtechController::class, 'sendPreEmploymentToDoctor'])->name('ecgtech.pre-employment.send-to-doctor');
    Route::get('/ecgtech/pre-employment/{id}/edit', [EcgtechController::class, 'editPreEmployment'])->name('ecgtech.pre-employment.edit');
    Route::patch('/ecgtech/pre-employment/{id}', [EcgtechController::class, 'updatePreEmployment'])->name('ecgtech.pre-employment.update');
    
    // Annual Physical
    Route::get('/ecgtech/annual-physical', [EcgtechController::class, 'annualPhysical'])->name('ecgtech.annual-physical');
    Route::post('/ecgtech/annual-physical/patient/{patientId}/send-to-doctor', [EcgtechController::class, 'sendAnnualPhysicalToDoctor'])->name('ecgtech.annual-physical.send-to-doctor');
    Route::get('/ecgtech/annual-physical/{id}/edit', [EcgtechController::class, 'editAnnualPhysical'])->name('ecgtech.annual-physical.edit');
    Route::patch('/ecgtech/annual-physical/{id}', [EcgtechController::class, 'updateAnnualPhysical'])->name('ecgtech.annual-physical.update');
    
    // Medical Checklist
    Route::get('/ecgtech/medical-checklist/pre-employment/{recordId}', [EcgtechController::class, 'showMedicalChecklistPreEmployment'])->name('ecgtech.medical-checklist.pre-employment');
    Route::get('/ecgtech/medical-checklist/annual-physical/{patientId}', [EcgtechController::class, 'showMedicalChecklistAnnualPhysical'])->name('ecgtech.medical-checklist.annual-physical');
    Route::get('/ecgtech/medical-checklist-page/pre-employment/{recordId}', [EcgtechController::class, 'showMedicalChecklistPagePreEmployment'])->name('ecgtech.medical-checklist-page.pre-employment');
    Route::get('/ecgtech/medical-checklist-page/annual-physical/{patientId}', [EcgtechController::class, 'showMedicalChecklistPageAnnualPhysical'])->name('ecgtech.medical-checklist-page.annual-physical');
    Route::post('/ecgtech/medical-checklist', [EcgtechController::class, 'storeMedicalChecklist'])->name('ecgtech.medical-checklist.store');
    Route::patch('/ecgtech/medical-checklist/{id}', [EcgtechController::class, 'updateMedicalChecklist'])->name('ecgtech.medical-checklist.update');
    
    // Messages
    Route::get('/ecgtech/messages', [EcgtechController::class, 'messages'])->name('ecgtech.messages');
    Route::get('/ecgtech/chat-users', [EcgtechController::class, 'chatUsers'])->name('ecgtech.chat-users');
    Route::get('/ecgtech/fetch-messages', [EcgtechController::class, 'fetchMessages'])->name('ecgtech.fetch-messages');
    Route::post('/ecgtech/send-message', [EcgtechController::class, 'sendMessage'])->name('ecgtech.send-message');
    Route::post('/ecgtech/mark-as-read', [EcgtechController::class, 'markAsRead'])->name('ecgtech.mark-as-read');
    
    // Test route
    Route::get('/ecgtech/test-contacts', [EcgtechController::class, 'testContacts']);
});

Route::middleware(['auth', 'role:pathologist'])->group(function () {
    // Dashboard
    Route::get('/pathologist/dashboard', [PathologistController::class, 'dashboard'])->name('pathologist.dashboard');
    
    // Medical Checklist
    Route::get('/pathologist/medical-checklist', [PathologistController::class, 'medicalChecklist'])->name('pathologist.medical-checklist');
    Route::post('/pathologist/medical-checklist', [PathologistController::class, 'storeMedicalChecklist'])->name('pathologist.medical-checklist.store');
    Route::patch('/pathologist/medical-checklist/{id}', [PathologistController::class, 'updateMedicalChecklist'])->name('pathologist.medical-checklist.update');
    
    // Annual Physical
    Route::get('/pathologist/annual-physical', [PathologistController::class, 'annualPhysical'])->name('pathologist.annual-physical');
    Route::get('/pathologist/annual-physical/{id}/edit', [PathologistController::class, 'editAnnualPhysical'])->name('pathologist.annual-physical.edit');
    Route::put('/pathologist/annual-physical/{id}', [PathologistController::class, 'updateAnnualPhysical'])->name('pathologist.annual-physical.update');
    Route::post('/pathologist/annual-physical/patient/{patientId}/send-to-doctor', [PathologistController::class, 'sendAnnualPhysicalToDoctor'])->name('pathologist.annual-physical.send-to-doctor');
    
    // Pre-Employment
    Route::get('/pathologist/pre-employment', [PathologistController::class, 'preEmployment'])->name('pathologist.pre-employment');
    Route::get('/pathologist/pre-employment/{id}/edit', [PathologistController::class, 'editPreEmployment'])->name('pathologist.pre-employment.edit');
    Route::put('/pathologist/pre-employment/{id}', [PathologistController::class, 'updatePreEmployment'])->name('pathologist.pre-employment.update');
    Route::post('/pathologist/pre-employment/{recordId}/send-to-doctor', [PathologistController::class, 'sendPreEmploymentToDoctor'])->name('pathologist.pre-employment.send-to-doctor');
    
    // Messages
    Route::get('/pathologist/messages', [PathologistController::class, 'messages'])->name('pathologist.messages');
    Route::get('/pathologist/chat-users', [PathologistController::class, 'chatUsers'])->name('pathologist.chat-users');
    Route::get('/pathologist/fetch-messages', [PathologistController::class, 'fetchMessages'])->name('pathologist.fetch-messages');
    Route::post('/pathologist/send-message', [PathologistController::class, 'sendMessage'])->name('pathologist.send-message');
    Route::post('/pathologist/mark-as-read', [PathologistController::class, 'markAsRead'])->name('pathologist.mark-as-read');
});

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient/profile', [PatientController::class, 'profile'])->name('patient.profile');
    Route::put('/patient/profile', [PatientController::class, 'updateProfile'])->name('patient.profile.update');
});


// Generic dashboard redirector for authenticated users
Route::middleware(['auth'])->get('/dashboard', function() {
    $user = Auth::user();
    if ($user->isAdmin()) return redirect()->route('admin.dashboard');
    if ($user->isCompany()) return redirect()->route('company.dashboard');
    if ($user->isDoctor()) return redirect()->route('doctor.dashboard');
    if ($user->isNurse()) return redirect()->route('nurse.dashboard');
    if ($user->isRadTech()) return redirect()->route('radtech.dashboard');
    if ($user->isRadiologist()) return redirect()->route('radiologist.dashboard');
    if ($user->isPathologist()) return redirect()->route('pathologist.dashboard');
    if ($user->isPlebo()) return redirect()->route('plebo.dashboard');
    if ($user->isOpd()) return redirect()->route('opd.dashboard');
    return redirect()->route('patient.dashboard');
});



// Public invitation routes
Route::get('/invitation/{token}', [App\Http\Controllers\CompanyAccountInvitationController::class, 'accept'])->name('invitation.accept');
Route::post('/invitation/{token}', [App\Http\Controllers\CompanyAccountInvitationController::class, 'processInvitation'])->name('invitation.process');

// Public pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/service', function () {
    return redirect('/services');
});

Route::get('/location', function () {
    return view('location');
})->name('location');

// Default route - redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});


