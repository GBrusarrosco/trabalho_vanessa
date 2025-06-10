<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $this->authorize('view-reports'); // Usando authorize para verificar a permissão

        $user = Auth::user();
        $formsQuery = Form::query();

        if ($user->role === 'professor') {
            $formsQuery->where('creator_user_id', $user->id);
        }

        $forms = $formsQuery->with(['questions.answers.student.user', 'creator'])->get();

        // **NOVA LÓGICA PARA PROCESSAR OS DADOS PARA O GRÁFICO**
        $forms->each(function ($form) {
            $form->questions->each(function ($question) {
                if ($question->type === 'multipla_escolha') {
                    // Agrupa as respostas por texto e conta as ocorrências
                    $answerCounts = $question->answers->countBy('answer_text');

                    // Prepara os dados para o Chart.js
                    $question->chart_data = [
                        'labels' => $answerCounts->keys()->all(),
                        'values' => $answerCounts->values()->all(),
                    ];
                }
            });
        });

        return view('reports.index', compact('forms'));
    }
}
