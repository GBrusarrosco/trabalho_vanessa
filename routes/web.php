<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    StudentController,
    TeacherController,
    CoordinatorController,
    FormController,
    StudentFormController,
    AnswerController
};

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('students', StudentController::class);


    Route::resource('teachers', TeacherController::class);


    Route::resource('coordinators', CoordinatorController::class);


    Route::resource('forms', FormController::class);
    Route::post('forms/{form}/validate', [FormController::class, 'validateForm'])->name('forms.validate');


    Route::get('student-form', [StudentFormController::class, 'index'])->name('student-form.index');
    Route::get('student-form/create', [StudentFormController::class, 'create'])->name('student-form.create');
    Route::post('student-form', [StudentFormController::class, 'store'])->name('student-form.store');
    Route::delete('student-form/{id}', [StudentFormController::class, 'destroy'])->name('student-form.destroy');


    Route::get('forms/{form}/responder', [AnswerController::class, 'showForm'])->name('forms.responder');
    Route::post('forms/{form}/responder', [AnswerController::class, 'store'])->name('forms.enviar');
});


require __DIR__.'/auth.php';

