@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-2xl text-headline leading-tight">
        Editar Pergunta
        @if($question->form)
            <span class="text-base font-normal text-paragraph block sm:inline sm:ml-2">
                (Formulário: {{ $question->form->title }})
            </span>
        @endif
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg">
                {{-- Alpine.js para gerenciar opções dinâmicas --}}
                <form method="POST" action="{{ route('questions.update', $question->id) }}"
                      class="p-6 sm:p-8 space-y-6"
                      x-data="{
                          questionType: '{{ old('type', $question->type) }}',
                          options: {{ json_encode(old('options', $question->options ?? [''])) }}
                      }"
                      x-init="if (options.length === 0) options = ['']">
                    @csrf
                    @method('PUT')

                    {{-- Campo Formulário --}}
                    <div>
                        <label for="form_id" class="block text-sm font-semibold text-headline mb-1">Formulário Associado</label>
                        <select name="form_id" id="form_id"
                                class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-paragraph bg-white @error('form_id') border-danger @enderror"
                                required>
                            @foreach($forms as $form)
                                <option value="{{ $form->id }}"
                                    {{ (old('form_id', $question->form_id) == $form->id) ? 'selected' : '' }}>
                                    {{ $form->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('form_id')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo Texto da Pergunta --}}
                    <div>
                        <label for="question_text" class="block text-sm font-semibold text-headline mb-1">Texto da Pergunta</label>
                        <textarea name="question_text" id="question_text" rows="4"
                                  class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 placeholder-gray-400 text-paragraph bg-background @error('question_text') border-danger @enderror"
                                  required placeholder="Digite o texto da pergunta aqui...">{{ old('question_text', $question->question_text) }}</textarea>
                        @error('question_text')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo Tipo da Pergunta --}}
                    <div>
                        <label for="type" class="block text-sm font-semibold text-headline mb-1">Tipo da Pergunta</label>
                        <select name="type" id="type" x-model="questionType"
                                class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-paragraph bg-white @error('type') border-danger @enderror"
                                required>
                            <option value="texto">Texto</option>
                            <option value="multipla_escolha">Múltipla Escolha</option>
                        </select>
                        @error('type')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Seção de Opções (Condicional) --}}
                    <div x-show="questionType === 'multipla_escolha'" class="space-y-3">
                        <label class="block text-sm font-semibold text-headline mb-1">Opções de Resposta</label>
                        <template x-for="(option, index) in options" :key="index">
                            <div class="flex items-center space-x-2">
                                <input type="text" :name="`options[${index}]`" x-model="options[index]"
                                       class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 placeholder-gray-400 text-paragraph bg-background"
                                       placeholder="Texto da opção">
                                <button type="button" @click="options.splice(index, 1)" x-show="options.length > 1"
                                        class="px-3 py-2 bg-danger text-button-text rounded-md hover:bg-opacity-90 text-sm">
                                    Remover
                                </button>
                            </div>
                        </template>
                        @error('options') {{-- Erro geral para o array de opções --}}
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('options.*') {{-- Erros individuais para cada opção --}}
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <button type="button" @click="options.push('')"
                                class="mt-2 px-3 py-2 bg-secondary text-primary rounded-md hover:bg-opacity-80 text-sm font-medium">
                            Adicionar Opção
                        </button>
                    </div>


                    {{-- Botões de Ação --}}
                    <div class="mt-8 pt-5 border-t border-secondary">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('forms.edit', $question->form_id) }}" {{-- Voltar para edição do formulário --}}
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-paragraph bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Voltar ao Formulário
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-button-text uppercase tracking-widest hover:bg-opacity-90 active:bg-primary focus:outline-none focus:border-primary focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                                Atualizar Pergunta
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
