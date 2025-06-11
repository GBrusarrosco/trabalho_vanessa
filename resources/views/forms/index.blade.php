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

                <div class="space-y-4" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 50)">
                    @forelse ($forms as $form)
                        @php
                            $cardClasses = match($form->status) {
                                'reprovado' => 'bg-red-50 border-danger/30',
                                'pendente' => 'bg-yellow-50 border-yellow-400/50',
                                default => 'bg-background border-secondary',
                            };
                            $titleClasses = match($form->status) {
                                'reprovado' => 'text-danger',
                                'pendente' => 'text-yellow-600',
                                default => 'text-primary',
                            };
                        @endphp
                        <div class="bg-background shadow-lg rounded-lg p-5 border-l-4 {{ $cardClasses }} transition-all duration-300 transform hover:shadow-xl hover:scale-[1.01]"
                             :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }"
                             :style="'transition-delay: {{ $loop->index * 50 }}ms'">

                            <div class="flex flex-col sm:flex-row justify-between">
                                <div class="flex-grow">
                                    <div class="flex items-center gap-x-4 mb-2">
                                        {{-- FONTES AUMENTADAS --}}
                                        <h3 class="text-lg font-bold {{ $titleClasses }}">
                                            <a href="{{ route('forms.edit', $form) }}" class="hover:underline">{{ $form->title }}</a>
                                        </h3>
                                        @if ($form->status === 'aprovado')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aprovado</span>
                                        @elseif ($form->status === 'reprovado')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-danger">Reprovado</span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendente</span>
                                        @endif
                                    </div>
                                    {{-- FONTES AUMENTADAS --}}
                                    <div class="text-sm text-paragraph flex flex-wrap items-center gap-x-4 gap-y-1">
                                        <span>Turma: <strong class="text-headline">{{ $form->turma ?: 'N/A' }}</strong></span>
                                        <span class="hidden sm:inline">|</span>
                                        <span>Ano: <strong class="text-headline">{{ $form->ano_letivo ?: 'N/A' }}</strong></span>
                                        <span class="hidden sm:inline">|</span>
                                        <span>Criado por: <strong class="text-headline">{{ $form->creator->name ?? 'N/A' }}</strong></span>
                                        <span class="hidden sm:inline">|</span>
                                        <span>Perguntas: <strong class="text-headline">{{ $form->questions_count }}</strong></span>
                                    </div>

                                    @if($form->status === 'reprovado' && $form->rejection_reason)
                                        <div class="mt-3 text-sm text-red-800 p-3 bg-red-100/50 rounded-lg border border-red-200">
                                            <strong class="font-semibold">Motivo da Reprovação:</strong> {{ $form->rejection_reason }}
                                            @if($form->validator)
                                                <em class="text-xs text-red-600 block mt-1">- Reprovado por: {{ $form->validator->name }}</em>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-shrink-0 flex items-center justify-end space-x-1 mt-4 sm:mt-0">
                                    @if ($form->status === 'pendente' && (Auth::user()->role === 'coordenador' || Auth::user()->role === 'admin'))
                                        <form action="{{ route('forms.approve', $form) }}" method="POST" class="contents"><button type="submit" class="p-2 text-green-600 hover:bg-green-100 rounded-full transition-colors" title="Aprovar Formulário">@csrf<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z" clip-rule="evenodd" /></svg></button></form>
                                    @endif
                                    @can('resubmit-form', $form)
                                        <form action="{{ route('forms.resubmit', $form) }}" method="POST" class="contents"><button type="submit" class="p-2 text-blue-600 hover:bg-blue-100 rounded-full transition-colors" title="Reenviar para Análise">@csrf<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M3.105 6.105a.75.75 0 01.053-1.053l.053-.053.053-.053a.75.75 0 011.053.053l1.269 1.269a.75.75 0 01.053 1.053l-.053.053a6.5 6.5 0 009.642 7.74l-1.27-1.27a.75.75 0 01-.052-1.053l.052-.053a4.999 4.999 0 01-7.424-5.593l1.27 1.27a.75.75 0 01.053 1.053l-.053.053a.75.75 0 01-1.053-.053l-3.053-3.053zM16.895 13.895a.75.75 0 01-.053 1.053l-.053.053-.052.053a.75.75 0 01-1.053-.053l-1.27-1.27a.75.75 0 01-.052-1.053l.052-.053a6.5 6.5 0 00-9.643-7.74l1.27 1.27a.75.75 0 01.053 1.053l-.053.053a.75.75 0 01-1.053-.053L2 6.105a.75.75 0 01-.053-1.053l.053-.053.053-.053a.75.75 0 011.053.053L6.16 8.052a4.999 4.999 0 017.424 5.593l-1.27-1.27a.75.75 0 01-.053-1.053l.053-.053a.75.75 0 011.053.053l3.053 3.053z" /></svg></button></form>
                                    @endcan
                                    <a href="{{ route('forms.edit', $form) }}" class="p-2 text-indigo-600 hover:bg-indigo-100 rounded-full transition-colors" title="Editar Formulário"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" /></svg></a>
                                    <button type="button" @click.prevent="formIdToDelete = 'deleteForm-{{ $form->id }}'; $dispatch('open-modal', 'confirm-form-deletion')" class="p-2 text-danger hover:bg-red-100 rounded-full transition-colors" title="Excluir Formulário"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.58.22-2.365.468a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193v-.443A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" /></svg></button>
                                </div>
                            </div>
                            <form id="deleteForm-{{ $form->id }}" action="{{ route('forms.destroy', $form) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-background rounded-lg shadow-md">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Sem formulários</h3>
                            <p class="mt-1 text-sm text-gray-500">Comece criando um novo formulário.</p>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
        <x-modal name="confirm-form-deletion" focusable>
            <div class="p-6">
                <h2 class="text-lg font-medium text-headline">Tem certeza que deseja excluir este formulário?</h2>
                <p class="mt-1 text-sm text-paragraph">Uma vez que o formulário for excluído, todos os seus dados e perguntas relacionadas serão permanentemente removidos. Esta ação não pode ser desfeita.</p>
                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button @click.prevent="$dispatch('close')">Cancelar</x-secondary-button>
                    <x-danger-button @click.prevent="if(formIdToDelete) {document.getElementById(formIdToDelete).submit();}">Excluir Formulário</x-danger-button>
                </div>
            </div>
        </x-modal>
    </div>
</x-app-layout>
