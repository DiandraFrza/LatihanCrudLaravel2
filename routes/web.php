<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::get('/', [App\Http\Controllers\FileController::class, 'index']);
Route::put('/gambar/{id}', [FileController::class, 'update'])->name('gambar.update');
Route::resource('gambar', FileController::class);
