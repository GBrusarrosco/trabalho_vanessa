@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mx-auto max-w-md p-8 bg-white rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6">Cadastro</h2>
        @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 text-center animate-fade-in">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('register.perform') }}" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-900">Nome</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required value="{{ old('name') }}">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required value="{{ old('email') }}">
            </div>
            <div>
                <label for="document" class="block text-sm font-medium text-gray-900">Documento</label>
                <input type="text" name="document" id="document" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required value="{{ old('document') }}">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-900">Senha</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required>
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-900">Confirmar Senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required>
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition">Cadastrar</button>
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-700">Voltar ao login</a>
            </div>
        </form>
    </div>
</div>
@endsection