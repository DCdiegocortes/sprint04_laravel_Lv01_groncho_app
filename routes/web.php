<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UniverseController;
use App\Http\Controllers\UniverseImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/universe/create', [UniverseController::class, 'create'])->name('universe.create');
    Route::post('/universe', [UniverseController::class, 'store'])->name('universe.store');
    Route::get('/universe/edit', [UniverseController::class, 'edit'])->name('universe.edit');
    Route::put('/universe', [UniverseController::class, 'update'])->name('universe.update');
    Route::post('/universe/images', [UniverseImageController::class, 'store'])->name('universe.images.store');
    Route::delete('/universe/images/{universeImage}', [UniverseImageController::class, 'destroy'])->name('universe.images.destroy');
    Route::get('/universe/{user}', [UniverseController::class, 'show'])->name('universe.show');
});

require __DIR__.'/auth.php';
