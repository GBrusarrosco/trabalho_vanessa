@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Pergunta</h1>

        <form method="POST" action="{{ route('questions.update', $question) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="form_id" class="form-label">Formulário</label>
                <select name="form_id" id="form_id" class="form-control" required>
                    @foreach($forms as $form)
                        <option value="{{ $form->id }}" {{ $question->form_id == $form->id ? 'selected' : '' }}>
                            {{ $form->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="question_text" class="form-label">Texto da Pergunta</label>
                <textarea name="question_text" id="question_text" class="form-control" required>{{ $question->question_text }}</textarea>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Tipo</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="texto" {{ $question->type == 'texto' ? 'selected' : '' }}>Texto</option>
                    <option value="multipla_escolha" {{ $question->type == 'multipla_escolha' ? 'selected' : '' }}>Múltipla Escolha</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Atualizar</button>
            <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
