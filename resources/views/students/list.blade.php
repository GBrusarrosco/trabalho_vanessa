<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Alunos da Turma: <span class="text-primary">{{ $turma }} ({{ $ano_letivo }})</span>
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ studentIdToDelete: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <a href="{{ route('students.index') }}" class="inline-flex items-center text-sm font-medium text-primary hover:underline">
                    &larr; Voltar para todas as turmas
                </a>
                <a href="{{ route('students.create', ['turma' => $turma, 'ano_letivo' => $ano_letivo]) }}" class="inline-flex items-center px-4 py-2 bg-primary text-button-text text-xs font-semibold uppercase rounded-md hover:bg-opacity-90 transition">
                    Adicionar Aluno a esta Turma
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 rounded-md bg-green-100 border border-green-200 text-sm text-green-800 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-background shadow-xl sm:rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documento</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($students as $student)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->user->document }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                <a href="{{ route('students.edit', $student) }}" class="text-primary hover:underline">Editar</a>

                                <form id="deleteStudentForm-{{ $student->id }}" action="{{ route('students.destroy', $student) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button"
                                        @click.prevent="studentIdToDelete = 'deleteStudentForm-{{ $student->id }}'; $dispatch('open-modal', 'confirm-student-deletion')"
                                        class="text-danger hover:underline">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 text-gray-500">
                                Nenhum aluno encontrado nesta turma.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal de Confirmação de Exclusão --}}
        <x-modal name="confirm-student-deletion" focusable>
            <form method="post" @submit.prevent="document.getElementById(studentIdToDelete).submit()" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-headline">
                    Tem certeza que deseja excluir este aluno?
                </h2>

                <p class="mt-1 text-sm text-paragraph">
                    Esta ação não pode ser desfeita. Todos os dados do aluno, incluindo suas respostas, serão permanentemente removidos.
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancelar') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Excluir Aluno') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>
