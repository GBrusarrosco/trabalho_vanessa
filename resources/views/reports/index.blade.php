<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            📊 Relatório de Respostas dos Alunos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8"> {{-- Aumentei um pouco o max-width para relatórios --}}

            @if($forms->isEmpty())
                <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                    <h3 class="mt-4 text-xl font-semibold text-headline">Nenhum Formulário</h3>
                    <p class="mt-2 text-sm text-paragraph">
                        Ainda não há formulários com respostas ou você não tem acesso aos relatórios correspondentes.
                    </p>
                </div>
            @else
                <div class="space-y-8"> {{-- Espaçamento entre os cards de cada formulário --}}
                    @foreach($forms as $form)
                        <div class="bg-background overflow-hidden shadow-2xl sm:rounded-xl"> {{-- Sombra mais pronunciada para o card principal do formulário --}}
                            <div class="p-6 sm:p-8 border-b border-secondary">
                                <h3 class="text-2xl font-bold text-primary mb-1">{{ $form->title }}</h3>
                                <div class="flex flex-wrap items-center text-xs text-paragraph space-x-4">
                                    @if($form->creator)
                                        <span>Criado por: <strong class="text-headline">{{ $form->creator->name }}</strong></span>
                                    @endif
                                    @if($form->is_validated)
                                        <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-800 font-medium">Validado</span>
                                        @if($form->validator)
                                            <span class="text-xs text-gray-500">(por {{ $form->validator->name }})</span>
                                        @endif
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-800 font-medium">Pendente de Validação</span>
                                    @endif
                                    <span>Criado em: {{ $form->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <p class="mt-3 text-sm text-paragraph">{{ $form->description ?? 'Este formulário não possui uma descrição detalhada.' }}</p>
                            </div>

                            <div class="p-6 sm:p-8">
                                @if($form->questions->isEmpty())
                                    <div class="text-center py-6">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                        </svg>
                                        <h4 class="mt-2 text-md font-medium text-headline">Sem Perguntas</h4>
                                        <p class="mt-1 text-xs text-paragraph">Este formulário não possui perguntas cadastradas.</p>
                                    </div>
                                @else
                                    <h4 class="text-lg font-semibold text-headline mb-4">Respostas por Pergunta:</h4>
                                    <div class="space-y-6">
                                        @foreach($form->questions as $question)
                                            <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg border border-secondary">
                                                <div class="flex justify-between items-start mb-3">
                                                    <h5 class="text-md font-semibold text-headline">
                                                        {{ $loop->iteration }}. {{ $question->question_text }}
                                                    </h5>
                                                    <span class="text-xs font-medium px-2 py-1 rounded-full bg-indigo-100 text-primary">
                                                        {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                                                    </span>
                                                </div>

                                                @if($question->answers->isEmpty())
                                                    <p class="text-sm text-paragraph italic pl-2">Nenhuma resposta recebida para esta pergunta.</p>
                                                @else
                                                    <div class="space-y-2 pl-2">
                                                        @foreach($question->answers as $answer)
                                                            <div class="text-sm text-paragraph border-l-4 border-primary pl-3 py-1 bg-background rounded-r-md">
                                                                <span class="font-semibold text-headline">{{ $answer->student->user->name ?? 'Aluno desconhecido' }}:</span>
                                                                <p class="mt-0.5 whitespace-pre-wrap">{{ $answer->answer_text }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
