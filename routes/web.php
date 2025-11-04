<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\AuthController;


// ===== HALAMAN UTAMA & LOGIN =====
Route::middleware(['web'])->group(function () {
    // Halaman utama langsung ke form tamu (bukan login)
    Route::get('/', [TamuController::class, 'create'])->name('home');

    // Login admin
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

// ===== HALAMAN ADMIN (setelah login) =====
Route::middleware(['auth'])->group(function () {
    Route::get('/tampil', [TamuController::class, 'index'])->name('tamus.index');
    Route::get('/tamus/export-excel', [TamuController::class, 'exportExcel'])->name('tamus.exportExcel');
    Route::get('/tamus/export-pdf', [TamuController::class, 'exportPDF'])->name('tamus.exportPDF');
    Route::get('/tamus/statistik', [TamuController::class, 'statistik'])->name('tamus.statistik');
    //Route::get('/tamus/export-statistik-pdf', [TamuController::class, 'exportStatistikPdf'])->name('tamus.export-statistik-pdf');
Route::get('/tamus/export-statistik', [App\Http\Controllers\TamuController::class, 'exportStatistik'])
    ->name('tamus.exportStatistik');

    Route::delete('/tamus/{id}', [TamuController::class, 'destroy'])->name('tamus.destroy');
});

// ===== HALAMAN FORM TAMU (publik) =====
Route::get('/tambah', [TamuController::class, 'create'])->name('tamus.create');
Route::post('/tamus', [TamuController::class, 'store'])->name('tamus.store');



Route::get('/tamus/edit/{id}', [TamuController::class, 'edit'])->name('tamus.edit');
Route::post('/tamus/update/{id}', [TamuController::class, 'update'])->name('tamus.update');
