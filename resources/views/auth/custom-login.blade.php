@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Login</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.perform') }}">
            @csrf

            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label>Senha:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Entrar</button>
            <a href="{{ route('register') }}" class="btn btn-link">Criar conta</a>
        </form>
    </div>
@endsection
