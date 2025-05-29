@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-indigo-700 mb-6">Alunos</h1>

    <a href="{{ route('students.create') }}" class="inline-block mb-4 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition">Novo Aluno</a>

    @if (session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 text-center animate-fade-in">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-indigo-100">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Nome</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Documento</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Turma</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Ano Letivo</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Ações</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @foreach ($students as $student)
                <tr>
                    <td class="px-4 py-2">{{ $student->user->name }}</td>
                    <td class="px-4 py-2">{{ $student->user->email }}</td>
                    <td class="px-4 py-2">{{ $student->user->document }}</td>
                    <td class="px-4 py-2">{{ $student->turma }}</td>
                    <td class="px-4 py-2">{{ $student->ano_letivo }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('students.edit', $student) }}" class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded shadow text-xs font-semibold transition">Editar</a>
                        <!-- Botão para abrir modal de exclusão -->
                        <button @click="openModal = true; selectedId = {{ $student->id }}" type="button" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded shadow text-xs font-semibold transition">Excluir</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal de confirmação de exclusão (apenas visual, não exclui de fato) -->
    <div x-data="{ openModal: false, selectedId: null }">
        <template x-if="openModal">
            <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
                <div class="bg-white rounded-lg shadow-lg p-8 max-w-sm w-full text-center">
                    <h2 class="text-xl font-bold mb-4 text-red-600">Confirmar Exclusão</h2>
                    <p class="mb-6 text-gray-700">Deseja realmente excluir este aluno? (Ação apenas visual)</p>
                    <div class="flex justify-center gap-4">
                        <button @click="openModal = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded font-semibold">Cancelar</button>
                        <button @click="openModal = false" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded font-semibold">Sim, apenas fechar</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
@endsection
