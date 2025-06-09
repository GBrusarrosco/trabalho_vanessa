<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::with('creator')->get();
        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        return view('forms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        $form = Form::create([ // Salve a instância do formulário criado
            'title' => $request->title,
            'description' => $request->description,
            'is_validated' => false,
            'creator_user_id' => Auth::id(),
        ]);

        // Redireciona para a página de edição do formulário recém-criado
        // para que o usuário possa adicionar perguntas
        return redirect()->route('forms.edit', $form->id)->with('success', 'Formulário criado! Adicione as perguntas abaixo.');
    }

    public function edit(Form $form)
    {
        return view('forms.edit', compact('form'));
    }

    public function update(Request $request, Form $form)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        $form->update($request->only('title', 'description'));
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

