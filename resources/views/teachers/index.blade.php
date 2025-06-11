<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Gerenciamento de Professores
        </h2>
    </x-slot>
    <div class="py-12" x-data="{ teacherIdToDelete: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-headline mb-4 sm:mb-0">Professores Cadastrados</h1>
                <a href="{{ route('teachers.create') }}" class="inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-lg font-semibold text-sm text-button-text uppercase tracking-widest hover:bg-opacity-90 shadow-md"><svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/></svg>Novo Professor</a>
            </div>
            @if (session('success'))
                <div class="mb-6 p-4 rounded-md bg-green-100 border border-green-200 text-sm text-green-800 shadow-sm">{{ session('success') }}</div>
            @endif
            <div class="bg-background shadow-xl sm:rounded-lg p-6 space-y-4" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 50)">
                @forelse ($teachers as $teacher)
                    <div class="flex items-center justify-between p-4 rounded-lg border border-secondary hover:shadow-lg hover:border-primary transition-all duration-300 transform hover:scale-[1.01]"
                         :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }"
                         :style="'transition-delay: {{ $loop->index * 50 }}ms'">
                        <div class="flex-grow">
                            <p class="font-bold text-lg text-headline">{{ $teacher->user->name }}</p>
                            <p class="text-sm text-paragraph">{{ $teacher->user->email }}</p>
                            <p class="text-sm text-gray-600 mt-1">Área: {{ $teacher->area }}</p>
                        </div>
                        <div class="flex items-center space-x-1 flex-shrink-0 ml-4">
                            <a href="{{ route('teachers.edit', $teacher) }}" class="p-2 text-indigo-600 hover:bg-indigo-100 rounded-full" title="Editar"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" /></svg></a>
                            <button type="button" @click.prevent="teacherIdToDelete = 'deleteTeacherForm-{{ $teacher->id }}'; $dispatch('open-modal', 'confirm-teacher-deletion')" class="p-2 text-danger hover:bg-red-100 rounded-full" title="Excluir"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.58.22-2.365.468a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193v-.443A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" /></svg></button>
                            <form id="deleteTeacherForm-{{ $teacher->id }}" action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 text-paragraph"><svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg><h3 class="mt-2 text-sm font-semibold text-gray-900">Sem Professores</h3><p class="mt-1 text-sm text-gray-500">Nenhum professor cadastrado ainda.</p></div>
                @endforelse
            </div>
        </div>
        <x-modal name="confirm-teacher-deletion" focusable>
            <div class="p-6"><div class="text-center"><svg class="mx-auto h-12 w-12 text-danger" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg><h3 class="mt-2 text-lg font-medium text-headline">Confirmar Exclusão</h3><p class="mt-2 text-sm text-paragraph">Tem certeza de que deseja excluir este professor?</p></div><div class="mt-6 flex justify-center space-x-3"><x-secondary-button @click="$dispatch('close')">Cancelar</x-secondary-button><x-danger-button @click="if (teacherIdToDelete) { document.getElementById(teacherIdToDelete).submit(); } $dispatch('close')">Sim, Excluir</x-danger-button></div></div>
        </x-modal>
    </div>
</x-app-layout>
