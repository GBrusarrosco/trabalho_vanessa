<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            📊 Relatório de Respostas dos Alunos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if($forms->isEmpty())
                <div class="text-center py-16 bg-background rounded-lg shadow-md border border-secondary">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 100 15 7.5 7.5 0 000-15zM21 21l-5.197-5.197" /></svg>
                    <h3 class="mt-2 text-sm font-semibold text-headline">Nenhum Relatório Disponível</h3>
                    <p class="mt-1 text-sm text-gray-500">Ainda não há formulários aprovados com respostas para exibir.</p>
                </div>
            @else
                <div class="space-y-10">
                    @foreach($forms as $form)
                        <div class="bg-background overflow-hidden shadow-xl sm:rounded-xl border border-secondary" x-data="{ open: true }">
                            <div class="p-6 sm:p-8 cursor-pointer hover:bg-gray-50/50 transition-colors" @click="open = !open">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-2xl font-bold text-primary">{{ $form->title }}</h3>
                                    <button type="button" class="p-2 rounded-full hover:bg-gray-100">
                                        <svg class="w-6 h-6 text-gray-500 transition-transform" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                                    </button>
                                </div>
                                <p class="mt-1 text-sm text-paragraph">{{ $form->description ?? 'Este formulário não possui uma descrição detalhada.' }}</p>
                            </div>

                            <div class="p-6 sm:p-8 border-t border-secondary space-y-8" x-show="open" x-transition>
                                @forelse($form->questions as $question)
                                    <div class="bg-gray-50 p-5 rounded-lg border border-secondary/50">
                                        <h4 class="text-md font-semibold text-headline">{{ $loop->iteration }}. {{ $question->question_text }}</h4>
                                        <hr class="my-3">
                                        @if($question->answers->isEmpty())
                                            <p class="text-sm text-paragraph italic">Nenhuma resposta recebida para esta pergunta.</p>
                                        @else
                                            @if($question->type === 'multipla_escolha' && isset($question->aggregated_results))
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                                                    <div class="md:col-span-2 space-y-4">
                                                        @foreach($question->aggregated_results as $result)
                                                            <div>
                                                                <div class="flex justify-between items-center text-sm mb-1">
                                                                    <span class="text-paragraph font-medium">{{ $result['option'] }}</span>
                                                                    <span class="font-semibold text-headline">{{ $result['percentage'] }}% ({{ $result['count'] }} votos)</span>
                                                                </div>
                                                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                                    <div class="bg-primary h-2.5 rounded-full" style="width: {{ $result['percentage'] }}%"></div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="max-w-[200px] mx-auto">
                                                        <canvas x-data x-init="new Chart($el, { type: 'doughnut', data: { labels: @json($question->chart_data['labels']), datasets: [{ data: @json($question->chart_data['values']), backgroundColor: ['#6246ea', '#d1d1e9', '#2b2c34', '#e45858', '#fde047', '#34d399'], hoverOffset: 4 }] }, options: { plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 15 } } } } });"></canvas>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                                                    @foreach($question->answers as $answer)
                                                        <div class="text-sm border-l-4 border-primary/50 pl-3 py-1 bg-white rounded-r-md shadow-sm">
                                                            <p class="text-paragraph whitespace-pre-wrap">{{ $answer->answer_text }}</p>
                                                            <p class="text-xs text-gray-500 mt-1">- {{ $answer->student->user->name ?? 'Aluno' }}</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-center text-paragraph py-8">Este formulário não possui perguntas.</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
