@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Formulários de Avaliação</h1>
        <a href="{{ route('forms.create') }}" class="btn btn-primary mb-3">Novo Formulário</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Validação</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($forms as $form)
                <tr>
                    <td>{{ $form->title }}</td>
                    <td>{{ $form->description }}</td>
                    <td>
                        @if ($form->is_validated)
                            <span class="text-success">Validado</span>
                        @else
                            <span class="text-danger">Pendente</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('forms.edit', $form) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('forms.destroy', $form) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Excluir este formulário?')">Excluir</button>
                        </form>
                        @if (!$form->is_validated)
                            <form action="{{ route('forms.validate', $form) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button class="btn btn-success btn-sm">Validar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
