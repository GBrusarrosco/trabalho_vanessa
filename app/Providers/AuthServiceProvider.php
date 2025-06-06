<?php

namespace App\Providers;

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
            // dd($user->name, $user->email, $user->role); // << COMENTE OU REMOVA ESTA LINHA
            return in_array($user->role, ['admin', 'coordenador', 'professor']);
        });

        Gate::define('validate-form', function (User $user, Form $form) { // Passa $form
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
