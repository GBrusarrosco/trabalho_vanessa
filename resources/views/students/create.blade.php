<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Novo Aluno
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg">
                <form method="POST" action="{{ route('students.store') }}" class="p-8 space-y-6">
                    @csrf
                    @include('students.form', [
                        'student' => new \App\Models\Student,
                        'turma' => $turma ?? null,
                        'ano_letivo' => $ano_letivo ?? null
                    ])
                    <div class="mt-8 pt-5 border-t border-secondary flex justify-end">
                        {{-- CÓDIGO ALTERADO AQUI --}}
                        <a href="{{ url()->previous() }}"
                           class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-paragraph bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary mr-3">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-button-text uppercase tracking-widest hover:bg-opacity-90 active:bg-primary focus:outline-none focus:border-primary focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
