<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-headline leading-tight">
            {{ __('Painel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensagem de Boas-vindas e Ações Rápidas --}}
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8 mb-8">
                <div class="text-headline text-xl font-semibold">
                    @if($user?->role === 'aluno')
                        Bem-vindo, <span class="text-primary font-bold">Aluno</span>!
                        <p class="mt-2 text-base font-normal text-paragraph">Acompanhe seus formulários e atividades.</p>
                        @if(isset($stats['pending_forms_to_answer']) && $stats['pending_forms_to_answer'] > 0)
                            <div class="mt-4">
                                <a href="#" class="inline-flex items-center px-4 py-2 bg-primary text-button-text text-sm font-medium rounded-md hover:bg-opacity-90 transition-colors duration-150">
                                    Você tem {{ $stats['pending_forms_to_answer'] }} formulário(s) para responder
                                </a>
                            </div>
                        @elseif(isset($stats['pending_forms_to_answer']))
                            <p class="mt-2 text-base font-normal text-paragraph">Você não tem formulários pendentes para responder no momento.</p>
                        @endif
                    @elseif($user?->role === 'professor')
                        Bem-vindo, <span class="text-primary font-bold">Professor</span>!
                        <p class="mt-2 text-base font-normal text-paragraph">Crie e gerencie suas avaliações.</p>
                        <div class="mt-4">
                            <a href="{{ route('forms.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-button-text text-sm font-medium rounded-md hover:bg-opacity-90 transition-colors duration-150">Criar Novo Formulário</a>
                        </div>
                    @elseif($user?->role === 'coordenador')
                        Bem-vindo, <span class="text-primary font-bold">Coordenador</span>!
                        <p class="mt-2 text-base font-normal text-paragraph">Gerencie o sistema de avaliações.</p>
                        @if(isset($stats['pending_forms']) && $stats['pending_forms'] > 0)
                            <div class="mt-4">
                                <a href="{{ route('forms.index') }}?status=pendente" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600 transition-colors duration-150">
                                    {{ $stats['pending_forms'] }} formulário(s) pendente(s) de validação
                                </a>
                            </div>
                        @endif
                    @elseif($user?->role === 'admin')
                        Bem-vindo, <span class="text-primary font-bold">Administrador</span>!
                        <p class="mt-2 text-base font-normal text-paragraph">Visão geral do sistema.</p>
                    @else
                        Bem-vindo!
                    @endif
                </div>
            </div>

            {{-- Seção de Estatísticas --}}
            @if(isset($stats) && !empty($stats))
                <div class="mb-10">
                    <h3 class="text-2xl font-semibold text-headline mb-5">Visão Geral</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                        {{-- Cards para Admin e Coordenador --}}
                        @if($user && in_array($user->role, ['admin', 'coordenador']))
                            <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary"><h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Total de Formulários</h4><p class="mt-1 text-4xl font-bold text-primary">{{ $stats['total_forms'] ?? 0 }}</p></div>
                            <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary"><h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Pendentes de Validação</h4><p class="mt-1 text-4xl font-bold text-yellow-500">{{ $stats['pending_forms'] ?? 0 }}</p></div>
                            <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary"><h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Aprovados</h4><p class="mt-1 text-4xl font-bold text-green-500">{{ $stats['approved_forms'] ?? 0 }}</p></div>
                            <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary"><h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Total de Alunos</h4><p class="mt-1 text-4xl font-bold text-primary">{{ $stats['total_students'] ?? 0 }}</p></div>
                            <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary"><h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Total de Professores</h4><p class="mt-1 text-4xl font-bold text-primary">{{ $stats['total_teachers'] ?? 0 }}</p></div>
                        @endif
                        {{-- Cards para Professor --}}
                        @if($user?->role === 'professor')
                            <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary"><h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Meus Formulários Criados</h4><p class="mt-1 text-4xl font-bold text-primary">{{ $stats['my_forms_count'] ?? 0 }}</p></div>
                            <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary"><h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Pendentes</h4><p class="mt-1 text-4xl font-bold text-yellow-500">{{ $stats['my_pending_forms'] ?? 0 }}</p></div>
                            <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary"><h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Aprovados</h4><p class="mt-1 text-4xl font-bold text-green-500">{{ $stats['my_approved_forms'] ?? 0 }}</p></div>
                            <div class="bg-background p-6 rounded-xl shadow-lg border border-secondary"><h4 class="text-sm font-medium text-paragraph uppercase tracking-wider">Reprovados</h4><p class="mt-1 text-4xl font-bold text-danger">{{ $stats['my_rejected_forms'] ?? 0 }}</p></div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Seção de Itens de Ação --}}
            <div class="space-y-10">
                {{-- Seção Unificada para PROFESSOR --}}
                @if($user->role === 'professor')
                    @if(isset($recentItems['my_forms']) && $recentItems['my_forms']->count() > 0)
                        <div>
                            <h3 class="text-2xl font-semibold text-headline mb-5">Meus Formulários</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($recentItems['my_forms'] as $form)
                                    @php
                                        $cardClasses = match($form->status) { 'reprovado' => 'bg-red-50 border-danger/30', 'pendente' => 'bg-yellow-50 border-yellow-400/50', default => 'bg-background border-secondary' };
                                        $titleClasses = match($form->status) { 'reprovado' => 'text-danger', 'pendente' => 'text-yellow-600', default => 'text-primary' };
                                        $buttonClasses = match($form->status) { 'reprovado' => 'border-danger text-danger bg-white hover:bg-red-100', 'pendente' => 'border-primary text-primary bg-transparent hover:bg-primary hover:text-button-text', default => 'border-gray-300 text-gray-600 bg-white hover:bg-gray-100' };
                                        $buttonText = match($form->status) { 'reprovado' => 'Corrigir e Reenviar', 'pendente' => 'Gerenciar / Adicionar Perguntas', default => 'Ver Detalhes' };
                                    @endphp
                                    <div class="{{ $cardClasses }} p-6 rounded-xl shadow-lg flex flex-col justify-between transition-all duration-300 transform hover:-translate-y-1">
                                        <div>
                                            <div class="flex justify-between items-start"><h4 class="text-lg font-bold mb-2 truncate {{ $titleClasses }}" title="{{ $form->title }}">{{ $form->title }}</h4>
                                                @if ($form->status === 'aprovado')<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aprovado</span>
                                                @elseif ($form->status === 'reprovado')<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-danger">Reprovado</span>
                                                @else<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendente</span>
                                                @endif
                                            </div>
                                            @if($form->status === 'reprovado' && $form->rejection_reason)
                                                <p class="text-sm text-red-800 mb-2 italic">"{{ $form->rejection_reason }}"</p>
                                                @if($form->validator)<p class="text-xs text-red-700 mb-3 font-medium">- Reprovado por: {{ $form->validator->name }}</p>@endif
                                            @else
                                                <p class="text-sm text-paragraph mb-3 min-h-[2.5rem]">{{ Str::limit($form->description, 75) ?: 'Sem descrição.' }}</p>
                                            @endif
                                        </div>
                                        <div class="mt-auto pt-4 border-t {{ $form->status === 'reprovado' ? 'border-red-200' : 'border-secondary' }}">
                                            <a href="{{ route('forms.edit', $form->id) }}" class="block w-full text-center px-4 py-2 border text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-150 {{ $buttonClasses }}">{{ $buttonText }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-16 bg-background rounded-lg shadow-md"><p class="font-semibold text-paragraph">Você ainda não criou nenhum formulário.</p><a href="{{ route('forms.create') }}" class="mt-4 inline-block text-primary hover:underline">Clique aqui para criar o primeiro!</a></div>
                    @endif
                @endif

                {{-- Seção para COORDENADOR (CÓDIGO COMPLETO) --}}
                @if($user?->role === 'coordenador' && isset($recentItems['forms_pending_validation']))
                    @if($recentItems['forms_pending_validation']->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-2xl font-semibold text-headline mb-5">Formulários Pendentes de Validação</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($recentItems['forms_pending_validation'] as $form)
                                    <div class="bg-yellow-50 p-6 rounded-xl shadow-lg border border-yellow-400/50 flex flex-col justify-between">
                                        <div>
                                            <div class="flex justify-between items-start">
                                                <h4 class="text-lg font-bold text-yellow-600 mb-1 truncate" title="{{ $form->title }}">{{ $form->title }}</h4>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendente</span>
                                            </div>
                                            @if($form->creator)
                                                <p class="text-xs text-yellow-700 mb-2">Criado por: {{ $form->creator->name }}</p>
                                            @endif
                                            <p class="text-sm text-paragraph mb-3 min-h-[2.5rem]">{{ Str::limit($form->description, 75) ?: 'Sem descrição.' }}</p>
                                        </div>
                                        <div class="mt-auto pt-4 border-t border-yellow-200">
                                            <a href="{{ route('forms.edit', $form->id) }}" class="block w-full text-center px-4 py-2 border border-yellow-500 text-sm font-medium rounded-md text-yellow-600 bg-white hover:bg-yellow-100 transition-colors duration-150">
                                                Revisar / Validar
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-10 bg-background rounded-lg shadow-md">
                            <p class="font-semibold text-paragraph">Nenhum formulário pendente de validação no momento.</p>
                        </div>
                    @endif
                @endif

                {{-- Seção para ALUNO (CÓDIGO COMPLETO) --}}
                @if($user?->role === 'aluno' && isset($recentItems['forms_to_answer']))
                    @if($recentItems['forms_to_answer']->count() > 0)
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
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
