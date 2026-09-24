<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuAccessController;

use App\Http\Controllers\Manager\DashboardController as ManagerDashboard;
use App\Http\Controllers\Caregiver\DashboardController as CaregiverDashboard;
use App\Http\Controllers\Healthcare\DashboardController as HealthcareDashboard;

use App\Http\Controllers\Caregiver\CaregiverController;
use App\Http\Controllers\Healthcare\HealthcareController;

use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Owner\OwnerController;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/features', [HomeController::class, 'features'])->name('features');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

Route::get('/login', [AccountController::class, 'login'])->name('login');
Route::post('/login', [AccountController::class, 'authenticate'])->name('authenticate');
Route::get('/register', [AccountController::class, 'register'])->name('register');
Route::post('/register', [AccountController::class, 'store'])->name('register.store');
Route::post('/logout', [AccountController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // ==========================================
    // ADMIN ROUTES (prefix: admin, name: admin.)
    // ==========================================

    Route::middleware('role:admin,manager')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // --- Dashboard ---
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
            Route::get('/dashboard/stats', [AdminController::class, 'dashboardStats'])->name('dashboard.stats');

            // --- Menu Management ---
            Route::resource('menus', MenuController::class);

            // --- Menu Access ---
            Route::get('/menu-access', [MenuAccessController::class, 'index'])->name('menu-access.index');
            Route::post('/menu-access', [MenuAccessController::class, 'update'])->name('menu-access.update');

            // --- Elders ---
            Route::get('/elders', [AdminController::class, 'eldersIndex'])->name('elders.index');
            Route::get('/elders/create', [AdminController::class, 'eldersCreate'])->name('elders.create');
            Route::post('/elders', [AdminController::class, 'eldersStore'])->name('elders.store');
            Route::get('/elders/search', [AdminController::class, 'eldersSearch'])->name('elders.search');
            Route::get('/elders/export', [AdminController::class, 'eldersExport'])->name('elders.export');
            Route::get('/elders/{elder}', [AdminController::class, 'eldersShow'])->name('elders.show');
            Route::get('/elders/{elder}/edit', [AdminController::class, 'eldersEdit'])->name('elders.edit');
            Route::put('/elders/{elder}', [AdminController::class, 'eldersUpdate'])->name('elders.update');
            Route::delete('/elders/{elder}', [AdminController::class, 'eldersDestroy'])->name('elders.destroy');
            Route::post('/elders/{elder}/toggle-status', [AdminController::class, 'eldersToggleStatus'])->name('elders.toggle-status');

            // --- Owners ---
            Route::get('/owners', [AdminController::class, 'ownersIndex'])->name('owners.index');
            Route::get('/owners/create', [AdminController::class, 'ownersCreate'])->name('owners.create');
            Route::post('/owners', [AdminController::class, 'ownersStore'])->name('owners.store');
            Route::get('/owners/{owner}', [AdminController::class, 'ownersShow'])->name('owners.show');
            Route::get('/owners/{owner}/edit', [AdminController::class, 'ownersEdit'])->name('owners.edit');
            Route::put('/owners/{owner}', [AdminController::class, 'ownersUpdate'])->name('owners.update');
            Route::delete('/owners/{owner}', [AdminController::class, 'ownersDestroy'])->name('owners.destroy');

            // --- Caregivers ---
            Route::get('/caregivers', [AdminController::class, 'caregiversIndex'])->name('caregivers.index');
            Route::get('/caregivers/create', [AdminController::class, 'caregiversCreate'])->name('caregivers.create');
            Route::post('/caregivers', [AdminController::class, 'caregiversStore'])->name('caregivers.store');
            Route::get('/caregivers/{id}', [AdminController::class, 'caregiversShow'])->name('caregivers.show');
            Route::get('/caregivers/{id}/edit', [AdminController::class, 'caregiversEdit'])->name('caregivers.edit');
            Route::put('/caregivers/{id}', [AdminController::class, 'caregiversUpdate'])->name('caregivers.update');
            Route::delete('/caregivers/{id}', [AdminController::class, 'caregiversDestroy'])->name('caregivers.destroy');

            // --- Healthcare Staff ---
            Route::get('/healthcare', [AdminController::class, 'healthcareIndex'])->name('healthcare.index');
            Route::get('/healthcare/create', [AdminController::class, 'healthcareCreate'])->name('healthcare.create');
            Route::post('/healthcare', [AdminController::class, 'healthcareStore'])->name('healthcare.store');
            Route::get('/healthcare/{id}', [AdminController::class, 'healthcareShow'])->name('healthcare.show');
            Route::get('/healthcare/{id}/edit', [AdminController::class, 'healthcareEdit'])->name('healthcare.edit');
            Route::put('/healthcare/{id}', [AdminController::class, 'healthcareUpdate'])->name('healthcare.update');
            Route::delete('/healthcare/{id}', [AdminController::class, 'healthcareDestroy'])->name('healthcare.destroy');

            // --- Managers ---
            Route::get('/managers', [AdminController::class, 'managersIndex'])->name('managers.index');
            Route::get('/managers/create', [AdminController::class, 'managersCreate'])->name('managers.create');
            Route::post('/managers', [AdminController::class, 'managersStore'])->name('managers.store');
            Route::get('/managers/{id}', [AdminController::class, 'managersShow'])->name('managers.show');
            Route::get('/managers/{id}/edit', [AdminController::class, 'managersEdit'])->name('managers.edit');
            Route::put('/managers/{id}', [AdminController::class, 'managersUpdate'])->name('managers.update');
            Route::delete('/managers/{id}', [AdminController::class, 'managersDestroy'])->name('managers.destroy');

            // --- Staff Shifts ---
            Route::get('/staff-shifts', [AdminController::class, 'shiftsIndex'])->name('shifts.index');
            Route::get('/staff-shifts/create', [AdminController::class, 'shiftsCreate'])->name('shifts.create');
            Route::post('/staff-shifts', [AdminController::class, 'shiftsStore'])->name('shifts.store');
            Route::get('/staff-shifts/{id}', [AdminController::class, 'shiftsShow'])->name('shifts.show');
            Route::get('/staff-shifts/{id}/edit', [AdminController::class, 'shiftsEdit'])->name('shifts.edit');
            Route::put('/staff-shifts/{id}', [AdminController::class, 'shiftsUpdate'])->name('shifts.update');
            Route::delete('/staff-shifts/{id}', [AdminController::class, 'shiftsDestroy'])->name('shifts.destroy');

            // --- Attendance ---
            Route::get('/attendance', [AdminController::class, 'attendanceIndex'])->name('attendance.index');
            Route::get('/attendance/create', [AdminController::class, 'attendanceCreate'])->name('attendance.create');
            Route::post('/attendance', [AdminController::class, 'attendanceStore'])->name('attendance.store');
            Route::get('/attendance/{id}', [AdminController::class, 'attendanceShow'])->name('attendance.show');
            Route::get('/attendance/{id}/edit', [AdminController::class, 'attendanceEdit'])->name('attendance.edit');
            Route::put('/attendance/{id}', [AdminController::class, 'attendanceUpdate'])->name('attendance.update');
            Route::delete('/attendance/{id}', [AdminController::class, 'attendanceDestroy'])->name('attendance.destroy');

            // --- Care Plans ---
            Route::get('/care-plans', [AdminController::class, 'carePlansIndex'])->name('care-plans.index');
            Route::get('/care-plans/create', [AdminController::class, 'carePlansCreate'])->name('care-plans.create');
            Route::post('/care-plans', [AdminController::class, 'carePlansStore'])->name('care-plans.store');
            Route::get('/care-plans/{id}', [AdminController::class, 'carePlansShow'])->name('care-plans.show');
            Route::get('/care-plans/{id}/edit', [AdminController::class, 'carePlansEdit'])->name('care-plans.edit');
            Route::put('/care-plans/{id}', [AdminController::class, 'carePlansUpdate'])->name('care-plans.update');
            Route::delete('/care-plans/{id}', [AdminController::class, 'carePlansDestroy'])->name('care-plans.destroy');

            // --- Medications ---
            Route::get('/medications', [AdminController::class, 'medicationIndex'])->name('medication.index');
            Route::get('/medications/create', [AdminController::class, 'medicationCreate'])->name('medication.create');
            Route::post('/medications', [AdminController::class, 'medicationStore'])->name('medication.store');
            Route::get('/medications/{id}', [AdminController::class, 'medicationShow'])->name('medication.show');
            Route::get('/medications/{id}/edit', [AdminController::class, 'medicationEdit'])->name('medication.edit');
            Route::put('/medications/{id}', [AdminController::class, 'medicationUpdate'])->name('medication.update');
            Route::delete('/medications/{id}', [AdminController::class, 'medicationDestroy'])->name('medication.destroy');

            // --- Appointments ---
            Route::get('/appointments', [AdminController::class, 'appointmentsIndex'])->name('appointments.index');
            Route::get('/appointments/create', [AdminController::class, 'appointmentsCreate'])->name('appointments.create');
            Route::post('/appointments', [AdminController::class, 'appointmentsStore'])->name('appointments.store');
            Route::get('/appointments/{id}', [AdminController::class, 'appointmentsShow'])->name('appointments.show');
            Route::get('/appointments/{id}/edit', [AdminController::class, 'appointmentsEdit'])->name('appointments.edit');
            Route::put('/appointments/{id}', [AdminController::class, 'appointmentsUpdate'])->name('appointments.update');
            Route::delete('/appointments/{id}', [AdminController::class, 'appointmentsDestroy'])->name('appointments.destroy');

            // --- Reports ---
            Route::get('/reports', [AdminController::class, 'reportsIndex'])->name('reports.index');
            Route::get('/reports/elders', [AdminController::class, 'reportsElders'])->name('reports.elders');
            Route::get('/reports/staff', [AdminController::class, 'reportsStaff'])->name('reports.staff');
            Route::get('/reports/attendance', [AdminController::class, 'reportsAttendance'])->name('reports.attendance');
            Route::get('/reports/care-plans', [AdminController::class, 'reportsCarePlans'])->name('reports.care-plans');
            Route::get('/reports/medication', [AdminController::class, 'reportsMedication'])->name('reports.medication');
            Route::get('/reports/appointments', [AdminController::class, 'reportsAppointments'])->name('reports.appointments');
        });


    // ==========================================
    // MANAGER ROUTES (prefix: manager, name: manager.)
    // ==========================================

    Route::middleware('role:manager')
        ->prefix('manager')
        ->name('manager.')
        ->group(function () {

            Route::get('/dashboard', [ManagerDashboard::class, 'dashboard'])->name('dashboard');

            // Add manager-specific routes here as needed
        });


    // ==========================================
    // CAREGIVER ROUTES (prefix: caregiver, name: caregiver.)
    // ==========================================

    Route::middleware('role:caregiver')
        ->prefix('caregiver')
        ->name('caregiver.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [CaregiverDashboard::class, 'dashboard'])->name('dashboard');

            // Elders — own only
            Route::get('/elders', [CaregiverController::class, 'eldersIndex'])->name('elders.index');
            Route::get('/elders/{id}', [CaregiverController::class, 'eldersShow'])->name('elders.show');

            // Care Plans — view + update
            Route::get('/care-plans', [CaregiverController::class, 'carePlansIndex'])->name('care-plans.index');
            Route::get('/care-plans/{id}', [CaregiverController::class, 'carePlansShow'])->name('care-plans.show');
            Route::put('/care-plans/{id}', [CaregiverController::class, 'carePlansUpdate'])->name('care-plans.update');

            // Medications — view + log
            Route::get('/medications', [CaregiverController::class, 'medicationsIndex'])->name('medication.index');
            Route::post('/medications/{id}/log', [CaregiverController::class, 'medicationLog'])->name('medication.log');

            // Appointments — own
            Route::get('/appointments', [CaregiverController::class, 'appointmentsIndex'])->name('appointments.index');

            // Shifts — own
            Route::get('/shifts', [CaregiverController::class, 'shiftsIndex'])->name('shifts.index');

            // Attendance — own
            Route::get('/attendance', [CaregiverController::class, 'attendanceIndex'])->name('attendance.index');

            // Messages
            Route::get('/messages', [CaregiverController::class, 'messagesIndex'])->name('messages.index');
        });


    // ==========================================
    // HEALTHCARE ROUTES (prefix: healthcare, name: healthcare.)
    // ==========================================

    Route::middleware('role:healthcare')
        ->prefix('healthcare')
        ->name('healthcare.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [HealthcareDashboard::class, 'dashboard'])->name('dashboard');

            // --- Elders ---
            Route::get('/elders', [HealthcareController::class, 'eldersIndex'])->name('elders.index');
            Route::get('/elders/{id}', [HealthcareController::class, 'eldersShow'])->name('elders.show');

            // --- Care Plans ---
            Route::get('/care-plans', [HealthcareController::class, 'carePlansIndex'])->name('care-plans.index');
            Route::get('/care-plans/create', [HealthcareController::class, 'carePlansCreate'])->name('care-plans.create');
            Route::post('/care-plans', [HealthcareController::class, 'carePlansStore'])->name('care-plans.store');
            Route::get('/care-plans/{id}', [HealthcareController::class, 'carePlansShow'])->name('care-plans.show');
            Route::get('/care-plans/{id}/edit', [HealthcareController::class, 'carePlansEdit'])->name('care-plans.edit');
            Route::put('/care-plans/{id}', [HealthcareController::class, 'carePlansUpdate'])->name('care-plans.update');

            // --- Medications ---
            Route::get('/medications', [HealthcareController::class, 'medicationsIndex'])->name('medication.index');
            Route::get('/medications/create', [HealthcareController::class, 'medicationsCreate'])->name('medication.create');
            Route::post('/medications', [HealthcareController::class, 'medicationsStore'])->name('medication.store');
            Route::get('/medications/{id}', [HealthcareController::class, 'medicationsShow'])->name('medication.show');
            Route::get('/medications/{id}/edit', [HealthcareController::class, 'medicationsEdit'])->name('medication.edit');
            Route::put('/medications/{id}', [HealthcareController::class, 'medicationsUpdate'])->name('medication.update');

            // --- Appointments ---
            Route::get('/appointments', [HealthcareController::class, 'appointmentsIndex'])->name('appointments.index');
            Route::get('/appointments/create', [HealthcareController::class, 'appointmentsCreate'])->name('appointments.create');
            Route::post('/appointments', [HealthcareController::class, 'appointmentsStore'])->name('appointments.store');
            Route::get('/appointments/{id}', [HealthcareController::class, 'appointmentsShow'])->name('appointments.show');
            Route::get('/appointments/{id}/edit', [HealthcareController::class, 'appointmentsEdit'])->name('appointments.edit');
            Route::put('/appointments/{id}', [HealthcareController::class, 'appointmentsUpdate'])->name('appointments.update');

            // --- Shifts — own ---
            Route::get('/shifts', [HealthcareController::class, 'shiftsIndex'])->name('shifts.index');

            // --- Attendance — own ---
            Route::get('/attendance', [HealthcareController::class, 'attendanceIndex'])->name('attendance.index');

            // --- Messages ---
            Route::get('/messages', [HealthcareController::class, 'messagesIndex'])->name('messages.index');
        });


    // ==========================================
    // OWNER ROUTES (prefix: owner, name: owner.)
    // ==========================================

    Route::middleware('role:owner')
        ->prefix('owner')
        ->name('owner.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [OwnerDashboard::class, 'dashboard'])->name('dashboard');

            // Elders — own only
            Route::get('/elders', [OwnerController::class, 'eldersIndex'])->name('elders.index');
            Route::get('/elders/{id}', [OwnerController::class, 'eldersShow'])->name('elders.show');

            // Care Plans — own elder's
            Route::get('/care-plans', [OwnerController::class, 'carePlansIndex'])->name('care-plans.index');
            Route::get('/care-plans/{id}', [OwnerController::class, 'carePlansShow'])->name('care-plans.show');

            // Medications — own elder's
            Route::get('/medications', [OwnerController::class, 'medicationsIndex'])->name('medication.index');

            // Appointments — own elder's
            Route::get('/appointments', [OwnerController::class, 'appointmentsIndex'])->name('appointments.index');

            // Reports
            Route::get('/reports', [OwnerController::class, 'reportsIndex'])->name('reports.index');

            // Messages
            Route::get('/messages', [OwnerController::class, 'messagesIndex'])->name('messages.index');
        });

});  