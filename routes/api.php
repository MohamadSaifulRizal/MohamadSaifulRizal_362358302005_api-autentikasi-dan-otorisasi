<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;

// Grup middleware auth:sanctum untuk autentikasi
Route::middleware('auth:sanctum')->group(function () {
    // Rute hanya untuk admin
    Route::middleware('admin')->group(function () {
        // Semua operasi CRUD di MahasiswaController untuk admin
        Route::apiResource('mahasiswas', MahasiswaController::class);
    });

    // Rute hanya untuk mahasiswa (akses baca saja)
    Route::middleware('mahasiswa')->group(function () {
        // Hanya operasi GET di MahasiswaController untuk mahasiswa
        Route::get('mahasiswas', [MahasiswaController::class, 'index']);
        Route::get('mahasiswas/{id}', [MahasiswaController::class, 'show']);
    });
});

// Rute untuk registrasi dan login (tanpa autentikasi)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
