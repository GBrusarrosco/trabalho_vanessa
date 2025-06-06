<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    QuestionController,
    ReportController,
    StudentController,
    TeacherController,
    CoordinatorController,
    FormController,
    StudentFormController,
    AnswerController
};

use App\Http\Controllers\AuthController; // Importação correta

use Illuminate\Support\Facades\Auth;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Route::get('/dashboard', function () {
//    $user = Auth::user();
//    return view('dashboard', compact('user'));
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index']) // Nova rota
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Permite acesso ao relatório para admin, coordenador, professor e aluno autenticado
    Route::get('/relatorio', [ReportController::class, 'index'])->name('report.index');
});

Route::middleware(['auth'])->group(function () {

    // Em web.php


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class)->middleware('can:manage-teachers');
    Route::resource('coordinators', CoordinatorController::class)->middleware('can:manage-coordinators');

    Route::get('students/{student}/mini-report', [\App\Http\Controllers\StudentController::class, 'miniReport'])
        ->middleware(['auth'])
        ->name('students.mini-report');

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
