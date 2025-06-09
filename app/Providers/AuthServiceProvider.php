<?php

namespace App\Providers;

use App\Models\Form; // <-- ESTA LINHA É A CORREÇÃO MAIS IMPORTANTE
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
            // Vamos manter o dd() aqui para confirmar que o Gate agora é executado
            return $user->role === 'coordenador';
        });


        Gate::define('manage-coordinators', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('view-reports', function (User $user) {
            return in_array($user->role, ['admin', 'coordenador', 'professor']);
        });

        Gate::define('validate-form', function (User $user, Form $form) {
            return $user->role === 'admin' || $user->role === 'coordenador';
        });

        Gate::define('manage-students', function (User $user, ?User $targetUser = null) {
            // Admin e coordenador podem tudo, aluno só pode ver/editar a si mesmo
            if (in_array($user->role, ['admin', 'coordenador'])) {
                return true;
            }
            if ($user->role === 'aluno' && $targetUser && $user->id === $targetUser->id) {
                return true;
            }
            return false;
        });
    }
}
