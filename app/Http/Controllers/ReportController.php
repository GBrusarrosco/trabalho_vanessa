<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $this->authorize('view-reports');

        $user = Auth::user();
        $formsQuery = Form::query();

        if ($user->role === 'professor') {
            $formsQuery->where('creator_user_id', $user->id);
        }

        $forms = $formsQuery->where('status', 'aprovado')
            ->with(['questions.answers', 'creator'])
            ->get();

        // **NOVA LÓGICA PARA PROCESSAR OS DADOS PARA O GRÁFICO E PORCENTAGENS**
        $forms->each(function ($form) {
            $form->questions->each(function ($question) {
                if ($question->type === 'multipla_escolha' && $question->answers->count() > 0) {

                    $answerCounts = $question->answers->countBy('answer_text');
                    $totalAnswers = $question->answers->count();
                    $results = [];

                    // Usa as opções definidas na pergunta para garantir que todas apareçam
                    foreach ($question->options as $option) {
                        $count = $answerCounts->get($option, 0); // Pega a contagem, ou 0 se não houver
                        $percentage = ($totalAnswers > 0) ? ($count / $totalAnswers) * 100 : 0;

                        $results[] = [
                            'option' => $option,
                            'count' => $count,
                            'percentage' => round($percentage, 1) // Arredonda para 1 casa decimal
                        ];
                    }

                    $question->aggregated_results = $results; // Dados para as barras de progresso

                    // Dados separados para o gráfico
                    $question->chart_data = [
                        'labels' => collect($results)->pluck('option')->all(),
                        'values' => collect($results)->pluck('count')->all(),
                    ];
                }
            });
        });

        return view('reports.index', compact('forms'));
    }
}
