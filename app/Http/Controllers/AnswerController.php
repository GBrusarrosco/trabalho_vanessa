<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Form;
use App\Models\Question;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function showForm(Form $form)
    {
        $questions = $form->questions;
        return view('answers.fill', compact('form', 'questions'));
    }

    public function store(Request $request, Form $form)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $student = Student::where('user_id', Auth::id())->firstOrFail();

        foreach ($request->answers as $question_id => $answer_text) {
            Answer::create([
                'student_id' => $student->id,
                'question_id' => $question_id,
                'answer_text' => $answer_text,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Avaliação enviada com sucesso!');
    }
}

