<?php

use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\RegistrationSettingController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendingAccountController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Middleware\EnsureSuperAdmin;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware('auth')->group(function (): void {
    Route::get('/account/pending', PendingAccountController::class)->name('account.pending');
    Route::get('/student/dashboard', StudentDashboardController::class)
        ->middleware('can:student.dashboard.view')->name('student.dashboard');

    Route::middleware(EnsureSuperAdmin::class)->group(function (): void {
        Route::get('/dashboard', DashboardController::class)
            ->middleware('can:dashboard.view')->name('dashboard');

        Route::get('/settings', [SiteSettingController::class, 'edit'])
            ->middleware('can:view,'.SiteSetting::class)->name('settings.edit');
        Route::put('/settings', [SiteSettingController::class, 'update'])
            ->middleware('can:update,'.SiteSetting::class)->name('settings.update');

        Route::resource('roles', RoleController::class)->except('show');
        Route::resource('permissions', PermissionController::class)->except('show');
        Route::get('/registration-settings', [RegistrationSettingController::class, 'edit'])->name('registration.edit');
        Route::put('/registration-settings', [RegistrationSettingController::class, 'update'])->name('registration.update');
    });
});
