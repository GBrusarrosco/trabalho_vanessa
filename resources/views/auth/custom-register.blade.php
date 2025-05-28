@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Cadastro</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.perform') }}">
            @csrf

            <div class="mb-3">
                <label>Nome:</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label>Documento:</label>
                <input type="text" name="document" class="form-control" required value="{{ old('document') }}">
            </div>

            <div class="mb-3">
                <label>Senha:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirmar Senha:</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Cadastrar</button>
            <a href="{{ route('login') }}" class="btn btn-link">Voltar ao login</a>
        </form>
    </div>
@endsection
