<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Meu Histórico de Respostas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if($answersByForm->isEmpty())
                <div class="text-center py-16 bg-background rounded-lg shadow-md border border-secondary">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5l.415-.207a.75.75 0 011.06 0l.415.207a.75.75 0 001.06 0l.415-.207a.75.75 0 011.06 0l.415.207a.75.75 0 001.06 0l.415-.207a.75.75 0 011.06 0l.415.207a.75.75 0 001.06 0l.415-.207a.75.75 0 011.06 0l.34.17a.75.75 0 010 1.28l-.34.17a.75.75 0 000 1.28l.34.17a.75.75 0 010 1.28l-.34.17a.75.75 0 000 1.28l.34.17a.75.75 0 010 1.28l-.34.17a.75.75 0 000 1.28l.34.17a.75.75 0 010 1.28l-3.046 1.524a.75.75 0 01-1.06 0l-.415-.207a.75.75 0 00-1.06 0l-.415.207a.75.75 0 01-1.06 0l-.415-.207a.75.75 0 00-1.06 0l-.415.207a.75.75 0 01-1.06 0l-.415-.207a.75.75 0 00-1.06 0l-.415.207a.75.75 0 01-1.06 0L3 16.5z" /></svg>
                    <h3 class="mt-2 text-sm font-semibold text-headline">Nenhuma Resposta</h3>
                    <p class="mt-1 text-sm text-gray-500">Você ainda não respondeu a nenhum formulário.</p>
                </div>
            @else
                <div class="space-y-8" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 50)">
                    @foreach($answersByForm as $formTitle => $answers)
                        <div class="bg-background shadow-xl sm:rounded-lg overflow-hidden border border-secondary transition-all duration-500 ease-out"
                             :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }"
                             :style="'transition-delay: {{ $loop->index * 100 }}ms'">
                            <div class="p-6 border-b border-secondary">
                                <h3 class="text-lg font-bold text-primary">{{ $formTitle }}</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                @foreach($answers as $answer)
                                    <div>
                                        <p class="font-semibold text-sm text-headline">{{ $answer->question->question_text }}</p>
                                        <p class="mt-1 text-md text-paragraph border-l-2 border-primary/50 pl-3">{{ $answer->answer_text }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
