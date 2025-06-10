<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class FormController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $formsQuery = Form::with('creator')->withCount('questions')->latest(); // Carrega o criador, conta as perguntas e ordena pelos mais recentes


        if ($user->role === 'professor') {
            $formsQuery->where('creator_user_id', $user->id);
        }


        $forms = $formsQuery->get();

        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        $turmas = DB::table('students')->select('turma', 'ano_letivo')->distinct()->get();
        return view('forms.create', compact('turmas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'turma' => 'required|string|max:255',
            'ano_letivo' => 'required|string|max:255',
        ]);

        $form = Form::create([
            'title' => $request->title,
            'description' => $request->description,
            'turma' => $request->turma,
            'ano_letivo' => $request->ano_letivo,
            'is_validated' => false,
            'creator_user_id' => Auth::id(),
        ]);

        return redirect()->route('forms.edit', $form->id)->with('success', 'Formulário criado! Adicione as perguntas abaixo.');
    }

    public function edit(Form $form)
    {
        $turmas = DB::table('students')->select('turma', 'ano_letivo')->distinct()->get();
        return view('forms.edit', compact('form', 'turmas'));
    }

    public function update(Request $request, Form $form)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'turma' => 'required|string|max:255',
            'ano_letivo' => 'required|string|max:255',
        ]);

        $form->update($request->only('title', 'description', 'turma', 'ano_letivo'));
        return redirect()->route('forms.index')->with('success', 'Formulário atualizado!');
    }

    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->route('forms.index')->with('success', 'Formulário excluído!');
    }

    public function validateForm(Form $form)
    {
        Gate::authorize('validate-form', $form);

        $form->update([
            'is_validated' => true,
            'validated_by' => Auth::id(),
        ]);

        return redirect()->route('forms.index')->with('success', 'Formulário validado!');
    }
}

