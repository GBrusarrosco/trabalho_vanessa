@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Coordenadores</h1>
        <a href="{{ route('coordinators.create') }}" class="btn btn-primary mb-3">Novo Coordenador</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Documento</th>
                <th>Departamento</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($coordinators as $coordinator)
                <tr>
                    <td>{{ $coordinator->user->name }}</td>
                    <td>{{ $coordinator->user->email }}</td>
                    <td>{{ $coordinator->user->document }}</td>
                    <td>{{ $coordinator->departamento }}</td>
                    <td>
                        <a href="{{ route('coordinators.edit', $coordinator) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('coordinators.destroy', $coordinator) }}" method="POST" style="display:inline-block">
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
