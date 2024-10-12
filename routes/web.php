<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Registrar page, accessible only to registrars
Route::get('/registrar', function () {
    return view('registrar');
})->middleware(['auth', CheckRole::class . ':registrar'])
  ->name('registrar');

// Teacher page, accessible only to teachers
Route::get('/teacher', function () {
    return view('teacher');
})->middleware(['auth', CheckRole::class . ':teacher'])
  ->name('teacher');

// Student page, accessible only to students
Route::get('/student', function () {
    return view('student');
})->middleware(['auth', CheckRole::class . ':student'])
  ->name('student');

require __DIR__.'/auth.php';
