<div class="mb-3">
    <label for="name">Nome</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->user->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="email">E-mail</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->user->email ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="document">Documento</label>
    <input type="text" name="document" class="form-control" value="{{ old('document', $teacher->user->document ?? '') }}" required>
</div>

@if (!isset($teacher))
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
    <label for="area">Área</label>
    <input type="text" name="area" class="form-control" value="{{ old('area', $teacher->area ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="observacoes">Observações</label>
    <textarea name="observacoes" class="form-control">{{ old('observacoes', $teacher->observacoes ?? '') }}</textarea>
</div>
