<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('form')->get();
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        $forms = Form::all();
        return view('questions.create', compact('forms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'form_id' => 'required|exists:forms,id',
            'question_text' => 'required',
            'type' => 'required|in:texto,multipla_escolha',
        ]);

        Question::create($request->all());

        return redirect()->route('questions.index')->with('success', 'Pergunta criada!');
    }

    public function edit(Question $question)
    {
        $forms = Form::all();
        return view('questions.edit', compact('question', 'forms'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'form_id' => 'required|exists:forms,id',
            'question_text' => 'required',
            'type' => 'required|in:texto,multipla_escolha',
        ]);

        $question->update($request->all());

        return redirect()->route('questions.index')->with('success', 'Pergunta atualizada!');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Pergunta excluída!');
    }
}

