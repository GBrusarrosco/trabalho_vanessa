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

            {{-- Lógica para o Aluno ver seu próprio perfil --}}
            @if($user && $user->role === 'aluno')
                @if(isset($students) && $students->first())
                    <x-student-card :student="$students->first()" :show-actions="true" />
                @else
                    <p class="text-center text-paragraph">Seus dados de aluno não foram encontrados.</p>
                @endif

                {{-- Lógica para Admin, Coordenador e Professor --}}
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

                <div class="bg-background shadow-xl sm:rounded-lg p-6 space-y-4" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 50)">
                    @forelse ($turmas as $turma)
                        {{-- NOVO LAYOUT DE LISTA VERTICAL --}}
                        <a href="{{ route('students.by_class', ['turma' => $turma->turma, 'ano_letivo' => $turma->ano_letivo]) }}"
                           class="flex items-center justify-between p-4 rounded-lg border border-secondary hover:shadow-lg hover:border-primary transition-all duration-300 transform hover:scale-[1.01]"
                           :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }"
                           :style="'transition-delay: {{ $loop->index * 75 }}ms'">

                            {{-- Lado Esquerdo: Nome e Ano --}}
                            <div>
                                <h3 class="text-lg font-bold text-primary">{{ $turma->turma }}</h3>
                                <p class="text-sm text-paragraph">Ano Letivo: {{ $turma->ano_letivo }}</p>
                            </div>

                            {{-- Lado Direito: Contagem de Alunos --}}
                            <div class="flex items-center space-x-3">
                                <span class="text-sm font-medium text-headline">Total de Alunos</span>
                                <span class="flex items-center justify-center h-8 w-8 text-sm font-bold text-button-text bg-primary rounded-full">{{ $turma->student_count }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-16">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                            <h3 class="mt-2 text-sm font-semibold text-headline">Nenhuma Turma Encontrada</h3>
                            <p class="mt-1 text-sm text-gray-500">Cadastre um novo aluno para que a primeira turma seja criada.</p>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
