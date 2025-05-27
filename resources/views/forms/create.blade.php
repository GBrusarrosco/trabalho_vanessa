@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Novo Formulário</h1>

        <form action="{{ route('forms.store') }}" method="POST">
            @csrf
            @include('forms.form')
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection
