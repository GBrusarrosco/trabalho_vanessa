<div class="mb-3">
    <label for="name">Nome</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $coordinator->user->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="email">E-mail</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $coordinator->user->email ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="document">Documento</label>
    <input type="text" name="document" class="form-control" value="{{ old('document', $coordinator->user->document ?? '') }}" required>
</div>

@if (!isset($coordinator))
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
    <label for="departamento">Departamento</label>
    <input type="text" name="departamento" class="form-control" value="{{ old('departamento', $coordinator->departamento ?? '') }}" required>
</div>
