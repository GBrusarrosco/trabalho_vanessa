@props(['student', 'showActions' => false])
<div class="bg-background rounded-xl shadow-lg p-6 border border-secondary flex flex-col gap-2">
    <div>
        <span class="block text-sm font-semibold text-gray-500">Nome:</span>
        <span class="block text-lg text-headline">{{ $student->user->name }}</span>
    </div>
    <div>
        <span class="block text-sm font-semibold text-gray-500">E-mail:</span>
        <span class="block text-lg text-headline">{{ $student->user->email }}</span>
    </div>
    <div>
        <span class="block text-sm font-semibold text-gray-500">Documento:</span>
        <span class="block text-lg text-headline">{{ $student->user->document }}</span>
    </div>
    <div>
        <span class="block text-sm font-semibold text-gray-500">Turma:</span>
        <span class="block text-lg text-headline">{{ $student->turma }}</span>
    </div>
    <div>
        <span class="block text-sm font-semibold text-gray-500">Ano Letivo:</span>
        <span class="block text-lg text-headline">{{ $student->ano_letivo }}</span>
    </div>
    <div>
        <span class="block text-sm font-semibold text-gray-500">Cadastrado em:</span>
        <span class="block text-lg text-headline">{{ $student->created_at ? $student->created_at->format('d/m/Y') : '-' }}</span>
    </div>
    @if($showActions)
        <div class="flex flex-col gap-2 mt-4">
            <a href="{{ route('students.edit', $student) }}" class="px-4 py-2 bg-primary text-button-text text-sm font-medium rounded-md hover:bg-opacity-90 transition-colors duration-150 text-center">Editar Dados</a>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors duration-150 text-center">Ver Avaliações</a>
            <a href="{{ route('students.mini-report', $student) }}" class="px-4 py-2 bg-secondary text-paragraph text-sm font-medium rounded-md hover:bg-secondary/80 transition-colors duration-150 text-center">Ver Histórico</a>
        </div>
    @endif
</div>
