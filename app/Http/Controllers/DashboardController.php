<?php

namespace App\Http\Controllers; // << GARANTA QUE ESTE NAMESPACE ESTÁ CORRETO

use App\Models\Form;
use App\Models\Question;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller // << GARANTA QUE O NOME DA CLASSE ESTÁ CORRETO
{
    public function index()
    {
        $user = Auth::user();
        $stats = [];
        $recentItems = [];

        // Informações gerais (visíveis para Admin/Coordenador)
        if ($user->role === 'admin' || $user->role === 'coordenador') {
            $stats['total_forms'] = Form::count();
            $stats['pending_forms'] = Form::where('is_validated', false)->count();
            $stats['approved_forms'] = Form::where('is_validated', true)->count();
            // $stats['expired_forms'] = Form::where('expires_at', '<', now())->count(); // Exigiria campo 'expires_at'

            $stats['total_students'] = Student::count();
            $stats['total_teachers'] = Teacher::count();
        }

        // Informações específicas para Professor
        if ($user->role === 'professor') {
            $stats['my_forms_count'] = Form::where('creator_user_id', $user->id)->count();
            $stats['my_pending_forms'] = Form::where('creator_user_id', $user->id)->where('is_validated', false)->count();
            $stats['my_approved_forms'] = Form::where('creator_user_id', $user->id)->where('is_validated', true)->count();
            $recentItems['my_recent_forms'] = Form::where('creator_user_id', $user->id)->latest()->take(3)->get();
        }

        // Informações específicas para Aluno
        if ($user->role === 'aluno') {
            $student = $user->student;
            if ($student) {
                $assignedFormsQuery = $student->forms()->where('is_validated', true);

                // Clonar a query para não afetar a contagem total ao adicionar o whereNotIn
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
        if ($user->role === 'coordenador') {
            $recentItems['forms_pending_validation'] = Form::where('is_validated', false)
                ->with('creator') // Carregar quem criou
                ->latest()->take(5)->get();
        }

        return view('dashboard', compact('user', 'stats', 'recentItems'));
    }
}
