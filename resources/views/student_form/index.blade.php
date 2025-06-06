<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Associações de Alunos a Formulários
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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-headline">Associações</h3>
                    <a href="{{ route('student-form.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                        Nova Associação
                    </a>
                </div>

                @if (session('success'))
                <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 text-center animate-fade-in">
                    {{ session('success') }}
                </div>
                @endif

                <div class="overflow-x-auto rounded-lg shadow">
                    <table class="min-w-full bg-white divide-y divide-gray-200">
                        <thead class="bg-indigo-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Aluno</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Formulário</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($associacoes as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->student_id }}</td>
                                <td class="px-4 py-2">{{ $item->form_title }}</td>
                                <td class="px-4 py-2">
                                    <form action="{{ route('student-form.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Remover associação?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded shadow text-xs font-semibold transition">Remover</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>