<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            📊 Relatório de Respostas dos Alunos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if($forms->isEmpty())
                <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">
                    {{-- ... (código para estado vazio permanece o mesmo) ... --}}
                </div>
            @else
                <div class="space-y-10">
                    @foreach($forms as $form)
                        <div class="bg-background overflow-hidden shadow-2xl sm:rounded-xl border border-secondary">
                            <div class="p-6 sm:p-8 border-b border-secondary">
                                <h3 class="text-2xl font-bold text-primary mb-1">{{ $form->title }}</h3>
                                <p class="text-sm text-paragraph">{{ $form->description ?? 'Este formulário não possui descrição.' }}</p>
                                <div class="mt-2 text-xs text-paragraph">
                                    <span>Criado por: <strong class="text-headline">{{ $form->creator->name ?? 'N/A' }}</strong></span> |
                                    <span>Status: <strong class="text-headline">{{ ucfirst($form->status) }}</strong></span>
                                </div>
                            </div>

                            <div class="p-6 sm:p-8 space-y-8">
                                @forelse($form->questions as $question)
                                    <div class="bg-gray-50 p-5 rounded-lg border border-secondary/50">
                                        <h4 class="text-md font-semibold text-headline">
                                            {{ $loop->iteration }}. {{ $question->question_text }}
                                        </h4>
                                        <hr class="my-3">

                                        @if($question->answers->isEmpty())
                                            <p class="text-sm text-paragraph italic">Nenhuma resposta recebida para esta pergunta.</p>
                                        @else
                                            {{-- Lógica condicional para tipo de pergunta --}}
                                            @if($question->type === 'multipla_escolha')
                                                <div class="max-w-full">
                                                    {{-- O Canvas onde o gráfico será renderizado --}}
                                                    <canvas x-data
                                                            x-init="
                                                                new Chart($el, {
                                                                    type: 'bar',
                                                                    data: {
                                                                        labels: @json($question->chart_data['labels']),
                                                                        datasets: [{
                                                                            label: 'Nº de Respostas',
                                                                            data: @json($question->chart_data['values']),
                                                                            backgroundColor: 'rgba(98, 70, 234, 0.6)',
                                                                            borderColor: 'rgba(98, 70, 234, 1)',
                                                                            borderWidth: 1
                                                                        }]
                                                                    },
                                                                    options: {
                                                                        indexAxis: 'y', // Gráfico de barras horizontais
                                                                        scales: {
                                                                            x: { beginAtZero: true, ticks: { stepSize: 1 } }
                                                                        },
                                                                        plugins: { legend: { display: false } }
                                                                    }
                                                                });
                                                            "
                                                    ></canvas>
                                                </div>
                                            @else {{-- Para tipo 'texto' --}}
                                            <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                                                @foreach($question->answers as $answer)
                                                    <div class="text-sm border-l-4 border-primary/50 pl-3 py-1 bg-white rounded-r-md">
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
