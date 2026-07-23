<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

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

// About Page
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Services Page
Route::get('/services', [HomeController::class, 'services'])->name('services');

// Features Page
Route::get('/features', [HomeController::class, 'features'])->name('features');

// Contact Page
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Contact Form Submission (with transaction)
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================

// Login Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// ==========================================
// PROTECTED ROUTES (Requires Authentication)
// ==========================================

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Resident Management
    Route::get('/residents', [HomeController::class, 'getResidents'])->name('residents.index');
    Route::get('/residents/create', [HomeController::class, 'createResident'])->name('residents.create');
    Route::post('/residents', [HomeController::class, 'storeResident'])->name('residents.store');
    Route::get('/residents/{id}', [HomeController::class, 'showResident'])->name('residents.show');
    Route::get('/residents/{id}/edit', [HomeController::class, 'editResident'])->name('residents.edit');
    Route::put('/residents/{id}', [HomeController::class, 'updateResident'])->name('residents.update');
    Route::delete('/residents/{id}', [HomeController::class, 'deleteResident'])->name('residents.delete');

    // Caregiver Management
    Route::get('/caregivers', [HomeController::class, 'getCaregivers'])->name('caregivers.index');
    Route::get('/caregivers/create', [HomeController::class, 'createCaregiver'])->name('caregivers.create');
    Route::post('/caregivers', [HomeController::class, 'storeCaregiver'])->name('caregivers.store');
    Route::get('/caregivers/{id}', [HomeController::class, 'showCaregiver'])->name('caregivers.show');
    Route::get('/caregivers/{id}/edit', [HomeController::class, 'editCaregiver'])->name('caregivers.edit');
    Route::put('/caregivers/{id}', [HomeController::class, 'updateCaregiver'])->name('caregivers.update');
    Route::delete('/caregivers/{id}', [HomeController::class, 'deleteCaregiver'])->name('caregivers.delete');

    // Care Plans
    Route::get('/care-plans', [HomeController::class, 'getCarePlans'])->name('care-plans.index');
    Route::get('/care-plans/create', [HomeController::class, 'createCarePlan'])->name('care-plans.create');
    Route::post('/care-plans', [HomeController::class, 'storeCarePlan'])->name('care-plans.store');
    Route::get('/care-plans/{id}', [HomeController::class, 'showCarePlan'])->name('care-plans.show');
    Route::get('/care-plans/{id}/edit', [HomeController::class, 'editCarePlan'])->name('care-plans.edit');
    Route::put('/care-plans/{id}', [HomeController::class, 'updateCarePlan'])->name('care-plans.update');
    Route::delete('/care-plans/{id}', [HomeController::class, 'deleteCarePlan'])->name('care-plans.delete');

    // API Routes for AJAX calls
    Route::post('/update-statistics', [HomeController::class, 'updateStatistics'])->name('update.statistics');
});

// ==========================================
// ADMIN ROUTES (Requires Admin Role)
// ==========================================

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // User Management
    Route::get('/users', [AdminController::class, 'getUsers'])->name('admin.users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    // System Settings
    Route::get('/settings', [AdminController::class, 'getSettings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

    // Backup & Maintenance
    Route::get('/backup', [AdminController::class, 'backup'])->name('admin.backup');
    Route::post('/maintenance', [AdminController::class, 'toggleMaintenance'])->name('admin.maintenance');
});

// ==========================================
// FALLBACK ROUTE (404 Page)
// ==========================================

Route::fallback(function () {
    return view('errors.404');
});

// ==========================================
// TEST ROUTE (For checking DB connection)
// ==========================================

Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        $tables = DB::select('SHOW TABLES');
        
        return response()->json([
            'status' => 'connected',
            'database' => DB::connection()->getDatabaseName(),
            'tables' => array_map('current', $tables)
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});