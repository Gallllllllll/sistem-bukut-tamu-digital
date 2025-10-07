<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\AuthController;

// ===== HALAMAN LOGIN =====
// Route::get('/', function () {
//     return redirect('/login');
// });

Route::middleware(['web'])->group(function () {
    Route::get('/', fn() => redirect('/login')); // ini langusung ke login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout']);
});

// ===== HALAMAN ADMIN (setelah login) =====
Route::middleware(['auth'])->group(function () {
    Route::get('/tampil', [TamuController::class, 'index'])->name('tamus.index');
    Route::get('/tamus/export-excel', [TamuController::class, 'exportExcel'])->name('tamus.exportExcel');
    Route::get('/tamus/export-pdf', [TamuController::class, 'exportPDF'])->name('tamus.exportPDF');
    Route::get('/tamus/statistik', [TamuController::class, 'statistik'])->name('tamus.statistik');
});

// ===== HALAMAN FORM TAMU (publik) =====
Route::get('/tambah', [TamuController::class, 'create'])->name('tamus.create'); //disini

Route::post('/tamus', [TamuController::class, 'store'])->name('tamus.store');
