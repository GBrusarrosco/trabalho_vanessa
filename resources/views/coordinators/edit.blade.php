@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Coordenador</h1>

        <form action="{{ route('coordinators.update', $coordinator) }}" method="POST">
            @csrf
            @method('PUT')
            @include('coordinators.form')
            <button type="submit" class="btn btn-success">Atualizar</button>
        </form>
    </div>
@endsection
