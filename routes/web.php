<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\FuzzyController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RiwayatController;
use App\Http\Controllers\Admin\DashboardController;

Route::view('/', 'welcome');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/dashboard/test-umur', [DashboardController::class, 'testUmur'])->name('dashboard.testUmur');
        Route::get('/fuzzy/suhu-udara', [FuzzyController::class, 'suhuUdara'])->name('fuzzy.suhu');
        Route::get('/fuzzy/kelembapan-udara', [FuzzyController::class, 'kelembapanUdara'])->name('fuzzy.k_udara');
        Route::get('/fuzzy/kelembapan-tanah', [FuzzyController::class, 'kelembapanTanah'])->name('fuzzy.k_tanah');
        Route::get('/fuzzy/usia-tanaman', [FuzzyController::class, 'usiaTanaman'])->name('fuzzy.usia');
        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
