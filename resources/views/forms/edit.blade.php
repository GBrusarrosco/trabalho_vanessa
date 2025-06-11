<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Editando Formulário: <span class="text-primary">{{ $form->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ questionIdToDelete: null }">
        {{-- ===== LARGURA MÁXIMA AUMENTADA DE 4xl PARA 7xl ===== --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 rounded-md bg-green-100 border border-green-200 text-sm text-green-800 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 border-b border-secondary">
                    <h3 class="text-lg font-semibold text-headline">Detalhes do Formulário</h3>
                </div>
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
                <div class="bg-yellow-50 border border-yellow-300 overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-800">Ações do Coordenador</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Revise o formulário e suas perguntas. Ao **aprovar**, ele ficará disponível para as turmas. Se **reprovar**, ele voltará para o professor com suas observações.
                            </p>
                        </div>
                        <div class="flex items-center justify-center md:justify-end space-x-3">
                            <x-danger-button type="button" @click.prevent="$dispatch('open-modal', 'confirm-form-rejection')">
                                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" /></svg>
                                Reprovar
                            </x-danger-button>
                            <form action="{{ route('forms.approve', $form) }}" method="POST" class="contents">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 shadow-md transition-colors">
                                    <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                                    Aprovar Formulário
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-headline">Perguntas do Formulário</h3>
                    <a href="{{ route('questions.create', ['form_id' => $form->id]) }}" class="inline-flex items-center px-4 py-2 bg-primary text-button-text text-xs font-semibold uppercase rounded-md hover:bg-opacity-90 transition">
                        <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" /></svg>
                        Adicionar Pergunta
                    </a>
                </div>
                <div class="space-y-4" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 50)">
                    @forelse($form->questions as $question)
                        <div class="flex items-center justify-between p-4 rounded-lg border border-secondary hover:shadow-lg hover:border-primary transition-all duration-300 transform hover:scale-[1.01]"
                             :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }"
                             :style="'transition-delay: {{ $loop->index * 50 }}ms'">
                            <div class="flex-grow">
                                <p class="font-medium text-headline">{{ $question->question_text }}</p>
                                <p class="text-xs text-paragraph">Tipo: {{ ucfirst(str_replace('_', ' ', $question->type)) }}</p>
                            </div>
                            <div class="flex items-center space-x-1 flex-shrink-0 ml-4">
                                <a href="{{ route('questions.edit', $question->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-100 rounded-full" title="Editar Pergunta"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" /></svg></a>
                                <button type="button" @click.prevent="questionIdToDelete = 'deleteQuestionForm-{{ $question->id }}'; $dispatch('open-modal', 'confirm-question-deletion')" class="p-2 text-danger hover:bg-red-100 rounded-full" title="Excluir Pergunta"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.58.22-2.365.468a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193v-.443A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" /></svg></button>
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
            <form action="{{ route('forms.reject', $form) }}" method="POST" class="p-6">@csrf<h2 class="text-lg font-medium text-headline">Reprovar Formulário</h2><p class="mt-1 text-sm text-paragraph">Por favor, descreva o motivo da reprovação.</p><div class="mt-6"><x-input-label for="rejection_reason" value="Motivo" class="sr-only" /><textarea id="rejection_reason" name="rejection_reason" rows="4" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required minlength="10" placeholder="Ex: A pergunta 3 precisa ser mais clara..."></textarea><x-input-error :messages="$errors->get('rejection_reason')" class="mt-2" /></div><div class="mt-6 flex justify-end"><x-secondary-button type="button" @click="$dispatch('close')">Cancelar</x-secondary-button><x-danger-button class="ms-3">Confirmar Reprovação</x-danger-button></div></form>
        </x-modal>

        <x-modal name="confirm-question-deletion" focusable>
            <form method="post" @submit.prevent="if (questionIdToDelete) document.getElementById(questionIdToDelete).submit()">@csrf @method('delete')<h2 class="text-lg font-medium text-headline">Confirmar Exclusão</h2><p class="mt-2 text-sm text-paragraph">Tem certeza de que deseja excluir esta pergunta?</p><div class="mt-6 flex justify-end space-x-3"><x-secondary-button @click="$dispatch('close')">Cancelar</x-secondary-button><x-danger-button type="submit">Sim, Excluir</x-danger-button></div></form>
        </x-modal>
    </div>
</x-app-layout>
