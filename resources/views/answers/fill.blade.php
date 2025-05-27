@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Responder Formulário: {{ $form->title }}</h1>

        <form method="POST" action="{{ route('forms.enviar', $form) }}">
            @csrf

            @foreach ($questions as $question)
                <div class="mb-3">
                    <label for="question_{{ $question->id }}">{{ $question->question_text }}</label>

                    @if ($question->type === 'texto')
                        <input type="text" name="answers[{{ $question->id }}]" class="form-control" required>
                    @elseif ($question->type === 'multipla_escolha')
                        @php
                            $options = explode(';', $question->options ?? '');
                        @endphp
                        @foreach ($options as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="answers[{{ $question->id }}]"
                                       value="{{ trim($option) }}" required>
                                <label class="form-check-label">{{ trim($option) }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach

            <button type="submit" class="btn btn-success">Enviar Respostas</button>
        </form>
    </div>
@endsection
