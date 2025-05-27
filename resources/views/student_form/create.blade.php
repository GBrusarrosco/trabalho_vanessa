@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nova Associação</h1>

        <form method="POST" action="{{ route('student-form.store') }}">
            @csrf

            <div class="mb-3">
                <label for="student_id">Aluno</label>
                <select name="student_id" class="form-control" required>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">
                            {{ $student->user->name }} ({{ $student->turma }} - {{ $student->ano_letivo }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="form_id">Formulário</label>
                <select name="form_id" class="form-control" required>
                    @foreach ($forms as $form)
                        <option value="{{ $form->id }}">{{ $form->title }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Associação</button>
        </form>
    </div>
@endsection
