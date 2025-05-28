@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Perguntas</h1>

        <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">Nova Pergunta</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th>Formulário</th>
                <th>Pergunta</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->form->title }}</td>
                    <td>{{ $question->question_text }}</td>
                    <td>{{ $question->type }}</td>
                    <td>
                        <a href="{{ route('questions.edit', $question) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('questions.destroy', $question) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Deseja excluir esta pergunta?')" class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
