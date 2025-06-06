<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Responder Avaliação: {{ $form->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form method="POST" action="{{ route('forms.enviar', $form) }}" class="space-y-6">
                    @csrf

                    @foreach ($questions as $question)
                    <div class="mb-4 p-4 bg-gray-50 rounded shadow-sm">
                        <label for="question_{{ $question->id }}" class="block font-medium text-gray-700 mb-2">
                            {{ $question->question_text }}
                        </label>

                        @if ($question->type === 'texto')
                        <input type="text" name="answers[{{ $question->id }}]" id="question_{{ $question->id }}"
                            class="block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                        @elseif ($question->type === 'multipla_escolha')
                        @php $options = explode(';', $question->options ?? ''); @endphp
                        <div class="flex flex-col gap-2">
                            @foreach ($options as $option)
                            <label class="inline-flex items-center">
                                <input class="form-radio text-indigo-600 focus:ring-indigo-500" type="radio"
                                    name="answers[{{ $question->id }}]"
                                    value="{{ trim($option) }}" required>
                                <span class="ml-2 text-gray-700">{{ trim($option) }}</span>
                            </label>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            Enviar Respostas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>