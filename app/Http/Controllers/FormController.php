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
        // ATUALIZAÇÃO: Adicionado 'validator' para carregar quem aprovou/reprovou.
        $formsQuery = Form::with(['creator', 'validator'])->withCount('questions')->latest();

        if ($user->role === 'professor') {
            $formsQuery->where('creator_user_id', $user->id);
        }

        $forms = $formsQuery->get();
        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        // Certifique-se de que está passando as turmas para a view de criação
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

        // CORREÇÃO: Removido 'is_validated' e garantido que 'creator_user_id' está correto.
        // O campo 'status' já tem 'pendente' como padrão no banco de dados.
        $form = Form::create([
            'title' => $request->title,
            'description' => $request->description,
            'turma' => $request->turma,
            'ano_letivo' => $request->ano_letivo,
            'creator_user_id' => Auth::id(),
        ]);

        return redirect()->route('forms.edit', $form->id)->with('success', 'Formulário criado! Agora adicione as perguntas abaixo.');
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

    public function approve(Request $request, Form $form)
    {
        Gate::authorize('validate-form', $form);

        $form->update([
            'status' => 'aprovado',
            'rejection_reason' => null, // Limpa qualquer motivo de reprovação anterior
            'validated_by' => Auth::id(),
        ]);

        return redirect()->route('forms.index')->with('success', 'Formulário aprovado com sucesso!');
    }

    public function reject(Request $request, Form $form)
    {
        Gate::authorize('validate-form', $form);

        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500'
        ]);

        $form->update([
            'status' => 'reprovado',
            'rejection_reason' => $request->rejection_reason,
            'validated_by' => Auth::id(), // Registra quem reprovou
        ]);

        return redirect()->route('forms.index')->with('success', 'Formulário reprovado e enviado para revisão.');
    }

    public function resubmit(Request $request, Form $form)
    {
        $this->authorize('resubmit-form', $form); // Usaremos um Gate para autorizar

        $form->update([
            'status' => 'pendente',
            'rejection_reason' => null, // Limpa o motivo da reprovação anterior
            'validated_by' => null,   // Limpa quem validou da última vez
        ]);

        return redirect()->route('forms.index')->with('success', 'Formulário reenviado para análise!');
    }
}

