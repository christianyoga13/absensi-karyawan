<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [AbsensiController::class, 'index']);
    Route::get('/absen-keluar', [AbsensiController::class, 'absenKeluar']);
    Route::get('/cek-absensi', [AbsensiController::class, 'cekAbsensi']);

    Route::prefix('api')->group(function () {
        Route::post('/absen-masuk', [AbsensiController::class, 'absenMasuk']);
        Route::post('/absen-pulang', [AbsensiController::class, 'absenPulang']);
        Route::get('/absensi', [AbsensiController::class, 'getAbsensi']);
        Route::get('/absensi-today', [AbsensiController::class, 'getAbsensiToday']);
        Route::get('/statistik', [AbsensiController::class, 'getStatistik']);
    });
});
