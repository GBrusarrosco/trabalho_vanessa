<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Gerenciamento de Perguntas
        </h2>
    </x-slot>
    <div class="py-12" x-data="{ questionIdToDelete: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-headline mb-4 sm:mb-0">Perguntas Cadastradas</h1>
                @can('create-question')
                    <a href="{{ route('questions.create') }}" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-button-text uppercase tracking-widest hover:bg-opacity-90">Nova Pergunta</a>
                @endcan
            </div>
            @if(session('success'))
                <div class="mb-4 p-4 rounded-md bg-green-50 border border-green-300 text-sm text-green-700">{{ session('success') }}</div>
            @endif
            <div class="bg-background shadow-xl sm:rounded-lg p-6 space-y-4" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 50)">
                @forelse($questions as $question)
                    <div class="flex items-center justify-between p-4 rounded-lg border border-secondary hover:shadow-lg hover:border-primary transition-all duration-300 transform hover:scale-[1.01]"
                         :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }"
                         :style="'transition-delay: {{ $loop->index * 50 }}ms'">
                        <div class="flex-grow">
                            <p class="font-semibold text-lg text-headline">{{ $question->question_text }}</p>
                            <p class="text-sm text-gray-600 mt-1">Formulário: {{ $question->form->title ?? 'N/A' }} | Tipo: {{ ucfirst(str_replace('_', ' ', $question->type)) }}</p>
                        </div>
                        @if(in_array(Auth::user()->role, ['admin', 'professor']))
                            <div class="flex items-center space-x-1 flex-shrink-0 ml-4">
                                <a href="{{ route('questions.edit', $question->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-100 rounded-full" title="Editar"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" /></svg></a>
                                <button type="button" @click.prevent="questionIdToDelete = 'deleteQuestionForm-{{ $question->id }}'; $dispatch('open-modal', 'confirm-question-deletion')" class="p-2 text-danger hover:bg-red-100 rounded-full" title="Excluir"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.58.22-2.365.468a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193v-.443A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" /></svg></button>
                                <form id="deleteQuestionForm-{{ $question->id }}" action="{{ route('questions.destroy', $question->id) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-16 text-paragraph">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Sem Perguntas</h3>
                        <p class="mt-1 text-sm text-gray-500">Nenhuma pergunta cadastrada ainda.</p>
                    </div>
                @endforelse
            </div>
        </div>
        <x-modal name="confirm-question-deletion" focusable>
            <div class="p-6">
                <h2 class="text-lg font-medium text-headline">Confirmar Exclusão de Pergunta</h2>
                <p class="mt-2 text-sm text-paragraph">Tem certeza de que deseja excluir esta pergunta? Esta ação não pode ser desfeita.</p>
                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button @click="$dispatch('close')">Cancelar</x-secondary-button>
                    <x-danger-button @click="if (questionIdToDelete) { document.getElementById(questionIdToDelete).submit(); } $dispatch('close')">Sim, Excluir</x-danger-button>
                </div>
            </div>
        </x-modal>
    </div>
</x-app-layout>
