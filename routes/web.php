<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuAccessController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "web" middleware group.
|
*/

// ==========================================
// PUBLIC ROUTES
// ==========================================

// Home Page
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

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


    Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');

    Route::get('/caregiver/dashboard', [CaregiverController::class, 'dashboard'])->name('caregiver.dashboard');

    Route::get('/healthcare/dashboard', [HealthcareController::class, 'dashboard'])->name('healthcare.dashboard');

});   




Route::prefix('admin')->middleware(['auth'])->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Elder Management Routes
    Route::get('/elders', [AdminController::class, 'eldersIndex'])->name('admin.elders.index');
    Route::get('/elders/create', [AdminController::class, 'eldersCreate'])->name('admin.elders.create');
    Route::post('/elders', [AdminController::class, 'eldersStore'])->name('admin.elders.store');
    Route::get('/elders/{elder}', [AdminController::class, 'eldersShow'])->name('admin.elders.show');
    Route::get('/elders/{elder}/edit', [AdminController::class, 'eldersEdit'])->name('admin.elders.edit');
    Route::put('/elders/{elder}', [AdminController::class, 'eldersUpdate'])->name('admin.elders.update');
    Route::delete('/elders/{elder}', [AdminController::class, 'eldersDestroy'])->name('admin.elders.destroy');
    
    // AJAX Routes
    Route::get('/elders/search', [AdminController::class, 'eldersSearch'])->name('admin.elders.search');
    Route::post('/elders/{elder}/toggle-status', [AdminController::class, 'eldersToggleStatus'])->name('admin.elders.toggle-status');
    Route::get('/elders/export', [AdminController::class, 'eldersExport'])->name('admin.elders.export');
    Route::get('/dashboard/stats', [AdminController::class, 'dashboardStats'])->name('admin.dashboard.stats');
    
    // ==========================================
    // OWNER MANAGEMENT ROUTES
    // ==========================================
    
    Route::get('/owners', [AdminController::class, 'ownersIndex'])->name('admin.owners.index');
    Route::get('/owners/create', [AdminController::class, 'ownersCreate'])->name('admin.owners.create');
    Route::post('/owners', [AdminController::class, 'ownersStore'])->name('admin.owners.store');
    Route::get('/owners/{owner}', [AdminController::class, 'ownersShow'])->name('admin.owners.show');
    Route::get('/owners/{owner}/edit', [AdminController::class, 'ownersEdit'])->name('admin.owners.edit');
    Route::put('/owners/{owner}', [AdminController::class, 'ownersUpdate'])->name('admin.owners.update');
    Route::delete('/owners/{owner}', [AdminController::class, 'ownersDestroy'])->name('admin.owners.destroy');
    
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('menus',MenuController::class );
    Route::get('/menu-access',[MenuAccessController::class, 'index'])->name('menu-access.index');
    Route::post('/menu-access',[MenuAccessController::class, 'update'])->name('menu-access.update');

});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Caregivers
    Route::get('/caregivers', [AdminController::class, 'caregiversIndex'])->name('admin.caregivers.index');
    Route::get('/caregivers/create',[AdminController::class, 'caregiversCreate'])->name('admin.caregivers.create');
    Route::post('/caregivers',[AdminController::class, 'caregiversStore'])->name('admin.caregivers.store');
    Route::get('/caregivers/{id}',[AdminController::class, 'caregiversShow'])->name('admin.caregivers.show');
    Route::get('/caregivers/{id}/edit',[AdminController::class, 'caregiversEdit'])->name('admin.caregivers.edit');
    Route::put('/caregivers/{id}',[AdminController::class, 'caregiversUpdate'])->name('admin.caregivers.update');
    Route::delete('/caregivers/{id}',[AdminController::class, 'caregiversDestroy'])->name('admin.caregivers.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    //healthcare
    Route::get('/healthcare',[AdminController::class, 'healthcareIndex'])->name('healthcare.index');
    Route::get('/healthcare/create',[AdminController::class, 'healthcareCreate'])->name('healthcare.create');
    Route::post('/healthcare',[AdminController::class, 'healthcareStore'])->name('healthcare.store');
    Route::get('/healthcare/{id}',[AdminController::class, 'healthcareShow'])->name('healthcare.show');
    Route::get('/healthcare/{id}/edit',[AdminController::class, 'healthcareEdit'])->name('healthcare.edit');
    Route::put('/healthcare/{id}',[AdminController::class, 'healthcareUpdate'])->name('healthcare.update');
    Route::delete('/healthcare/{id}',[AdminController::class, 'healthcareDestroy'])->name('healthcare.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    //managers
    Route::get('/managers',[AdminController::class, 'managersIndex'])->name('managers.index');
    Route::get('/managers/create',[AdminController::class, 'managersCreate'])->name('managers.create');
    Route::post('/managers',[AdminController::class, 'managersStore'])->name('managers.store');
    Route::get('/managers/{id}',[AdminController::class, 'managersShow'])->name('managers.show');
    Route::get('/managers/{id}/edit',[AdminController::class, 'managersEdit'])->name('managers.edit');
    Route::put('/managers/{id}',[AdminController::class, 'managersUpdate'])->name('managers.update');
    Route::delete('/managers/{id}',[AdminController::class, 'managersDestroy'])->name('managers.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    //staff shifts
    Route::get('/staff-shifts',[AdminController::class, 'shiftsIndex'])->name('shifts.index');
    Route::get('/staff-shifts/create',[AdminController::class, 'shiftsCreate'])->name('shifts.create');
    Route::post('/staff-shifts',[AdminController::class, 'shiftsStore'])->name('shifts.store');
    Route::get('/staff-shifts/{id}',[AdminController::class, 'shiftsShow'])->name('shifts.show');
    Route::get('/staff-shifts/{id}/edit',[AdminController::class, 'shiftsEdit'])->name('shifts.edit');
    Route::put('/staff-shifts/{id}',[AdminController::class, 'shiftsUpdate'])->name('shifts.update');
    Route::delete('/staff-shifts/{id}',[AdminController::class, 'shiftsDestroy'])->name('shifts.destroy');
});


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Attendance
    Route::get('/attendance',[AdminController::class, 'attendanceIndex'])->name('attendance.index');
    Route::get('/attendance/create',[AdminController::class, 'attendanceCreate'])->name('attendance.create');
    Route::post('/attendance',[AdminController::class, 'attendanceStore'])->name('attendance.store');
    Route::get('/attendance/{id}',[AdminController::class, 'attendanceShow'])->name('attendance.show');
    Route::get('/attendance/{id}/edit',[AdminController::class, 'attendanceEdit'])->name('attendance.edit');
    Route::put('/attendance/{id}',[AdminController::class, 'attendanceUpdate'])->name('attendance.update');
    Route::delete('/attendance/{id}',[AdminController::class, 'attendanceDestroy'])->name('attendance.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Care Plans
    Route::get('/care-plans',[AdminController::class, 'carePlansIndex'])->name('care-plans.index');
    Route::get('/care-plans/create',[AdminController::class, 'carePlansCreate'])->name('care-plans.create');
    Route::post('/care-plans',[AdminController::class, 'carePlansStore'])->name('care-plans.store');
    Route::get('/care-plans/{id}',[AdminController::class, 'carePlansShow'])->name('care-plans.show');
    Route::get('/care-plans/{id}/edit',[AdminController::class, 'carePlansEdit'])->name('care-plans.edit');
    Route::put('/care-plans/{id}',[AdminController::class, 'carePlansUpdate'])->name('care-plans.update');
    Route::delete('/care-plans/{id}',[AdminController::class, 'carePlansDestroy'])->name('care-plans.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Medications
    Route::get('/medications',[AdminController::class, 'medicationIndex'])->name('medication.index');
    Route::get('/medications/create',[AdminController::class, 'medicationCreate'])->name('medication.create');
    Route::post('/medications',[AdminController::class, 'medicationStore'])->name('medication.store');
    Route::get('/medications/{id}',[AdminController::class, 'medicationShow'])->name('medication.show');
    Route::get('/medications/{id}/edit',[AdminController::class, 'medicationEdit'])->name('medication.edit');
    Route::put('/medications/{id}',[AdminController::class, 'medicationUpdate'])->name('medication.update');
    Route::delete('/medications/{id}',[AdminController::class, 'medicationDestroy'])->name('medication.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Appointments
    Route::get('/appointments',[AdminController::class, 'appointmentsIndex'])->name('appointments.index');
    Route::get('/appointments/create',[AdminController::class, 'appointmentsCreate'])->name('appointments.create');
    Route::post('/appointments',[AdminController::class, 'appointmentsStore'])->name('appointments.store');
    Route::get('/appointments/{id}',[AdminController::class, 'appointmentsShow'])->name('appointments.show');
    Route::get('/appointments/{id}/edit',[AdminController::class, 'appointmentsEdit'])->name('appointments.edit');
    Route::put('/appointments/{id}',[AdminController::class, 'appointmentsUpdate'])->name('appointments.update');
    Route::delete('/appointments/{id}',[AdminController::class, 'appointmentsDestroy'])->name('appointments.destroy');
});


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Reports
    Route::get('/reports', [AdminController::class, 'reportsIndex'])->name('reports.index');
    Route::get('/reports/elders', [AdminController::class, 'reportsElders'])->name('reports.elders');
    Route::get('/reports/staff', [AdminController::class, 'reportsStaff'])->name('reports.staff');
    Route::get('/reports/attendance', [AdminController::class, 'reportsAttendance'])->name('reports.attendance');
    Route::get('/reports/care-plans', [AdminController::class, 'reportsCarePlans'])->name('reports.care-plans');
    Route::get('/reports/medication', [AdminController::class, 'reportsMedication'])->name('reports.medication');
    Route::get('/reports/appointments', [AdminController::class, 'reportsAppointments'])->name('reports.appointments');

});
