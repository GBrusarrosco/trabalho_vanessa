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
        if ($user && ($user->role === 'admin' || $user->role === 'coordenador')) { // Adicionado $user &&
            $stats['total_forms'] = Form::count();
            $stats['pending_forms'] = Form::where('is_validated', false)->count();
            $stats['approved_forms'] = Form::where('is_validated', true)->count();
            // $stats['expired_forms'] = Form::where('expires_at', '<', now())->count();

            $stats['total_students'] = Student::count();
            $stats['total_teachers'] = Teacher::count();
        }

        // Informações específicas para Professor
        if ($user && $user->role === 'professor') { // Adicionado $user &&
            $stats['my_forms_count'] = Form::where('creator_user_id', $user->id)->count();

            // Para depurar especificamente os formulários pendentes do professor:
            $myPendingFormsForDebug = Form::where('creator_user_id', $user->id)
                ->where('is_validated', false)
                ->get(); // Pega a coleção para inspecionar
            $stats['my_pending_forms'] = $myPendingFormsForDebug->count(); // Depois conta

            $stats['my_approved_forms'] = Form::where('creator_user_id', $user->id)->where('is_validated', true)->count();
            $recentItems['my_recent_forms'] = Form::where('creator_user_id', $user->id)->latest()->take(3)->get();

            // LINHA DE DEBUG PRINCIPAL:
            // Descomente a linha abaixo para ver o ID do usuário, os formulários pendentes que foram encontrados e a contagem.
            // dd('Usuário Professor ID: ' . $user->id, 'Formulários Pendentes Encontrados:', $myPendingFormsForDebug, 'Contagem Pendentes: ' . $stats['my_pending_forms'], 'Todos os Stats para Professor:', $stats);
        }

        // Informações específicas para Aluno
        if ($user && $user->role === 'aluno') { // Adicionado $user &&
            $student = $user->student;
            if ($student) {
                $assignedFormsQuery = $student->forms()->where('is_validated', true);
                $pendingFormsQuery = clone $assignedFormsQuery;
                $answeredFormsIds = $student->answers()->join('questions', 'answers.question_id', '=', 'questions.id')
                    ->select('questions.form_id')->distinct()->pluck('form_id');

                $stats['total_assigned_forms'] = $assignedFormsQuery->count();
                $stats['pending_forms_to_answer'] = $pendingFormsQuery->whereNotIn('forms.id', $answeredFormsIds)->count();

                $recentItems['forms_to_answer'] = $student->forms()
                    ->where('is_validated', true)
                    ->whereNotIn('forms.id', $answeredFormsIds)
                    ->latest('student_form.created_at')
                    ->take(3)->get();
            }
        }

        // Para Coordenador, listar formulários pendentes de validação
        if ($user && $user->role === 'coordenador') { // Adicionado $user &&
            $recentItems['forms_pending_validation'] = Form::where('is_validated', false)
                ->with('creator')
                ->latest()->take(5)->get();
        }


//         dd($user->role, $stats, $recentItems); // Descomente esta linha

        return view('dashboard', compact('user', 'stats', 'recentItems'));
    }
}
