@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Alunos</h1>

        <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Novo Aluno</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Documento</th>
                <th>Turma</th>
                <th>Ano Letivo</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->user->name }}</td>
                    <td>{{ $student->user->email }}</td>
                    <td>{{ $student->user->document }}</td>
                    <td>{{ $student->turma }}</td>
                    <td>{{ $student->ano_letivo }}</td>
                    <td>
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
