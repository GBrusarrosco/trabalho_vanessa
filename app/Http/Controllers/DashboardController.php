<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Question;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [];
        $recentItems = [];

        // Informações gerais (visíveis para Admin/Coordenador)
        if ($user->role === 'admin' || $user->role === 'coordenador') {
            $stats['total_forms'] = Form::count();
            // CORRIGIDO: Usa o campo 'status' em vez de 'is_validated'
            $stats['pending_forms'] = Form::where('status', 'pendente')->count();
            $stats['approved_forms'] = Form::where('status', 'aprovado')->count();

            $stats['total_students'] = Student::count();
            $stats['total_teachers'] = Teacher::count();
        }

        // Informações específicas para Professor
        if ($user->role === 'professor') {
            $stats['my_forms_count'] = Form::where('creator_user_id', $user->id)->count();
            // CORRIGIDO: Usa o campo 'status' em vez de 'is_validated'
            $stats['my_pending_forms'] = Form::where('creator_user_id', $user->id)->where('status', 'pendente')->count();
            $stats['my_approved_forms'] = Form::where('creator_user_id', $user->id)->where('status', 'aprovado')->count();

            $recentItems['my_recent_forms'] = Form::where('creator_user_id', $user->id)->latest()->take(3)->get();
        }

        // Informações específicas para Aluno
        if ($user->role === 'aluno') {
            $student = $user->student;
            if ($student) {
                // Nova lógica: Busca formulários baseados na turma do aluno
                // CORRIGIDO: Usa o campo 'status' em vez de 'is_validated'
                $assignedFormsQuery = Form::where('status', 'aprovado')
                    ->where('turma', $student->turma)
                    ->where('ano_letivo', $student->ano_letivo);

                $pendingFormsQuery = clone $assignedFormsQuery;

                $answeredFormsIds = $student->answers()->join('questions', 'answers.question_id', '=', 'questions.id')
                    ->select('questions.form_id')->distinct()->pluck('form_id');

                $stats['total_assigned_forms'] = $assignedFormsQuery->count();
                $stats['pending_forms_to_answer'] = $pendingFormsQuery->whereNotIn('forms.id', $answeredFormsIds)->count();

                $recentItems['forms_to_answer'] = Form::where('status', 'aprovado')
                    ->where('turma', $student->turma)
                    ->where('ano_letivo', $student->ano_letivo)
                    ->whereNotIn('forms.id', $answeredFormsIds)
                    ->latest()
                    ->take(3)->get();
            }
        }

        // Para Coordenador, listar formulários pendentes de validação
        if ($user->role === 'coordenador') {
            // CORRIGIDO: Usa o campo 'status' em vez de 'is_validated'
            $recentItems['forms_pending_validation'] = Form::where('status', 'pendente')
                ->with('creator')
                ->latest()->take(5)->get();
        }

        return view('dashboard', compact('user', 'stats', 'recentItems'));
    }
}
