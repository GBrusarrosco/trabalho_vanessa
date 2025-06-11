<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Cadastrar Novo Coordenador
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('coordinators.store') }}" method="POST" class="p-6 sm:p-8">
                    @csrf
                    @include('coordinators.form')
                    <div class="mt-8 pt-6 border-t border-secondary flex justify-end space-x-3">
                        <a href="{{ route('coordinators.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            Cancelar
                        </a>
                        <x-primary-button>
                            Salvar Coordenador
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
