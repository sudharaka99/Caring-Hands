<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuAccessController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

use App\Http\Controllers\Manager\DashboardController as ManagerDashboard;
use App\Http\Controllers\Caregiver\DashboardController as CaregiverDashboard;
use App\Http\Controllers\Healthcare\DashboardController as HealthcareDashboard;


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
    // ROLE DASHBOARDS
    // ==========================================

    Route::middleware('role:admin')->get('/dashboard', [AdminDashboard::class, 'dashboard'])->name('admin.dashboard');
    Route::middleware('role:manager')->get('/manager/dashboard', [ManagerDashboard::class, 'dashboard'])->name('manager.dashboard');
    Route::middleware('role:caregiver')->get('/caregiver/dashboard', [CaregiverDashboard::class, 'dashboard'])->name('caregiver.dashboard');
    Route::middleware('role:healthcare')->get('/healthcare/dashboard', [HealthcareDashboard::class, 'dashboard'])->name('healthcare.dashboard');


    // ==========================================
    // ADMIN ROUTES
    // ==========================================

    Route::middleware('role:admin,manager')->prefix('admin')->name('admin.')->group(function () {

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
        Route::get('/elders/{elder}', [AdminController::class, 'eldersShow'])->name('elders.show');
        Route::get('/elders/{elder}/edit', [AdminController::class, 'eldersEdit'])->name('elders.edit');
        Route::put('/elders/{elder}', [AdminController::class, 'eldersUpdate'])->name('elders.update');
        Route::delete('/elders/{elder}', [AdminController::class, 'eldersDestroy'])->name('elders.destroy');
        Route::get('/elders/search', [AdminController::class, 'eldersSearch'])->name('elders.search');
        Route::get('/elders/export', [AdminController::class, 'eldersExport'])->name('elders.export');
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
    });


    // ==========================================
    // MANAGER ROUTES
    // ==========================================

    Route::middleware('role:manager')->prefix('manager')->name('manager.')->group(function () {

        Route::get('/dashboard', [ManagerDashboard::class, 'dashboard'])->name('dashboard');

    });

});