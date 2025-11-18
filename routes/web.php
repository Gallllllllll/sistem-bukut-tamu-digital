<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;




// ===== HALAMAN UTAMA & LOGIN =====
Route::middleware(['web'])->group(function () {
    // Halaman utama langsung ke form tamu (bukan login)
    Route::get('/', [TamuController::class, 'create'])->name('home');
    
    // Login admin
    Route::get('/login-admin', [AuthController::class, 'showLogin'])->name('login-admin');
    Route::post('/login-admin', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

// ===== HALAMAN ADMIN (setelah login) =====
Route::middleware(['auth'])->group(function () {
    Route::get('/tampil', [TamuController::class, 'index'])->name('tamus.index');
    Route::get('/tamus/export-excel', [TamuController::class, 'exportExcel'])->name('tamus.exportExcel');
    Route::get('/tamus/export-pdf', [TamuController::class, 'exportPDF'])->name('tamus.exportPDF');
    Route::get('/tamus/statistik', [TamuController::class, 'statistik'])->name('tamus.statistik');
    //Route::get('/tamus/export-statistik-pdf', [TamuController::class, 'exportStatistikPdf'])->name('tamus.export-statistik-pdf');
    //Route::get('/tamus/export-statistik', [App\Http\Controllers\TamuController::class, 'exportStatistik'])->name('tamus.exportStatistik');
    Route::get('/tamus/export/statistik', [TamuController::class, 'exportStatistik'])->name('tamus.exportStatistik');
    Route::get('/export-statistik', [TamuController::class, 'exportStatistik'])->name('tamus.exportStatistik');


    Route::delete('/tamus/{id}', [TamuController::class, 'destroy'])->name('tamus.destroy');
});

// ===== HALAMAN FORM TAMU (publik) =====
Route::get('/tambah', [TamuController::class, 'create'])->name('tamus.create');
Route::post('/tamus', [TamuController::class, 'store'])->name('tamus.store');



Route::get('/tamus/edit/{id}', [TamuController::class, 'edit'])->name('tamus.edit');
Route::post('/tamus/update/{id}', [TamuController::class, 'update'])->name('tamus.update');

// Menampilkan halaman login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Menampilkan halaman registrasi


Route::get('/dashboard', function () {return view('dashboard');})->middleware('auth');



Route::get('/register', [RegisteredUserController::class, 'index'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']); // Menyimpan data dan redirect ke halaman create
Route::get('/create', [SomeController::class, 'create'])->name('create'); // Ganti dengan controller yang sesuai



// Route to show login form
Route::get('/loginuser', [AuthenticatedSessionController::class, 'create'])->name('loginuser');

// Route to handle login form submission
Route::post('/loginuser', [AuthenticatedSessionController::class, 'store']);

// Route to logout
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
