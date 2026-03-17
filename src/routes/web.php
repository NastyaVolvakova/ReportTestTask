<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\ProcessController::class, 'index'])->name('processes.index');
Route::get('/download/{filePath}', [\App\Http\Controllers\ProcessController::class, 'downloadFile'])->name('file.download');
