<?php

namespace App\Providers;

use App\Models\Form;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('manage-teachers', function (User $user) {
            return $user->role === 'coordenador';
        });

        Gate::define('manage-coordinators', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('view-reports', function (User $user) {
            return in_array($user->role, ['admin', 'coordenador', 'professor']);
        });

        Gate::define('validate-form', function (User $user, Form $form) {
            return in_array($user->role, ['admin', 'coordenador']);
        });

        // ===== INÍCIO DA ALTERAÇÃO =====
        Gate::define('manage-students', function (User $user, ?User $targetUser = null) {
            // Admin, coordenador E PROFESSOR podem gerenciar alunos.
            if (in_array($user->role, ['admin', 'coordenador', 'professor'])) {
                return true;
            }
            // Aluno só pode ver/editar a si mesmo
            if ($user->role === 'aluno' && $targetUser && $user->id === $targetUser->id) {
                return true;
            }

            return false;
        });
        // ===== FIM DA ALTERAÇÃO =====

        Gate::define('create-form', function(User $user) {
            return $user->role === 'professor';
        });

        Gate::define('update-form', function(User $user, Form $form) {
            return $user->id === $form->creator_user_id;
        });

        Gate::define('delete-form', function(User $user, Form $form) {
            return $user->id === $form->creator_user_id;
        });

        // NOVO GATE para a ação de reenviar
        Gate::define('resubmit-form', function (User $user, Form $form) {
            // Permite apenas se o usuário for o criador E o status for 'reprovado'
            return $user->id === $form->creator_user_id && $form->status === 'reprovado';
        });
    }
}
