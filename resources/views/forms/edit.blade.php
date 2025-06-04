@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-2xl text-headline leading-tight">
        Editar Formulário: <span class="text-primary">{{ $form->title }}</span>
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8"> {{-- Aumentei um pouco a largura e adicionei space-y --}}

            {{-- Seção para editar Título e Descrição --}}
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('forms.update', $form) }}" method="POST" class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    <h3 class="text-lg font-semibold text-headline mb-4">Detalhes do Formulário</h3>
                    @include('forms.form') {{-- Parcial com os campos Título e Descrição --}}

                    <div class="mt-8 pt-5 border-t border-secondary">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('forms.index') }}"
                               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-paragraph bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Voltar
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-button-text uppercase tracking-widest hover:bg-opacity-90 active:bg-primary focus:outline-none focus:border-primary focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                                Atualizar Detalhes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Nova Seção para Gerenciar Perguntas --}}
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-headline">Perguntas do Formulário</h3>
                    {{-- Botão para adicionar nova pergunta a ESTE formulário --}}
                    <a href="{{ route('questions.create', ['form_id' => $form->id]) }}"
                       class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 disabled:opacity-25 transition">
                        Adicionar Pergunta
                    </a>
                </div>

                @if($form->questions && $form->questions->count() > 0)
                    <ul class="divide-y divide-secondary">
                        @foreach($form->questions as $question)
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-headline">{{ $question->question_text }}</p>
                                    <p class="text-xs text-paragraph">{{ ucfirst(str_replace('_', ' ', $question->type)) }}</p>
                                </div>
                                <div class="space-x-2">
                                    <a href="{{ route('questions.edit', $question->id) }}" class="text-sm text-indigo-600 hover:text-primary font-semibold hover:underline">Editar</a>
                                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir esta pergunta?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-danger hover:text-red-700 font-semibold hover:underline">Excluir</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-paragraph text-sm">Nenhuma pergunta adicionada a este formulário ainda.</p>
                @endif
            </div>

        </div>
    </div>
@endsection
