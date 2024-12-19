<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BordadoController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->prefix('bordados')->name('bordados.')->group(function () {
    Route::get('/', [BordadoController::class, 'index'])->name('index');
    Route::get('/create', [BordadoController::class, 'create'])->name('create');
    Route::post('/store', [BordadoController::class, 'store'])->name('store');
    Route::put('/update/{id}', [BordadoController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [BordadoController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
