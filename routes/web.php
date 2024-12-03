<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\dtrController;
use App\Http\Controllers\EventController;
use App\Http\Middleware\CheckRole;
use App\Livewire\EmployeeView;
use Illuminate\Support\Facades\Route;

//Payroll Controller
use App\Http\Controllers\PayrollController;
Route::resource('payroll', PayrollController::class);
Route::resource('payroll', PayrollController::class)->middleware('auth');
// Display the list of payrolls
Route::get('/payrolls', [PayrollController::class, 'index'])->name('payroll.index');
// Show the form for adding a new payroll
Route::get('/payrolls/create', [PayrollController::class, 'create'])->name('payroll.create');
// Store the newly created payroll in the database
Route::post('/payrolls', [PayrollController::class, 'store'])->name('payroll.store');
// Edit the payroll
Route::get('/payrolls/{payroll}/edit', [PayrollController::class, 'edit'])->name('payroll.edit');
// Update the payroll data
Route::put('/payrolls/{payroll}', [PayrollController::class, 'update'])->name('payroll.update');
// Delete the payroll
Route::delete('/payrolls/{payroll}', [PayrollController::class, 'destroy'])->name('payroll.destroy');
Route::get('/payroll/{id}', [PayrollController::class, 'show']);
// Alternatively, if you are manually defining the routes:
Route::get('/payroll/{id}', [PayrollController::class, 'show'])->name('payroll.show');

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


// Building Management for registrar
Route::middleware(['auth', CheckRole::class . ':registrar'])->group(function () {
  Route::resource('/registrar/buildings', BuildingController::class);
});


// events
Route::get('/events/{event}', [EventController::class, 'show']);
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
//dtr
Route::get('/dtr', [dtrController::class, 'index'])->name('dtr.index');
Route::get('/dtr/{dtr}', [dtrController::class, 'show'])->name('dtr.show');


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

// Room management routes for Program Head
Route::middleware(['auth', CheckRole::class . ':program_head'])->group(function () {
  Route::resource('/program_head/rooms', RoomController::class)->except(['show']);
});

// Schedule management routes for Program Head
Route::middleware(['auth', CheckRole::class . ':program_head'])->group(function () {
  Route::resource('/program_head/schedules', ScheduleController::class)->except(['show']);
});



// Treasury page, accessible only to Treasury
Route::get('/treasury', function () {
  return view('treasury.dashboard');
})->middleware(['auth', CheckRole::class . ':treasury'])
  ->name('treasury');


Route::get('treasury/payment', [PaymentController::class, 'showPaymentForm'])->name('treasury.payment.create');
Route::post('treasury/payment/store', [PaymentController::class, 'store'])->name('treasury.payment.store');
Route::get('treasury/payment/receipt/{id}', [PaymentController::class, 'showReceipt'])->name('treasury.payment.receipt');
Route::post('/get-student-name', [PaymentController::class, 'getStudentName'])->name('get.student.name');


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
