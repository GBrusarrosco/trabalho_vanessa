<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    DashboardController,
    ProfileController,
    QuestionController,
    ReportController,
    StudentController,
    TeacherController,
    CoordinatorController,
    FormController,
    AnswerController
};
// O StudentFormController foi removido pois a lógica agora é por turmas.

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Para Visitantes)
|--------------------------------------------------------------------------
|
| Rotas de login e registro que não exigem que o usuário esteja logado.
|
*/

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');



/*
|--------------------------------------------------------------------------
| Rotas Autenticadas
|--------------------------------------------------------------------------
|
| Rotas que exigem que o usuário esteja logado.
|
*/
Route::middleware(['auth'])->group(function () {

    // Rota de Logout
//    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    | Rotas que também exigem que o e-mail seja verificado
    */
    Route::middleware('verified')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // A rota de relatório exige verificação E permissão do Gate
        Route::get('/relatorio', [ReportController::class, 'index'])
            ->name('report.index')
            ->middleware('can:view-reports');
    });


    /*
    | Rotas de gerenciamento de perfil e CRUDs
    */

    // Perfil do Usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUDs com permissões específicas
    Route::resource('teachers', TeacherController::class)->middleware('can:manage-teachers');
    Route::resource('coordinators', CoordinatorController::class)->middleware('can:manage-coordinators');
    Route::resource('students', StudentController::class)->middleware('can:manage-students');

    // CRUDs de Formulários e Perguntas
    Route::resource('forms', FormController::class);
    Route::resource('questions', QuestionController::class);

    // Ações Específicas de Formulários (Aprovar/Reprovar)
    Route::post('forms/{form}/approve', [FormController::class, 'approve'])->name('forms.approve');
    Route::post('forms/{form}/reject', [FormController::class, 'reject'])->name('forms.reject');

    // Ações do Aluno para Responder Formulários
    Route::get('forms/{form}/responder', [AnswerController::class, 'showForm'])->name('forms.responder');
    Route::post('forms/{form}/responder', [AnswerController::class, 'store'])->name('forms.enviar');
});

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação Auxiliares (Breeze)
|--------------------------------------------------------------------------
| Carrega rotas como 'esqueci minha senha', verificação de email, etc.
*/
//require __DIR__.'/auth.php';
