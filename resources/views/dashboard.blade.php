<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-headline leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensagem de Boas-vindas e Ações Rápidas --}}
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8 mb-8">
                <div class="text-headline text-xl font-semibold mb-4">
                    @if($user && $user->role === 'aluno')
                        Bem-vindo, <span class="text-primary font-bold">Aluno</span>!
                        <p class="mt-2 text-base font-normal text-paragraph">Acompanhe seus formulários e atividades.</p>
                        @if(isset($stats['pending_forms_to_answer']) && $stats['pending_forms_to_answer'] > 0)
                            <div class="mt-4">
                                <a href="#" {{-- Substitua '#' pela rota para formulários pendentes do aluno --}}
                                class="inline-flex items-center px-4 py-2 bg-primary text-button-text text-sm font-medium rounded-md hover:bg-opacity-90 transition-colors duration-150">
                                    Você tem {{ $stats['pending_forms_to_answer'] }} formulário(s) para responder
                                </a>
                            </div>
                        @elseif(isset($stats['pending_forms_to_answer']) && $stats['pending_forms_to_answer'] == 0 && $user->role === 'aluno')
                            <p class="mt-2 text-base font-normal text-paragraph">Você não tem formulários pendentes para responder no momento.</p>
                        @endif
                    @elseif($user && $user->role === 'professor')
                        Bem-vindo, <span class="text-primary font-bold">Professor</span>!
                        <p class="mt-2 text-base font-normal text-paragraph">Crie e gerencie suas avaliações.</p>
                        <div class="mt-4">
                            <a href="{{ route('forms.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-primary text-button-text text-sm font-medium rounded-md hover:bg-opacity-90 transition-colors duration-150">
                                Criar Novo Formulário
                            </a>
                        </div>
                    @elseif($user && $user->role === 'coordenador')
                        Bem-vindo, <span class="text-primary font-bold">Coordenador</span>!
                        <p class="mt-2 text-base font-normal text-paragraph">Gerencie o sistema de avaliações.</p>
                        @if(isset($stats['pending_forms']) && $stats['pending_forms'] > 0)
                            <div class="mt-4">
                                <a href="{{ route('forms.index') }}?status=pending_validation"
                                   class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600 transition-colors duration-150">
                                    {{ $stats['pending_forms'] }} formulário(s) pendente(s) de validação
                                </a>
                            </div>
                        @endif
                    @elseif($user && $user->role === 'admin')
                        Bem-vindo, <span class="text-primary font-bold">Administrador</span>!
                        <p class="mt-2 text-base font-normal text-paragraph">Visão geral do sistema.</p>
                    @else
                        Bem-vindo!
                        <p class="mt-2 text-base font-normal text-paragraph">Seu perfil não foi identificado ou você não está logado.</p>
                    @endif
                </div>
            </div>

            {{-- Seção de Estatísticas --}}
            @if(isset($stats) && is_array($stats) && count($stats) > 0)
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold text-headline mb-5">Visão Geral</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if($user && ($user->role === 'admin' || $user->role === 'coordenador'))
                            @if(isset($stats['total_forms']))
                                <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary hover:shadow-2xl transition-shadow duration-300">
                                    <h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Total de Formulários</h4>
                                    <p class="mt-1 text-4xl font-bold text-primary">{{ $stats['total_forms'] }}</p>
                                </div>
                            @endif
                            @if(isset($stats['pending_forms']))
                                <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary hover:shadow-2xl transition-shadow duration-300">
                                    <h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Form. Pendentes Validação</h4>
                                    <p class="mt-1 text-4xl font-bold text-yellow-500">{{ $stats['pending_forms'] }}</p>
                                </div>
                            @endif
                            @if(isset($stats['approved_forms']))
                                <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary hover:shadow-2xl transition-shadow duration-300">
                                    <h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Formulários Aprovados</h4>
                                    <p class="mt-1 text-4xl font-bold text-green-500">{{ $stats['approved_forms'] }}</p>
                                </div>
                            @endif
                            @if(isset($stats['total_students']))
                                <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary hover:shadow-2xl transition-shadow duration-300">
                                    <h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Total de Alunos</h4>
                                    <p class="mt-1 text-4xl font-bold text-primary">{{ $stats['total_students'] }}</p>
                                </div>
                            @endif
                            @if(isset($stats['total_teachers']))
                                <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary hover:shadow-2xl transition-shadow duration-300">
                                    <h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Total de Professores</h4>
                                    <p class="mt-1 text-4xl font-bold text-primary">{{ $stats['total_teachers'] }}</p>
                                </div>
                            @endif
                        @endif
                        @if($user && $user->role === 'professor')
                            @if(isset($stats['my_forms_count']))
                                <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary hover:shadow-2xl transition-shadow duration-300">
                                    <h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Meus Formulários Criados</h4>
                                    <p class="mt-1 text-4xl font-bold text-primary">{{ $stats['my_forms_count'] }}</p>
                                </div>
                            @endif
                            @if(isset($stats['my_pending_forms']))
                                <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary hover:shadow-2xl transition-shadow duration-300">
                                    <h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Meus Pendentes de Validação</h4>
                                    <p class="mt-1 text-4xl font-bold text-yellow-500">{{ $stats['my_pending_forms'] }}</p>
                                </div>
                            @endif
                            @if(isset($stats['my_approved_forms']))
                                <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary hover:shadow-2xl transition-shadow duration-300">
                                    <h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Meus Formulários Aprovados</h4>
                                    <p class="mt-1 text-4xl font-bold text-green-500">{{ $stats['my_approved_forms'] }}</p>
                                </div>
                            @endif
                        @endif
                        @if($user && $user->role === 'aluno')
                            @if(isset($stats['total_assigned_forms']))
                                <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary hover:shadow-2xl transition-shadow duration-300">
                                    <h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Formulários Atribuídos</h4>
                                    <p class="mt-1 text-4xl font-bold text-primary">{{ $stats['total_assigned_forms'] }}</p>
                                </div>
                            @endif
                            @if(isset($stats['pending_forms_to_answer']))
                                <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary hover:shadow-2xl transition-shadow duration-300">
                                    <h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Pendentes para Responder</h4>
                                    <p class="mt-1 text-4xl font-bold text-yellow-500">{{ $stats['pending_forms_to_answer'] }}</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @elseif(isset($stats) && is_array($stats) && count($stats) == 0)
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold text-headline mb-5">Visão Geral</h3>
                    <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary">
                        <p class="text-paragraph text-center">Nenhuma estatística disponível no momento.</p>
                    </div>
                </div>
            @endif

            {{-- Seção de Itens Recentes --}}
            @if(isset($recentItems) && is_array($recentItems) && (
                ($user && $user->role === 'professor' && isset($recentItems['my_recent_forms']) && $recentItems['my_recent_forms']->count() > 0) ||
                ($user && $user->role === 'aluno' && isset($recentItems['forms_to_answer']) && $recentItems['forms_to_answer']->count() > 0) ||
                ($user && $user->role === 'coordenador' && isset($recentItems['forms_pending_validation']) && $recentItems['forms_pending_validation']->count() > 0)
            ))
                <div class="mb-8">
                    @if($user && $user->role === 'professor' && isset($recentItems['my_recent_forms']) && $recentItems['my_recent_forms']->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-2xl font-semibold text-headline mb-5">Meus Formulários Recentes</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($recentItems['my_recent_forms'] as $form)
                                    <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary flex flex-col justify-between hover:shadow-2xl transition-shadow duration-300">
                                        <div>
                                            <h4 class="text-lg font-semibold text-primary mb-2 truncate">
                                                <a href="{{ route('forms.edit', $form->id) }}" class="hover:underline" title="{{ $form->title }}">
                                                    {{ $form->title }}
                                                </a>
                                            </h4>
                                            <p class="text-sm text-paragraph mb-3 min-h-[3.5rem]">
                                                {{ Str::limit($form->description, 75) ?: 'Sem descrição.' }}
                                            </p>
                                        </div>
                                        <div class="mt-auto">
                                            <div class="flex justify-between items-center mb-3 text-xs">
                                                <span class="px-2 py-1 rounded-full font-medium {{ $form->is_validated ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $form->is_validated ? 'Validado' : 'Pendente' }}
                                                </span>
                                                <span class="text-paragraph">
                                                   {{ $form->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <a href="{{ route('forms.edit', $form->id) }}"
                                               class="block w-full text-center px-4 py-2 border border-primary text-sm font-medium rounded-md text-primary bg-transparent hover:bg-primary hover:text-button-text focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-150">
                                                Gerenciar
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($user && $user->role === 'aluno' && isset($recentItems['forms_to_answer']) && $recentItems['forms_to_answer']->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-2xl font-semibold text-headline mb-5">Formulários para Responder</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($recentItems['forms_to_answer'] as $form)
                                    <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary flex flex-col justify-between hover:shadow-2xl transition-shadow duration-300">
                                        <div>
                                            <h4 class="text-lg font-semibold text-primary mb-2 truncate" title="{{ $form->title }}">
                                                {{ $form->title }}
                                            </h4>
                                            <p class="text-sm text-paragraph mb-3 min-h-[3.5rem]">
                                                {{ Str::limit($form->description, 75) ?: 'Sem descrição.' }}
                                            </p>
                                        </div>
                                        <div class="mt-auto">
                                             <span class="text-xs text-paragraph mb-3 block">
                                                Atribuído: {{ $form->pivot ? $form->pivot->created_at->diffForHumans() : $form->updated_at->diffForHumans() }}
                                            </span>
                                            <a href="{{ route('forms.responder', $form->id) }}"
                                               class="block w-full text-center px-4 py-2 bg-primary border border-transparent text-sm font-medium rounded-md text-button-text hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-150">
                                                Responder Agora
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($user && $user->role === 'coordenador' && isset($recentItems['forms_pending_validation']) && $recentItems['forms_pending_validation']->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-2xl font-semibold text-headline mb-5">Formulários Pendentes de Validação</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($recentItems['forms_pending_validation'] as $form)
                                    <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary flex flex-col justify-between hover:shadow-2xl transition-shadow duration-300">
                                        <div>
                                            <h4 class="text-lg font-semibold text-primary mb-1 truncate">
                                                <a href="{{ route('forms.edit', $form->id) }}" class="hover:underline" title="{{ $form->title }}">
                                                    {{ $form->title }}
                                                </a>
                                            </h4>
                                            @if($form->creator)
                                                <p class="text-xs text-paragraph mb-2">Criado por: {{ $form->creator->name }}</p>
                                            @endif
                                            <p class="text-sm text-paragraph mb-3 min-h-[3.5rem]">
                                                {{ Str::limit($form->description, 75) ?: 'Sem descrição.' }}
                                            </p>
                                        </div>
                                        <div class="mt-auto">
                                            <span class="text-xs text-paragraph mb-3 block">
                                                Criado: {{ $form->created_at->diffForHumans() }}
                                            </span>
                                            <a href="{{ route('forms.edit', $form->id) }}"
                                               class="block w-full text-center px-4 py-2 bg-yellow-500 border border-transparent text-sm font-medium rounded-md text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-150">
                                                Revisar / Validar
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @elseif(isset($recentItems) && is_array($recentItems) && count($recentItems) == 0)
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold text-headline mb-5">Itens Recentes</h3>
                    <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary">
                        <p class="text-paragraph text-center">Nenhum item recente para exibir.</p>
                    </div>
                </div>
            @endif

            {{-- Cards genéricos de Notificações e Atividades --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-background rounded-xl shadow-lg p-6 border border-secondary hover:shadow-2xl transition-shadow duration-300">
                    <h3 class="text-lg font-bold text-headline mb-3">Notificações</h3>
                    <p class="text-paragraph text-sm">Nenhuma notificação no momento.</p>
                </div>
                <div class="bg-background rounded-xl shadow-lg p-6 border border-secondary hover:shadow-2xl transition-shadow duration-300">
                    <h3 class="text-lg font-bold text-headline mb-3">Atividades Recentes</h3>
                    <p class="text-paragraph text-sm">Você está atualizado!</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
