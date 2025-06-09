<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Gerenciamento de Formulários
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ formIdToDelete: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php $user = Auth::user(); @endphp

            {{-- SEÇÃO PARA O ALUNO --}}
            @if($user && $user->role === 'aluno')
                <div class="bg-background shadow-xl sm:rounded-lg p-8">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-headline mb-4">Formulários Disponíveis</h2>
                        <p class="text-paragraph mb-8">Aqui você pode visualizar os formulários atribuídos a você e o status de cada um.</p>
                    </div>

                    <div class="overflow-x-auto rounded-lg shadow border border-secondary">
                        <table class="min-w-full bg-white">
                            {{-- CABEÇALHO DA TABELA DO ALUNO - CORRIGIDO --}}
                            <thead class="bg-background border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Descrição</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ação</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @php
                                $student = $user->student;
                                $assignedForms = $student ? $student->forms()->where('is_validated', true)->get() : collect();
                                $answeredFormIds = $student ? $student->answers()->join('questions', 'answers.question_id', '=', 'questions.id')->select('questions.form_id')->distinct()->pluck('form_id')->toArray() : [];
                            @endphp
                            @forelse($assignedForms as $form)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 font-semibold text-headline whitespace-nowrap">{{ $form->title }}</td>
                                    <td class="px-6 py-4 text-paragraph whitespace-nowrap">{{ Str::limit($form->description, 60) ?: '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if(in_array($form->id, $answeredFormIds))
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Respondido</span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendente</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if(!in_array($form->id, $answeredFormIds))
                                            <a href="{{ route('forms.responder', $form->id) }}" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-button-text uppercase tracking-widest hover:bg-opacity-90 transition">Responder</a>
                                        @else
                                            <span class="text-gray-400 italic">Já respondido</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-paragraph italic">Nenhum formulário atribuído a você no momento.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- SEÇÃO PARA PROFESSOR / COORDENADOR / ADMIN --}}
            @else
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
                    <div class="mb-6 p-4 rounded-md bg-green-100 border border-green-200 text-sm text-green-800 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-background shadow-xl sm:rounded-lg overflow-x-auto">
                    <table class="min-w-full">
                        {{-- CABEÇALHO DA TABELA - CORRIGIDO --}}
                        <thead class="bg-background border-b-2 border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Título
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Descrição
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Validação
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @forelse ($forms as $form)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-headline">{{ $form->title }}</div>
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
            @endif
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
