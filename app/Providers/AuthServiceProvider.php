<?php

namespace App\Providers;

use App\Models\Form;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('manage-teachers', function (User $user) {
            return $user->role === 'coordenador';
        });

        Gate::define('manage-coordinators', function (User $user) {
            // Agora Admin E Coordenador podem gerenciar coordenadores
            return in_array($user->role, ['admin', 'coordenador']);
        });

        Gate::define('view-reports', function (User $user) {
            return in_array($user->role, ['admin', 'coordenador', 'professor']);
        });

        Gate::define('validate-form', function (User $user, Form $form) {
            return in_array($user->role, ['admin', 'coordenador']);
        });

        Gate::define('manage-students', function (User $user, ?User $targetUser = null) {
            if (in_array($user->role, ['admin', 'coordenador', 'professor'])) {
                return true;
            }
            if ($user->role === 'aluno' && $targetUser && $user->id === $targetUser->id) {
                return true;
            }
            return false;
        });

        Gate::define('create-form', function(User $user) {
            return $user->role === 'professor';
        });

        Gate::define('update-form', function(User $user, Form $form) {
            return $user->id === $form->creator_user_id;
        });

        Gate::define('delete-form', function(User $user, Form $form) {
            return $user->id === $form->creator_user_id;
        });

        Gate::define('resubmit-form', function (User $user, Form $form) {
            return $user->id === $form->creator_user_id && $form->status === 'reprovado';
        });
    }
}
