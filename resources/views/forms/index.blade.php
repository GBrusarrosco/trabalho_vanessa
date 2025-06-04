@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-2xl text-headline leading-tight">
        Formulários de Avaliação
    </h2>
@endsection

@section('content')
    {{-- Envolvemos a seção com x-data para o modal --}}
    <div class="py-12" x-data="{ showConfirmModal: false, formIdToDelete: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-headline mb-4 sm:mb-0">
                    Formulários Cadastrados
                </h1>
                <a href="{{ route('forms.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-button-text uppercase tracking-widest hover:bg-opacity-90 active:bg-primary focus:outline-none focus:border-primary focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                    Novo Formulário
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 rounded-md bg-green-50 border border-green-300 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-background shadow-xl sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-secondary">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-paragraph uppercase tracking-wider">
                            Título
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-paragraph uppercase tracking-wider">
                            Descrição
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-paragraph uppercase tracking-wider">
                            Validação
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-paragraph uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-background divide-y divide-secondary">
                    @forelse ($forms as $form)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-headline">
                                {{ $form->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-paragraph">
                                {{ Str::limit($form->description, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($form->is_validated)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Validado
                                        </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pendente
                                        </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('forms.edit', $form) }}"
                                   class="text-indigo-600 hover:text-primary font-semibold hover:underline">Editar</a>

                                @if (!$form->is_validated && (Auth::user()->role === 'coordenador' || Auth::user()->role === 'admin'))
                                    <form action="{{ route('forms.validate', $form) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                                class="text-green-600 hover:text-green-800 font-semibold hover:underline">Validar</button>
                                    </form>
                                @endif

                                {{-- Formulário de exclusão, agora oculto e acionado pelo modal --}}
                                <form id="deleteForm-{{ $form->id }}" action="{{ route('forms.destroy', $form) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                {{-- Botão que abre o modal --}}
                                <button type="button"
                                        @click.prevent="formIdToDelete = 'deleteForm-{{ $form->id }}'; $dispatch('open-modal', 'confirm-form-deletion')"
                                        class="text-danger hover:text-red-700 font-semibold hover:underline">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-paragraph text-center">
                                Nenhum formulário encontrado.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal de Confirmação de Exclusão --}}
        <x-modal name="confirm-form-deletion" focusable>
            <div class="p-6">
                <h2 class="text-lg font-medium text-headline">
                    Confirmar Exclusão
                </h2>
                <p class="mt-2 text-sm text-paragraph">
                    Tem certeza de que deseja excluir este formulário? Esta ação não pode ser desfeita e removerá também todas as perguntas e respostas associadas.
                </p>
                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button @click="$dispatch('close')">
                        Cancelar
                    </x-secondary-button>
                    <x-danger-button @click="if (formIdToDelete) { document.getElementById(formIdToDelete).submit(); } $dispatch('close')">
                        Sim, Excluir
                    </x-danger-button>
                </div>
            </div>
        </x-modal>
    </div>
@endsection
