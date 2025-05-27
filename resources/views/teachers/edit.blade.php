@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Professor</h1>

        <form action="{{ route('teachers.update', $teacher) }}" method="POST">
            @csrf
            @method('PUT')
            @include('teachers.form')
            <button type="submit" class="btn btn-success">Atualizar</button>
        </form>
    </div>
@endsection
