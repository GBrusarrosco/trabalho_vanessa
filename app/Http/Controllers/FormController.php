<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::all();
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

        Form::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_validated' => false,
        ]);

        return redirect()->route('forms.index')->with('success', 'Formulário criado!');
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
        $form->update([
            'is_validated' => true,
            'validated_by' => Auth::id(),
        ]);

        return redirect()->route('forms.index')->with('success', 'Formulário validado!');
    }
}

