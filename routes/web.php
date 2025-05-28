<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ProfileController,
    QuestionController,
    ReportController,
    StudentController,
    TeacherController,
    CoordinatorController,
    FormController,
    StudentFormController,
    AnswerController};

use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {

    Route::get('/relatorio', [ReportController::class, 'index'])->name('report.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('students', StudentController::class);


    Route::resource('teachers', TeacherController::class);


    Route::resource('coordinators', CoordinatorController::class);
    Route::resource('questions', QuestionController::class);

    Route::resource('forms', FormController::class);
    Route::post('forms/{form}/validate', [FormController::class, 'validateForm'])->name('forms.validate');


    Route::get('student-form', [StudentFormController::class, 'index'])->name('student-form.index');
    Route::get('student-form/create', [StudentFormController::class, 'create'])->name('student-form.create');
    Route::post('student-form', [StudentFormController::class, 'store'])->name('student-form.store');
    Route::delete('student-form/{id}', [StudentFormController::class, 'destroy'])->name('student-form.destroy');


    Route::get('forms/{form}/responder', [AnswerController::class, 'showForm'])->name('forms.responder');
    Route::post('forms/{form}/responder', [AnswerController::class, 'store'])->name('forms.enviar');
});

