@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">📊 Relatório de Respostas dos Alunos</h1>

        @foreach($forms as $form)
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Formulário:</strong> {{ $form->title }}
                </div>
                <div class="card-body">
                    <p><strong>Descrição:</strong> {{ $form->description ?? 'Sem descrição.' }}</p>

                    @foreach($form->questions as $question)
                        <div class="mb-3">
                            <h5 class="mb-2">📝 Pergunta: {{ $question->question_text }}</h5>

                            @if($question->answers->isEmpty())
                                <p><em>Nenhuma resposta recebida.</em></p>
                            @else
                                <ul class="list-group">
                                    @foreach($question->answers as $answer)
                                        <li class="list-group-item">
                                            <strong>{{ $answer->student->user->name }}:</strong>
                                            {{ $answer->answer_text }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
