<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Editar Formulário: <span class="text-primary">{{ $form->title }}</span>
        </h2>
    </x-slot>

    {{-- Conteúdo principal da página --}}
    {{-- Adicionando x-data para o modal de exclusão de pergunta --}}
    <div class="py-12" x-data="{ questionIdToDeleteForModal: null }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Seção para editar Título e Descrição (Permanece igual) --}}
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('forms.update', $form) }}" method="POST" class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    <h3 class="text-lg font-semibold text-headline mb-6">Detalhes do Formulário</h3>
                    @include('forms.form')

                    <div class="mt-8 pt-6 border-t border-secondary">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('forms.index') }}"
                               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-paragraph bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Voltar à Listagem
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-button-text uppercase tracking-widest hover:bg-opacity-90 active:bg-primary focus:outline-none focus:border-primary focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                                Atualizar Detalhes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Seção para Gerenciar Perguntas do Formulário --}}
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-headline mb-4 sm:mb-0">Perguntas do Formulário</h3>
                    <a href="{{ route('questions.create', ['form_id' => $form->id]) }}"
                       class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 disabled:opacity-25 transition">
                        Adicionar Nova Pergunta
                    </a>
                </div>

                @if($form->questions && $form->questions->count() > 0)
                    <div class="border border-secondary rounded-md">
                        <ul class="divide-y divide-secondary">
                            @foreach($form->questions as $question)
                                <li class="p-4 flex flex-col sm:flex-row justify-between sm:items-center">
                                    <div class="mb-2 sm:mb-0">
                                        <p class="text-sm font-medium text-headline">{{ $question->question_text }}</p>
                                        <p class="text-xs text-paragraph">
                                            Tipo: {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                                            @if($question->type === 'multipla_escolha' && $question->options)
                                                <span class="text-xs text-gray-500 italic ml-2">({{ count($question->options) }} opções)</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0 flex items-center space-x-2">
                                        <a href="{{ route('questions.edit', $question->id) }}" class="text-sm text-indigo-600 hover:text-primary font-semibold hover:underline">Editar</a>

                                        {{-- Formulário de exclusão para esta pergunta, agora oculto --}}
                                        <form id="deleteInnerQuestionForm-{{ $question->id }}" action="{{ route('questions.destroy', $question->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        {{-- Botão que abre o modal de exclusão da pergunta --}}
                                        <button type="button"
                                                @click.prevent="questionIdToDeleteForModal = 'deleteInnerQuestionForm-{{ $question->id }}'; $dispatch('open-modal', 'confirm-inner-question-deletion')"
                                                class="text-sm text-danger hover:text-red-700 font-semibold hover:underline">
                                            Excluir
                                        </button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="text-paragraph text-sm text-center py-4">Nenhuma pergunta adicionada a este formulário ainda.</p>
                @endif
            </div>
        </div>

        {{-- Modal de Confirmação de Exclusão de Pergunta (dentro do div com x-data) --}}
        <x-modal name="confirm-inner-question-deletion" focusable>
            <div class="p-6">
                <h2 class="text-lg font-medium text-headline">
                    Confirmar Exclusão de Pergunta
                </h2>
                <p class="mt-2 text-sm text-paragraph">
                    Tem certeza de que deseja excluir esta pergunta? Esta ação não pode ser desfeita.
                </p>
                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button @click="$dispatch('close')">
                        Cancelar
                    </x-secondary-button>
                    <x-danger-button @click="if (questionIdToDeleteForModal) { document.getElementById(questionIdToDeleteForModal).submit(); } $dispatch('close')">
                        Sim, Excluir
                    </x-danger-button>
                </div>
            </div>
        </x-modal>

    </div> {{-- Fim do div principal com x-data --}}
</x-app-layout>
