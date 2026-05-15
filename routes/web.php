<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\EmergencyController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\HospitalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EmergencyManageController;
use App\Http\Controllers\Admin\HospitalManageController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes - Medical Emergency System
|--------------------------------------------------------------------------
*/

// ── Landing Page ──
Route::get('/', function () {
    return view('welcome');
});

// ── Authentication Routes ──
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// Logout (any authenticated user)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── User Routes ──
Route::middleware(['auth', 'isUser'])->prefix('user')->name('user.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // SOS Emergency
    Route::post('/sos',   [EmergencyController::class, 'sos'])->name('sos');

    // Add Details after SOS
    Route::get('/emergency/{id}/details',  [EmergencyController::class, 'showDetails'])->name('emergency.details');
    Route::post('/emergency/{id}/details', [EmergencyController::class, 'updateDetails'])->name('emergency.details.store');

    // Emergency History
    Route::get('/history', [EmergencyController::class, 'history'])->name('history');

    // Nearby Hospitals
    Route::get('/hospitals', [HospitalController::class, 'index'])->name('hospitals');

    // Profile
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ── Admin Routes ──
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Emergency Management
    Route::get('/emergencies',             [EmergencyManageController::class, 'index'])->name('emergencies');
    Route::get('/emergencies/{id}',        [EmergencyManageController::class, 'show'])->name('emergencies.show');
    Route::post('/emergencies/{id}/status',[EmergencyManageController::class, 'updateStatus'])->name('emergencies.status');

    // Hospital Management
    Route::get('/hospitals',          [HospitalManageController::class, 'index'])->name('hospitals');
    Route::post('/hospitals',         [HospitalManageController::class, 'store'])->name('hospitals.store');
    Route::get('/hospitals/{id}/edit',[HospitalManageController::class, 'edit'])->name('hospitals.edit');
    Route::put('/hospitals/{id}',     [HospitalManageController::class, 'update'])->name('hospitals.update');
    Route::delete('/hospitals/{id}',  [HospitalManageController::class, 'destroy'])->name('hospitals.destroy');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
});
