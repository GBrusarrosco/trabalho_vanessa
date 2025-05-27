@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Professores</h1>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary mb-3">Novo Professor</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Documento</th>
                <th>Área</th>
                <th>Observações</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->user->name }}</td>
                    <td>{{ $teacher->user->email }}</td>
                    <td>{{ $teacher->user->document }}</td>
                    <td>{{ $teacher->area }}</td>
                    <td>{{ $teacher->observacoes }}</td>
                    <td>
                        <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
