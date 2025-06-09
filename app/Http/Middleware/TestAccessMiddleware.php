<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Adicione
use Symfony\Component\HttpFoundation\Response;

class TestAccessMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        // Este dd() DEVE ser executado se o middleware for chamado
        dd('TestAccessMiddleware executado!', 'Usuário:', $user->name ?? 'Ninguém logado', 'Papel:', $user->role ?? 'Sem papel');

        // Se quiser testar o Gate aqui dentro (depois de confirmar que o middleware é chamado):
        // if ($user && $user->can('view-reports')) {
        //     dd('Usuário PODE ver relatórios, segundo o Gate dentro do TestAccessMiddleware');
        //     return $next($request);
        // } else {
        //     dd('Usuário NÃO PODE ver relatórios, segundo o Gate dentro do TestAccessMiddleware');
        //     abort(403, 'Acesso negado pelo TestAccessMiddleware.');
        // }

        return $next($request); // Deixe assim para o primeiro teste
    }
}
