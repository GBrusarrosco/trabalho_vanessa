<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Editando Formulário: <span class="text-primary">{{ $form->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ questionIdToDelete: null }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 rounded-md bg-green-100 border border-green-200 text-sm text-green-800 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('forms.update', $form) }}" method="POST" class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    @include('forms.form', ['form' => $form, 'turmas' => $turmas])

                    <div class="mt-8 pt-6 border-t border-secondary flex justify-end items-center space-x-3">
                        <a href="{{ route('forms.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            Cancelar
                        </a>
                        <x-primary-button>
                            Atualizar Cabeçalho
                        </x-primary-button>
                    </div>
                </form>
            </div>

            @if(Auth::user()->role === 'coordenador' && $form->status === 'pendente')
                <div class="bg-yellow-50 border border-yellow-200 overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-4">Ações do Coordenador</h3>
                    <div class="flex items-center justify-end space-x-3">
                        <x-danger-button type="button" @click.prevent="$dispatch('open-modal', 'confirm-form-rejection')">
                            Reprovar e Enviar para Revisão
                        </x-danger-button>

                        {{-- ===== INÍCIO DA ALTERAÇÃO ===== --}}
                        <form action="{{ route('forms.approve', $form) }}" method="POST" class="contents">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-xs font-semibold rounded-lg hover:bg-green-600 shadow-sm">
                                Aprovar Formulário
                            </button>
                        </form>
                        {{-- ===== FIM DA ALTERAÇÃO ===== --}}
                    </div>
                </div>
            @endif

            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-headline">Perguntas do Formulário</h3>
                    <a href="{{ route('questions.create', ['form_id' => $form->id]) }}"
                       class="inline-flex items-center px-4 py-2 bg-primary text-button-text text-xs font-semibold uppercase rounded-md hover:bg-opacity-90 transition">
                        <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" /></svg>
                        Adicionar Pergunta
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($form->questions as $question)
                        <div class="flex items-center justify-between p-4 rounded-md border border-secondary bg-gray-50">
                            <div class="flex-grow">
                                <p class="font-medium text-headline">{{ $question->question_text }}</p>
                                <p class="text-xs text-paragraph">Tipo: {{ ucfirst(str_replace('_', ' ', $question->type)) }}</p>
                            </div>
                            <div class="flex items-center space-x-3 flex-shrink-0 ml-4">
                                <a href="{{ route('questions.edit', $question->id) }}" class="text-primary hover:underline text-sm font-medium">Editar</a>
                                <button type="button" @click.prevent="questionIdToDelete = 'deleteQuestionForm-{{ $question->id }}'; $dispatch('open-modal', 'confirm-question-deletion')" class="text-danger hover:underline text-sm font-medium">Excluir</button>
                                <form id="deleteQuestionForm-{{ $question->id }}" action="{{ route('questions.destroy', $question->id) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-paragraph py-8">Nenhuma pergunta adicionada a este formulário ainda.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <x-modal name="confirm-form-rejection" focusable>
            <form action="{{ route('forms.reject', $form) }}" method="POST" class="p-6">
                @csrf
                <h2 class="text-lg font-medium text-headline">Reprovar Formulário</h2>
                <p class="mt-1 text-sm text-paragraph">
                    Por favor, descreva o motivo da reprovação para que o professor possa fazer os ajustes necessários.
                </p>
                <div class="mt-6">
                    <x-input-label for="rejection_reason" value="Motivo da Reprovação" class="sr-only" />
                    <textarea id="rejection_reason" name="rejection_reason" rows="4" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm text-paragraph bg-background focus:border-primary focus:ring-primary" required minlength="10" placeholder="Ex: A pergunta 3 precisa ser mais clara, etc."></textarea>
                    <x-input-error :messages="$errors->get('rejection_reason')" class="mt-2" />
                </div>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button type="button" @click="$dispatch('close')">Cancelar</x-secondary-button>
                    <x-danger-button class="ms-3">Confirmar Reprovação</x-danger-button>
                </div>
            </form>
        </x-modal>

        <x-modal name="confirm-question-deletion" focusable>
            <form method="post" @submit.prevent="if (questionIdToDelete) document.getElementById(questionIdToDelete).submit()">
                @csrf
                @method('delete')
                <h2 class="text-lg font-medium text-headline">Confirmar Exclusão</h2>
                <p class="mt-2 text-sm text-paragraph">Tem certeza de que deseja excluir esta pergunta?</p>
                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button @click="$dispatch('close')">Cancelar</x-secondary-button>
                    <x-danger-button type="submit">Sim, Excluir</x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>
