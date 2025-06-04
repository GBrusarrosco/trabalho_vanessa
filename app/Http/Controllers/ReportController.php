<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Adicionar esta linha

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $formsQuery = Form::with(['questions.answers.student.user', 'creator', 'validator']);

        if ($user->role === 'professor') {

            $formsQuery->where('creator_user_id', $user->id);
        } elseif ($user->role === 'coordenador') {

        } elseif ($user->role === 'admin') {

        } else {

            return view('reports.index', ['forms' => collect()]);
        }

        $forms = $formsQuery->get();


        return view('reports.index', compact('forms'));
    }
}
