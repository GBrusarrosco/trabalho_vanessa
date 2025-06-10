<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Gerenciamento de Formulários
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ formIdToDelete: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php $user = Auth::user(); @endphp

            @if($user && in_array($user->role, ['admin', 'coordenador', 'professor']))
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-headline mb-4 sm:mb-0">
                        Formulários Cadastrados
                    </h1>
                    @if(Auth::user()->role !== 'coordenador')
                        <a href="{{ route('forms.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-lg font-semibold text-sm text-button-text uppercase tracking-widest hover:bg-opacity-90 active:bg-primary focus:outline-none focus:border-primary-dark focus:ring ring-primary-light disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Novo Formulário
                        </a>
                    @endif
                </div>

                @if (session('success'))
                    <div class="mb-6 p-4 rounded-md bg-green-100 border border-green-200 text-sm text-green-800 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- ESTRUTURA FINAL DA TABELA, COM TODAS AS MELHORIAS --}}
                <div class="bg-background shadow-xl sm:rounded-lg overflow-x-auto border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Formulário
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Turma
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ano Letivo
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Criado por
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Perguntas
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($forms as $form)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-primary hover:underline">
                                        <a href="{{ route('forms.edit', $form) }}">
                                            {{ $form->title }}
                                        </a>
                                    </div>
                                    @if($form->description)
                                        <div class="text-xs text-gray-500 mt-1 max-w-xs truncate" title="{{ $form->description }}">{{ $form->description }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($form->status === 'aprovado')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aprovado</span>
                                    @elseif ($form->status === 'reprovado')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-danger">Reprovado</span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendente</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $form->turma ?: 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $form->ano_letivo ?: 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $form->creator->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-headline">
                                    {{ $form->questions_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        @if ($form->status === 'pendente' && (Auth::user()->role === 'coordenador' || Auth::user()->role === 'admin'))
                                            <form action="{{ route('forms.approve', $form) }}" method="POST" class="contents">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-green-500 text-white text-xs font-semibold rounded-lg hover:bg-green-600 transition-colors duration-150 shadow-sm" title="Aprovar Formulário">
                                                    Aprovar
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('forms.edit', $form) }}" class="inline-flex items-center justify-center px-4 py-2 bg-secondary text-primary text-xs font-semibold rounded-lg hover:bg-opacity-80 transition-colors duration-150 shadow-sm" title="Editar Formulário">
                                            Editar
                                        </a>

                                        <form id="deleteForm-{{ $form->id }}" action="{{ route('forms.destroy', $form) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" @click.prevent="formIdToDelete = 'deleteForm-{{ $form->id }}'; $dispatch('open-modal', 'confirm-form-deletion')" class="inline-flex items-center justify-center px-4 py-2 bg-danger/90 text-button-text text-xs font-semibold rounded-lg hover:bg-danger transition-colors duration-150 shadow-sm" title="Excluir Formulário">
                                            Excluir
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2z"></path></svg>
                                        <p class="font-semibold">Nenhum formulário encontrado.</p>
                                        <p class="text-sm">Crie um novo formulário para começar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Modal de Confirmação de Exclusão --}}
        <x-modal name="confirm-form-deletion" focusable>
            <div class="p-6">
                <h2 class="text-lg font-medium text-headline">
                    Tem certeza que deseja excluir este formulário?
                </h2>
                <p class="mt-1 text-sm text-paragraph">
                    Uma vez que o formulário for excluído, todos os seus dados e perguntas relacionadas serão permanentemente removidos. Esta ação não pode ser desfeita.
                </p>
                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button @click.prevent="$dispatch('close')">
                        Cancelar
                    </x-secondary-button>
                    <x-danger-button @click.prevent="document.getElementById(formIdToDelete).submit(); $dispatch('close');">
                        Excluir Formulário
                    </x-danger-button>
                </div>
            </div>
        </x-modal>
    </div>
</x-app-layout>
