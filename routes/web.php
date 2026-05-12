<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::prefix('dashboard')->group(function () {

        Route::view('/', 'admin.dashboard')
            ->name('dashboard');

        Route::view('/lessees', 'admin.lessee')
            ->name('lessee.index');

        Route::view('/property-status', 'admin.status')
            ->name('status.index');

        Route::view('/areas', 'admin.area')
            ->name('area.index');

        Route::view('/inspection-reports', 'admin.inspection')
            ->name('inspection.report');

        Route::view('/annual-reports', 'admin.annual')
            ->name('annual.report');
    });

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')
        ->name('settings.profile');

    Volt::route('settings/password', 'settings.password')
        ->name('settings.password');

    Volt::route('settings/appearance', 'settings.appearance')
        ->name('settings.appearance');
});

require __DIR__ . '/auth.php';
