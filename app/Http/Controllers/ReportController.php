<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Não precisa de 'use Illuminate\Support\Facades\Gate;' se o middleware da rota cuida da autorização

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // REMOVA ou COMENTE o bloco de verificação do Gate daqui:
        /*
        if (!$user) {
            dd('Usuário não autenticado no ReportController');
        }
        if (Gate::denies('view-reports', $user)) {
            abort(403, 'Acesso negado pelo Gate::denies no ReportController.');
        }
        */

        $formsQuery = Form::query();
        if ($user && $user->role === 'professor') { // $user->role estará disponível
            $formsQuery->where('creator_user_id', $user->id);
        } elseif ($user && $user->role === 'coordenador') {
            // $formsQuery->where('is_validated', true);
        }
        // Admin vê todos

        $forms = $formsQuery->with(['questions.answers.student.user', 'creator', 'validator'])->get();

        // Certifique-se que a view 'reports.index' existe e está convertida para <x-app-layout>
        return view('reports.index', compact('forms'));
    }
}
