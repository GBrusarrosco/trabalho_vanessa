<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Gerenciamento de Professores
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ teacherIdToDelete: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-headline mb-4 sm:mb-0">
                    Professores Cadastrados
                </h1>
                {{-- O botão de novo professor deve ser acessível apenas por quem pode gerenciar (Coordenador/Admin) --}}
                {{-- O Gate 'manage-teachers' na rota já protege a página de criação, então podemos mostrar o botão --}}
                <a href="{{ route('teachers.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-lg font-semibold text-sm text-button-text uppercase tracking-widest hover:bg-opacity-90 active:bg-primary focus:outline-none focus:border-primary-dark focus:ring ring-primary-light disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Novo Professor
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 rounded-md bg-green-100 border border-green-200 text-sm text-green-800 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-background shadow-xl sm:rounded-lg overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-background border-b-2 border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nome
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Área
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Observações
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @forelse ($teachers as $teacher)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-headline">{{ $teacher->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $teacher->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-paragraph">
                                {{ $teacher->area }}
                            </td>
                            <td class="px-6 py-4 text-sm text-paragraph">
                                {{ Str::limit($teacher->observacoes, 50) ?: '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                <a href="{{ route('teachers.edit', $teacher) }}"
                                   class="text-primary hover:text-indigo-900 font-semibold hover:underline" title="Editar Professor">Editar</a>

                                <form id="deleteTeacherForm-{{ $teacher->id }}" action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button"
                                        @click.prevent="teacherIdToDelete = 'deleteTeacherForm-{{ $teacher->id }}'; $dispatch('open-modal', 'confirm-teacher-deletion')"
                                        class="text-danger hover:text-red-700 font-semibold hover:underline focus:outline-none" title="Excluir Professor">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-paragraph text-center italic">
                                Nenhum professor cadastrado.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal de Confirmação de Exclusão --}}
        <x-modal name="confirm-teacher-deletion" focusable>
            <div class="p-6">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-danger" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-headline">
                        Confirmar Exclusão
                    </h3>
                    <p class="mt-2 text-sm text-paragraph">
                        Tem certeza de que deseja excluir este professor? Esta ação não pode ser desfeita.
                    </p>
                </div>
                <div class="mt-6 flex justify-center space-x-3">
                    <x-secondary-button @click="$dispatch('close')">
                        Cancelar
                    </x-secondary-button>
                    <x-danger-button @click="if (teacherIdToDelete) { document.getElementById(teacherIdToDelete).submit(); } $dispatch('close')">
                        Sim, Excluir
                    </x-danger-button>
                </div>
            </div>
        </x-modal>
    </div>
</x-app-layout>
