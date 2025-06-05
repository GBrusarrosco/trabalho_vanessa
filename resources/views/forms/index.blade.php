<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Gerenciamento de Formulários
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ formIdToDelete: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-headline mb-4 sm:mb-0">
                    Formulários Cadastrados
                </h1>
                <a href="{{ route('forms.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-lg font-semibold text-sm text-button-text uppercase tracking-widest hover:bg-opacity-90 active:bg-primary focus:outline-none focus:border-primary-dark focus:ring ring-primary-light disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Novo Formulário
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 rounded-md bg-green-50 border border-green-300 text-sm text-green-700 shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-background shadow-xl sm:rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-paragraph uppercase tracking-wider">
                            Título
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-paragraph uppercase tracking-wider">
                            Descrição
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-paragraph uppercase tracking-wider">
                            Validação
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-paragraph uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-background divide-y divide-secondary">
                    @forelse ($forms as $form)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-headline">{{ $form->title }}</div>
                                <div class="text-xs text-gray-500">ID: {{ $form->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-paragraph">
                                {{ Str::limit($form->description, 60) ?: '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($form->is_validated)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Validado
                                        </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pendente
                                        </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                @if (!$form->is_validated && (Auth::user()->role === 'coordenador' || Auth::user()->role === 'admin'))
                                    <form action="{{ route('forms.validate', $form) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                                class="text-green-600 hover:text-green-700 font-semibold hover:underline focus:outline-none" title="Validar Formulário">
                                            Validar
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('forms.edit', $form) }}"
                                   class="text-primary hover:text-indigo-900 font-semibold hover:underline" title="Editar Formulário">Editar</a>

                                <form id="deleteForm-{{ $form->id }}" action="{{ route('forms.destroy', $form) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button"
                                        @click.prevent="formIdToDelete = 'deleteForm-{{ $form->id }}'; $dispatch('open-modal', 'confirm-form-deletion')"
                                        class="text-danger hover:text-red-700 font-semibold hover:underline focus:outline-none" title="Excluir Formulário">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-paragraph text-center italic">
                                Nenhum formulário cadastrado ainda.
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
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-danger" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-headline">
                        Confirmar Exclusão
                    </h3>
                    <p class="mt-2 text-sm text-paragraph">
                        Tem certeza de que deseja excluir este formulário? Esta ação não pode ser desfeita e removerá também todas as perguntas e respostas associadas.
                    </p>
                </div>
                <div class="mt-6 flex justify-center space-x-3">
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
</x-app-layout>
