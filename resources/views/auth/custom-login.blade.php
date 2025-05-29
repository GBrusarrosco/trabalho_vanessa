@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mx-auto max-w-md p-8 bg-white rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6">Login</h2>
        @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 text-center animate-fade-in">
            {{ $errors->first() }}
        </div>
        @endif
        <form method="POST" action="{{ route('login.perform') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required autofocus>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required>
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-200">Entrar</button>
            <div class="text-center mt-4">
                <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-indigo-600">Criar conta</a>
            </div>
        </form>
    </div>
</div>
@endsection