@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Aluno</h1>

        <form method="POST" action="{{ route('students.update', $student) }}">
            @csrf
            @method('PUT')
            @include('students.form')
            <button type="submit" class="btn btn-success">Atualizar</button>
        </form>
    </div>
@endsection
