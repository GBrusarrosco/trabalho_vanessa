<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            @php $user = Auth::user(); @endphp
            @if($user && $user->role === 'aluno')
                Seus Dados Cadastrais
            @else
                Gerenciamento de Alunos por Turma
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- LÓGICA EXISTENTE PARA O ALUNO VER SEU PRÓPRIO PERFIL --}}
            @if($user && $user->role === 'aluno' && isset($students))
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 text-center">
                        {{ session('success') }}
                    </div>
                @endif
                {{-- Supondo que a coleção tenha apenas um aluno, o próprio usuário --}}
                @if($students->first())
                    <x-student-card :student="$students->first()" :show-actions="true" />
                @else
                    <p class="text-center text-paragraph">Seus dados de aluno não foram encontrados.</p>
                @endif

                {{-- NOVA LÓGICA PARA ADMIN, COORDENADOR E PROFESSOR --}}
            @else
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-headline mb-4 sm:mb-0">
                        Turmas Cadastradas
                    </h1>
                    @can('manage-students')
                        <a href="{{ route('students.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-lg font-semibold text-sm text-button-text uppercase tracking-widest hover:bg-opacity-90 active:bg-primary focus:outline-none focus:border-primary-dark focus:ring ring-primary-light disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/></svg>
                            Novo Aluno
                        </a>
                    @endcan
                </div>

                @if (session('success'))
                    <div class="mb-6 p-4 rounded-md bg-green-100 border border-green-200 text-sm text-green-800 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($turmas->isEmpty())
                    <div class="text-center py-16 bg-background rounded-lg shadow-md">
                        <p class="font-semibold text-paragraph">Nenhuma turma com alunos encontrada.</p>
                        <p class="text-sm text-gray-500">Cadastre um novo aluno para começar.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($turmas as $turma)
                            <a href="{{ route('students.by_class', ['turma' => $turma->turma, 'ano_letivo' => $turma->ano_letivo]) }}"
                               class="block bg-background p-6 rounded-xl shadow-lg border border-secondary hover:shadow-2xl hover:border-primary transition-all duration-300 transform hover:-translate-y-1">
                                <h3 class="text-xl font-bold text-primary truncate">{{ $turma->turma }}</h3>
                                <p class="text-sm text-paragraph mt-1">Ano Letivo: {{ $turma->ano_letivo }}</p>
                                <div class="mt-4 pt-4 border-t border-secondary flex justify-between items-center">
                                    <span class="text-sm font-medium text-headline">Total de Alunos</span>
                                    <span class="px-3 py-1 text-sm font-bold text-button-text bg-primary rounded-full">{{ $turma->student_count }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
