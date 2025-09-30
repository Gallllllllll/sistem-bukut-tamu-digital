<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;


Route::get('/', [TamuController::class,'index'])->name('tamus.index');
Route::get('/tamus/create', [TamuController::class, 'create'])->name('tamus.create');
Route::post('/tamus', [TamuController::class, 'store'])->name('tamus.store');

Route::get('tamus/export-excel', [TamuController::class,'exportExcel'])->name('tamus.exportExcel');
Route::get('/tamus/export-pdf', [TamuController::class,'exportPDF'])->name('tamus.exportPDF');

Route::get('/tamus/statistik', [TamuController::class,'statistik'])->name('tamus.statistik');




