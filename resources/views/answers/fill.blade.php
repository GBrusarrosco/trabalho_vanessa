<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Respondendo: <span class="text-primary">{{ $form->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
                @if($form->description)
                    <div class="mb-6 border-b border-secondary pb-6">
                        <h3 class="text-lg font-semibold text-headline">Instruções</h3>
                        <p class="mt-1 text-sm text-paragraph">{{ $form->description }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('forms.enviar', $form) }}" class="space-y-8">
                    @csrf

                    @forelse ($questions as $index => $question)
                        <div class="transition-all duration-500 ease-out"
                             x-data="{ loaded: false }"
                             x-init="setTimeout(() => loaded = true, {{ $index * 100 }})"
                             :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-5': !loaded }">

                            <label for="question_{{ $question->id }}" class="block text-md font-semibold text-headline mb-3">
                                {{ $loop->iteration }}. {{ $question->question_text }}
                            </label>

                            @if ($question->type === 'texto')
                                <textarea name="answers[{{ $question->id }}]" id="question_{{ $question->id }}" rows="4"
                                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-paragraph" required></textarea>
                            @elseif ($question->type === 'multipla_escolha')
                                <div class="space-y-2 mt-2">
                                    @foreach ($question->options as $option)
                                        <label class="flex items-center p-3 rounded-md border border-gray-200 hover:bg-gray-50 has-[:checked]:bg-indigo-50 has-[:checked]:border-primary transition-colors">
                                            <input class="h-4 w-4 text-primary focus:ring-primary border-gray-300"
                                                   type="radio"
                                                   name="answers[{{ $question->id }}]"
                                                   value="{{ $option }}" required>
                                            <span class="ml-3 text-sm text-paragraph">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-paragraph">Este formulário ainda não possui perguntas.</p>
                    @endforelse

                    <div class="flex justify-end pt-8 border-t border-secondary">
                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-md font-semibold text-white hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-primary transition">
                            Enviar Respostas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
