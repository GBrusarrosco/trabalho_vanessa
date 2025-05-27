@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Novo Coordenador</h1>

        <form action="{{ route('coordinators.store') }}" method="POST">
            @csrf
            @include('coordinators.form')
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection
