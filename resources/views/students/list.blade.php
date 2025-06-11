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
                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" /></svg>
                    Voltar para todas as turmas
                </a>
                <a href="{{ route('students.create', ['turma' => $turma, 'ano_letivo' => $ano_letivo]) }}" class="inline-flex items-center px-4 py-2 bg-primary text-button-text text-xs font-semibold uppercase rounded-md hover:bg-opacity-90 transition">
                    Adicionar Aluno a esta Turma
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 rounded-md bg-green-100 border border-green-200 text-sm text-green-800 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-background shadow-xl sm:rounded-lg p-6 space-y-4" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 50)">
                @forelse ($students as $student)
                    <div class="flex items-center justify-between p-4 rounded-lg border border-secondary hover:shadow-lg hover:border-primary transition-all duration-300 transform hover:scale-[1.01]"
                         :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }"
                         :style="'transition-delay: {{ $loop->index * 50 }}ms'">

                        <div class="flex-grow">
                            <p class="font-bold text-lg text-headline">{{ $student->user->name }}</p>
                            <p class="text-sm text-paragraph">{{ $student->user->email }}</p>
                            <p class="text-sm text-gray-600 mt-1">Documento: {{ $student->user->document }}</p>
                        </div>

                        <div class="flex items-center space-x-1 flex-shrink-0 ml-4">
                            <a href="{{ route('students.edit', $student) }}" class="p-2 text-indigo-600 hover:bg-indigo-100 rounded-full" title="Editar Aluno"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" /></svg></a>
                            <button type="button" @click.prevent="studentIdToDelete = 'deleteForm-{{ $student->id }}'; $dispatch('open-modal', 'confirm-student-deletion')" class="p-2 text-danger hover:bg-red-100 rounded-full" title="Excluir Aluno"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.58.22-2.365.468a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193v-.443A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" /></svg></button>
                            <form id="deleteForm-{{ $student->id }}" action="{{ route('students.destroy', $student) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 text-paragraph"><svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.952a4.5 4.5 0 011.13-1.13A4.5 4.5 0 0112 10.5c1.13 0 2.17.386 3 1.03a4.5 4.5 0 01-4.13 2.875M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><h3 class="mt-2 text-sm font-semibold text-gray-900">Sem Alunos</h3><p class="mt-1 text-sm text-gray-500">Nenhum aluno encontrado nesta turma.</p></div>
                @endforelse
            </div>
        </div>
        <x-modal name="confirm-student-deletion" focusable>
            <form method="post" @submit.prevent="if (studentIdToDelete) document.getElementById(studentIdToDelete).submit()" class="p-6"><h2 class="text-lg font-medium text-headline">Tem certeza que deseja excluir este aluno?</h2><p class="mt-1 text-sm text-paragraph">Todos os dados do aluno, incluindo suas respostas, serão permanentemente removidos. Esta ação não pode ser desfeita.</p><div class="mt-6 flex justify-end"><x-secondary-button x-on:click="$dispatch('close')">Cancelar</x-secondary-button><x-danger-button class="ms-3">Sim, Excluir</x-danger-button></div></form>
        </x-modal>
    </div>
</x-app-layout>
