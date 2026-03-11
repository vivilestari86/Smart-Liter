<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\FuzzyController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RiwayatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\homepage\LandingJurnalController as JurnalController;
use App\Http\Controllers\homepage\LandingController;
use App\Http\Controllers\homepage\LandingFuzzyController;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::post('/kalkulator/hitung', [LandingFuzzyController::class, 'hitung'])->name('kalkulator.hitung');
Route::get('/jurnal/{journal}/download', [JurnalController::class, 'download'])->name('jurnal.download');
Route::get('/jurnal/{journal}/view', [JurnalController::class, 'view'])->name('jurnal.view');

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
        Route::get('/fuzzy/output', [FuzzyController::class, 'output'])->name('fuzzy.output');
        Route::post('/fuzzy/{slug}/save', [FuzzyController::class, 'save'])->name('fuzzy.save');
        Route::post('/fuzzy/{slug}/test', [FuzzyController::class, 'test'])->name('fuzzy.test');
        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::delete('/riwayat/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
        Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
        // journal management routes
        Route::get('/artikel', [\App\Http\Controllers\Admin\JournalController::class, 'index'])->name('jurnal.index');
        Route::get('/artikel/create', [\App\Http\Controllers\Admin\JournalController::class, 'create'])->name('jurnal.create');
        Route::post('/artikel', [\App\Http\Controllers\Admin\JournalController::class, 'store'])->name('jurnal.store');
        Route::get('/artikel/{journal}/edit', [\App\Http\Controllers\Admin\JournalController::class, 'edit'])->name('jurnal.edit');
        Route::put('/artikel/{journal}', [\App\Http\Controllers\Admin\JournalController::class, 'update'])->name('jurnal.update');
        Route::delete('/artikel/{journal}', [\App\Http\Controllers\Admin\JournalController::class, 'destroy'])->name('jurnal.destroy');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});


