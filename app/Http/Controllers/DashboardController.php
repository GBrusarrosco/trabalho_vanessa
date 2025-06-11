<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [];
        $recentItems = [];

        // Estatísticas para Admin e Coordenador
        if ($user->role === 'admin' || $user->role === 'coordenador') {
            $stats['total_forms'] = Form::count();
            $stats['pending_forms'] = Form::where('status', 'pendente')->count();
            $stats['approved_forms'] = Form::where('status', 'aprovado')->count();
            $stats['total_students'] = Student::count();
            $stats['total_teachers'] = Teacher::count(); // Garantindo que esta linha esteja presente
        }

        // Estatísticas e Itens para Professor
        if ($user->role === 'professor') {
            $stats['my_forms_count'] = Form::where('creator_user_id', $user->id)->count();
            $stats['my_pending_forms'] = Form::where('creator_user_id', $user->id)->where('status', 'pendente')->count();
            $stats['my_approved_forms'] = Form::where('creator_user_id', $user->id)->where('status', 'aprovado')->count();
            $stats['my_rejected_forms'] = Form::where('creator_user_id', $user->id)->where('status', 'reprovado')->count();

            $recentItems['my_forms'] = Form::where('creator_user_id', $user->id)
                ->with('validator')
                ->orderByRaw("CASE WHEN status = 'reprovado' THEN 1 WHEN status = 'pendente' THEN 2 ELSE 3 END")
                ->latest()
                ->get();
        }

        // Estatísticas e Itens para Aluno
        if ($user->role === 'aluno' && $user->student) {
            $student = $user->student;

            // Pega os IDs dos formulários que o aluno já respondeu
            $answeredFormsIds = $student->answers()
                ->join('questions', 'answers.question_id', '=', 'questions.id')
                ->select('questions.form_id')
                ->distinct()
                ->pluck('form_id');

            // Query para formulários atribuídos e aprovados
            $assignedFormsQuery = Form::where('status', 'aprovado')
                ->where('turma', $student->turma)
                ->where('ano_letivo', $student->ano_letivo);

            // Estatísticas
            $stats['total_assigned_forms'] = (clone $assignedFormsQuery)->count();
            $stats['pending_forms_to_answer'] = (clone $assignedFormsQuery)->whereNotIn('forms.id', $answeredFormsIds)->count();

            // Itens de Ação
            $recentItems['forms_to_answer'] = (clone $assignedFormsQuery)->whereNotIn('forms.id', $answeredFormsIds)->latest()->get();
            // Busca também os formulários concluídos
            $recentItems['completed_forms'] = Form::whereIn('id', $answeredFormsIds)->latest()->take(5)->get();
        }

        // Itens para Coordenador
        if ($user->role === 'coordenador') {
            $recentItems['forms_pending_validation'] = Form::where('status', 'pendente')->with('creator')->latest()->take(5)->get();
        }

        return view('dashboard', compact('user', 'stats', 'recentItems'));
    }
}
