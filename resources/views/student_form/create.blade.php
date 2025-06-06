<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Nova Associação Aluno x Formulário
        </h2>
    </x-slot>

    @php $user = Auth::user(); @endphp
    @if(!$user || !in_array($user->role, ['admin', 'coordenador']))
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">
                <h3 class="text-xl font-semibold text-headline mb-2">Acesso restrito</h3>
                <p class="text-paragraph">Você não tem permissão para visualizar esta página.</p>
            </div>
        </div>
    </div>
    @else
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-8">
                <form method="POST" action="{{ route('student-form.store') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="student_id" class="block text-sm font-semibold text-headline mb-1">Aluno</label>
                        <select name="student_id" id="student_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required>
                            @foreach ($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->user->name }} ({{ $student->turma }} - {{ $student->ano_letivo }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="form_id" class="block text-sm font-semibold text-headline mb-1">Formulário</label>
                        <select name="form_id" id="form_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required>
                            @foreach ($forms as $form)
                            <option value="{{ $form->id }}">{{ $form->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <a href="{{ route('student-form.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-paragraph bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary mr-3">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">Salvar Associação</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>