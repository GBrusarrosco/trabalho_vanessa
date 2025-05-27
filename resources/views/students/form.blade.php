<div class="mb-3">
    <label for="name">Nome</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $student->user->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="email">E-mail</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $student->user->email ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="document">Documento</label>
    <input type="text" name="document" class="form-control" value="{{ old('document', $student->user->document ?? '') }}" required>
</div>

@if (!isset($student))
    <div class="mb-3">
        <label for="password">Senha</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password_confirmation">Confirmar Senha</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
@endif

<div class="mb-3">
    <label for="turma">Turma</label>
    <input type="text" name="turma" class="form-control" value="{{ old('turma', $student->turma ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="ano_letivo">Ano Letivo</label>
    <input type="text" name="ano_letivo" class="form-control" value="{{ old('ano_letivo', $student->ano_letivo ?? '') }}" required>
</div>
