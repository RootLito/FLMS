<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\TestPaymentController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('/dashboard', 'admin.dashboard')
        ->name('dashboard');

    Route::view('/lessees', 'admin.lessee')
        ->name('lessee.index');

    Route::view('/property', 'admin.property')
        ->name('property.index');

    Route::view('/areas', 'admin.area')
        ->name('area.index');

    Route::view('/test-payment', 'admin.test-payment')
        ->name('payment.index');

    Route::post('/test-payment', [TestPaymentController::class, 'send'])
        ->name('payment.send');

    Route::view('/inspection-reports', 'admin.inspection')
        ->name('inspection.report');

    Route::view('/inspection-reports/inspection-template', 'admin.inspection-template')
        ->name('inspection.template');

    Route::view('/annual-reports', 'admin.annual')
        ->name('annual.report');

    Route::view('/annual-reports/annual-template', 'admin.annual-template')
        ->name('annual.template');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')
        ->name('settings.profile');

    Volt::route('settings/password', 'settings.password')
        ->name('settings.password');

    Volt::route('settings/appearance', 'settings.appearance')
        ->name('settings.appearance');
});

require __DIR__ . '/auth.php';