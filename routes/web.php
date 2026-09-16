<?php

use App\Http\Controllers\TestPaymentController;
use App\Http\Controllers\InspectionReportPdfController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Public Routes
Route::view('/', 'welcome')->name('home');

// Authenticated & Verified Routes
Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::view('/lessees', 'admin.lessee')->name('lessee.index');
    Route::view('/property', 'admin.property')->name('property.index');
    Route::view('/areas', 'admin.area')->name('area.index');
    Route::view('/payments', 'admin.payment')->name('payment.index');
    Route::view('/dl-forms', 'admin.dl-forms')->name('dl-forms.index');

    // Test Payment
    Route::prefix('test-payment')->name('test-payment.')->group(function () {
        Route::view('/', 'admin.test-payment')->name('index');
        Route::post('/', [TestPaymentController::class, 'send'])->name('send');
    });

    // Inspection Reports
    Route::prefix('inspection-reports')->name('inspection.')->group(function () {
        Route::view('/', 'admin.inspection')->name('report');
        Route::view('/inspection-template', 'admin.inspection-template')->name('template');
        Route::get('/{report}/edit', function (App\Models\InspectionReport $report) {
            return view('admin.inspection-edit', ['report' => $report]);
        })->name('edit');
        Route::get('/{id}/pdf', [InspectionReportPdfController::class, 'download'])
            ->name('pdf');
    });

    // Annual Reports
    Route::prefix('annual-reports')->name('annual.')->group(function () {
        Route::view('/', 'admin.annual')->name('report');
        Route::view('/annual-template', 'admin.annual-template')->name('template');
    });

    // Settings
    Route::redirect('settings', 'settings/profile');
    Route::prefix('settings')->name('settings.')->group(function () {
        Volt::route('/profile', 'settings.profile')->name('profile');
        Volt::route('/password', 'settings.password')->name('password');
        Volt::route('/appearance', 'settings.appearance')->name('appearance');
    });

});

require __DIR__ . '/auth.php';