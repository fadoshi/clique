<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('mainpage');
});

Auth::routes();

// Tenant registration route
Route::get('/tenant_register', [TenantController::class, 'showRegistrationForm'])->name('tenants.register');
Route::post('/tenant_register', [TenantController::class, 'register'])->name('tenants.register.store');

// Central domain routes for tenant-specific access
Route::prefix('{tenant}')->group(function () {
    
    // Tenant-specific dashboard route
    Route::middleware(['auth', 'tenant'])->group(function () {
        Route::get('/dashboard', [TenantController::class, 'index'])->name('tenants.dashboard');
        // Other tenant-specific routes, such as post management, can go here.
    });

    // Tenant-specific login route
    Route::get('/login', [TenantController::class, 'showLoginForm'])->name('tenants.login');
    Route::post('/login', [TenantController::class, 'login'])->name('tenants.login.store');
    //Route::post('/logout', [Auth\LoginController::class, 'logout'])->name('tenant.logout');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
