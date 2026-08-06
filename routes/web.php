<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;

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
    
});
