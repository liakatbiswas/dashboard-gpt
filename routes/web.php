<?php

use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\DashboardController;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)
        ->middleware('can:dashboard.view')
        ->name('dashboard');

    /* Site Settings */
    Route::get('/settings', [SiteSettingController::class, 'edit'])
        ->middleware('can:view,'.SiteSetting::class)
        ->name('settings.edit');

    Route::put('/settings', [SiteSettingController::class, 'update'])
        ->middleware('can:update,'.SiteSetting::class)
        ->name('settings.update');
});
