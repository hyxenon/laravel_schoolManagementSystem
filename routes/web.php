<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\CheckRole;
use App\Livewire\EmployeeView;
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


// Employee
Route::get('/registrar/employee', function () {
  return view('registrar.employee.employee');
})->middleware(['auth', CheckRole::class . ':registrar'])
  ->name('registrar.employee.registrar');

Route::get('/registrar/employees/{id}', [EmployeeController::class, 'show'])->name('employee.show');

// Colleges
Route::get('/registrar/colleges', function () {
  return view('registrar.colleges.colleges');
})->middleware(['auth', CheckRole::class . ':registrar'])
  ->name('registrar.colleges');


// Subjects
Route::get('/registrar/subjects', function () {
  return view('registrar.subjects.subjects');
})->middleware(['auth', CheckRole::class . ':registrar'])
  ->name('registrar.subjects');


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
Route::get('treasury/payment', [PaymentController::class, 'showPaymentForm'])->name('treasury.payment.create');
Route::post('treasury/payment/store', [PaymentController::class, 'store'])->name('treasury.payment.store');
//Route::get('treasury/payment/receipt/{id}', [PaymentController::class, 'showReceipt'])->name('treasury.payment.receipt');
Route::get('treasury/payment/receipt/{id}', [PaymentController::class, 'showReceipt'])->name('treasury.payment.receipt');



//Grade Calculator routes 

Route::get('/teacher/grades', [GradeController::class, 'showSubject'])
->middleware(['auth', CheckRole::class . ':teacher'])
->name('grades.subject');

Route::get('/teacher/grades/{subjectId}', [GradeController::class, 'showStudents'])
  ->middleware(['auth', CheckRole::class . ':teacher'])
  ->name('grades.student');

Route::get('/teacher/grades/{subjectId}/{studentId}', [GradeController::class, 'showStudentGrades'])
  ->middleware(['auth', CheckRole::class . ':teacher'])
  ->name('grades.grade');

require __DIR__ . '/auth.php';
