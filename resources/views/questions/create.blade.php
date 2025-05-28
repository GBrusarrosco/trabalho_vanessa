@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nova Pergunta</h1>

        <form method="POST" action="{{ route('questions.store') }}">
            @csrf

            <div class="mb-3">
                <label for="form_id" class="form-label">Formulário</label>
                <select name="form_id" id="form_id" class="form-control" required>
                    @foreach($forms as $form)
                        <option value="{{ $form->id }}">{{ $form->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="question_text" class="form-label">Texto da Pergunta</label>
                <textarea name="question_text" id="question_text" class="form-control" required>{{ old('question_text') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Tipo</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="texto">Texto</option>
                    <option value="multipla_escolha">Múltipla Escolha</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
