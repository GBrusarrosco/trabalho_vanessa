@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Novo Aluno</h1>

        <form method="POST" action="{{ route('students.store') }}">
            @csrf
            @include('students.form')
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection
