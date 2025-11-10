<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GajiController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});


// =====================
// 🔹 DASHBOARD UMUM
// =====================
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// =====================
// 🔹 ROUTE ADMIN
// =====================
// routes/web.php
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('/karyawan', \App\Http\Controllers\Admin\KaryawanController::class);
    Route::resource('/jabatan', \App\Http\Controllers\Admin\JabatanController::class);
    Route::resource('/rating', \App\Http\Controllers\Admin\RatingController::class);
    Route::resource('/lembur', \App\Http\Controllers\Admin\LemburController::class);

    // GAJI ROUTES - pastikan urutannya seperti ini
    Route::get('gaji/calculate', [GajiController::class, 'calculate'])->name('gaji.calculate');
    Route::get('gaji/check-period', [GajiController::class, 'checkPeriod'])->name('gaji.checkPeriod'); // ✅ INI HARUS DITAMBAHKAN
    Route::get('gaji/cetak/{id}', [GajiController::class, 'cetak'])->name('gaji.cetak');
    Route::patch('gaji/{id}/serahkan', [GajiController::class, 'serahkan'])->name('gaji.serahkan');
    Route::resource('gaji', GajiController::class);

    Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
});



// =====================
// 🔹 ROUTE MANAGER
// =====================
Route::middleware(['auth', 'verified', 'manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');

    Route::resource('/karyawan', \App\Http\Controllers\Manager\KaryawanController::class);
    Route::resource('/jabatan', \App\Http\Controllers\Manager\JabatanController::class);
    Route::resource('/rating', \App\Http\Controllers\Manager\RatingController::class);
    Route::resource('/lembur', \App\Http\Controllers\Manager\LemburController::class);

    Route::get('gaji/calculate', [\App\Http\Controllers\Manager\GajiController::class, 'calculate'])->name('gaji.calculate');
    Route::resource('/gaji', \App\Http\Controllers\Manager\GajiController::class);

    Route::post('gaji/check-period', [\App\Http\Controllers\Manager\GajiController::class, 'checkPeriod'])->name('gaji.check-period');
    Route::get('gaji/{id}/cetak', [\App\Http\Controllers\Manager\GajiController::class, 'cetak'])->name('gaji.cetak');
    Route::resource('/gaji-saya', \App\Http\Controllers\Manager\GajiSayaController::class);
    Route::get('gaji-saya/{id}/cetak', [\App\Http\Controllers\Manager\GajiSayaController::class, 'cetak'])->name('gaji-saya.cetak');
});

// =====================
// 🔹 ROUTE KARYAWAN
// =====================
Route::middleware(['auth', 'verified', 'karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Karyawan\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/karyawan', \App\Http\Controllers\Karyawan\KaryawanController::class);
    Route::resource('/jabatan', \App\Http\Controllers\Karyawan\JabatanController::class);
    Route::resource('/rating', \App\Http\Controllers\Karyawan\RatingController::class);
    Route::resource('/gaji', \App\Http\Controllers\Karyawan\GajiController::class);
    Route::get('/gaji/{id}/cetak', [App\Http\Controllers\Karyawan\GajiController::class, 'cetak'])->name('gaji.cetak');
});


// =====================
// 🔹 SETTINGS (LIVEWIRE VOLT)
// =====================
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__ . '/auth.php';
