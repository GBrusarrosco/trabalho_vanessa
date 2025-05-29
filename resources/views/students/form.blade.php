<div class="mb-4">
    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
    <input type="text" name="name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" value="{{ old('name', $student->user->name ?? '') }}" required>
</div>

<div class="mb-4">
    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
    <input type="email" name="email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" value="{{ old('email', $student->user->email ?? '') }}" required>
</div>

<div class="mb-4">
    <label for="document" class="block text-sm font-medium text-gray-700 mb-1">Documento</label>
    <input type="text" name="document" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" value="{{ old('document', $student->user->document ?? '') }}" required>
</div>

@if (!isset($student))
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
        <input type="password" name="password" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required>
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Senha</label>
        <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required>
    </div>
@endif

<div class="mb-4">
    <label for="turma" class="block text-sm font-medium text-gray-700 mb-1">Turma</label>
    <input type="text" name="turma" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" value="{{ old('turma', $student->turma ?? '') }}" required>
</div>

<div class="mb-4">
    <label for="ano_letivo" class="block text-sm font-medium text-gray-700 mb-1">Ano Letivo</label>
    <input type="text" name="ano_letivo" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" value="{{ old('ano_letivo', $student->ano_letivo ?? '') }}" required>
</div>
