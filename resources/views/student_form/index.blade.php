@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Associações de Alunos a Formulários</h1>
        <a href="{{ route('student-form.create') }}" class="btn btn-primary mb-3">Nova Associação</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Aluno</th>
                <th>Formulário</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($associacoes as $item)
                <tr>
                    <td>{{ $item->student_id }}</td>
                    <td>{{ $item->form_title }}</td>
                    <td>
                        <form action="{{ route('student-form.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Remover associação?')">Remover</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
