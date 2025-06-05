<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Gerenciamento de Perguntas
        </h2>
    </x-slot>

    {{-- Conteúdo principal da página, que será injetado no $slot do layouts.app.blade.php --}}
    <div class="py-12" x-data="{ questionIdToDelete: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-headline mb-4 sm:mb-0">
                    Perguntas Cadastradas
                </h1>
                <a href="{{ route('questions.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-button-text uppercase tracking-widest hover:bg-opacity-90 active:bg-primary focus:outline-none focus:border-primary focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                    Nova Pergunta
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 rounded-md bg-green-50 border border-green-300 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-background shadow-xl sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-secondary">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-paragraph uppercase tracking-wider">
                            Formulário Associado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-paragraph uppercase tracking-wider">
                            Texto da Pergunta
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-paragraph uppercase tracking-wider">
                            Tipo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-paragraph uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-background divide-y divide-secondary">
                    @forelse($questions as $question)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-paragraph">
                                {{ $question->form->title ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-headline font-medium">
                                {{ Str::limit($question->question_text, 70) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-paragraph">
                                {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('questions.edit', $question->id) }}"
                                   class="text-indigo-600 hover:text-primary font-semibold hover:underline">Editar</a>

                                <form id="deleteQuestionForm-{{ $question->id }}" action="{{ route('questions.destroy', $question->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button"
                                        @click.prevent="questionIdToDelete = 'deleteQuestionForm-{{ $question->id }}'; $dispatch('open-modal', 'confirm-question-deletion')"
                                        class="text-danger hover:text-red-700 font-semibold hover:underline">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-paragraph text-center">
                                Nenhuma pergunta encontrada.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- Modal de Confirmação de Exclusão de Pergunta --}}
        <x-modal name="confirm-question-deletion" focusable>
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
                    <x-danger-button @click="if (questionIdToDelete) { document.getElementById(questionIdToDelete).submit(); } $dispatch('close')">
                        Sim, Excluir
                    </x-danger-button>
                </div>
            </div>
        </x-modal>
    </div> {{-- Fim do div principal do conteúdo da página --}}
</x-app-layout>
