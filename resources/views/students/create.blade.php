@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Novo Aluno</h1>
    <form method="POST" action="{{ route('students.store') }}" class="space-y-6 bg-white p-8 rounded-xl shadow">
        @csrf
        @include('students.form')
        <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition">Salvar</button>
    </form>
</div>
@endsection
