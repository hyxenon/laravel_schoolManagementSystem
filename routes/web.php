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
  return view('registrar.dashboard');
})->middleware(['auth', CheckRole::class . ':registrar'])
  ->name('registrar');


Route::get('/registrar/employee/registrar', function () {
  return view('registrar.employee.registrar.employee_registrar');
})->middleware(['auth', CheckRole::class . ':registrar'])
  ->name('registrar.employee.registrar');

// Teacher page, accessible only to teachers
Route::get('/teacher', function () {
  return view('professor.dashboard');
})->middleware(['auth', CheckRole::class . ':teacher'])
  ->name('teacher');

// Student page, accessible only to students
Route::get('/student', function () {
  return view('student.dashboard');
})->middleware(['auth', CheckRole::class . ':student'])
  ->name('student');

// Program Head page, accessible only to Program Head
Route::get('/program_head', function () {
  return view('program_head.dashboard');
})->middleware(['auth', CheckRole::class . ':program_head'])
  ->name('program_head');

// Treasury page, accessible only to Treasury
Route::get('/treasury', function () {
  return view('treasury.dashboard');
})->middleware(['auth', CheckRole::class . ':treasury'])
  ->name('treasury');

require __DIR__ . '/auth.php';
