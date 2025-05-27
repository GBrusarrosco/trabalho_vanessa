@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Formulário</h1>

        <form action="{{ route('forms.update', $form) }}" method="POST">
            @csrf
            @method('PUT')
            @include('forms.form')
            <button type="submit" class="btn btn-success">Atualizar</button>
        </form>
    </div>
@endsection
