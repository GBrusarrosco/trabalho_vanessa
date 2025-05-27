@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Novo Professor</h1>

        <form action="{{ route('teachers.store') }}" method="POST">
            @csrf
            @include('teachers.form')
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection
