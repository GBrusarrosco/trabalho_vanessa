<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Mini-Relatório do Aluno: {{ $student->user->name }}
        </h2>
    </x-slot>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-background rounded-xl shadow-lg p-8 border border-secondary mb-8">
            <h3 class="text-lg font-bold mb-4 text-headline">Respostas Recentes</h3>
            @if($answers->isEmpty())
                <p class="text-paragraph italic">Nenhuma resposta registrada.</p>
            @else
                <div class="space-y-4">
                    @foreach($answers as $answer)
                        <div class="p-4 rounded-lg border border-secondary bg-white">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-2">
                                <span class="font-semibold text-primary">Pergunta:</span>
                                <span class="text-paragraph">{{ $answer->question->question_text }}</span>
                            </div>
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-2">
                                <span class="font-semibold text-primary">Formulário:</span>
                                <span class="text-paragraph">{{ $answer->question->form->title }}</span>
                            </div>
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-2">
                                <span class="font-semibold text-primary">Professor Responsável:</span>
                                <span class="text-paragraph">{{ $answer->question->form->creator->name ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-2">
                                <span class="font-semibold text-primary">Respondido em:</span>
                                <span class="text-paragraph">{{ $answer->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="font-semibold text-primary">Resposta:</span>
                                <div class="bg-gray-50 rounded p-2 mt-1 text-paragraph">{{ $answer->answer_text }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <a href="{{ url()->previous() }}" class="inline-block px-4 py-2 bg-secondary text-paragraph rounded hover:bg-secondary/80 transition">Voltar</a>
    </div>
</x-app-layout>
