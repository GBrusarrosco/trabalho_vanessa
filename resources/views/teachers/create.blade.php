<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Cadastrar Novo Professor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('teachers.store') }}" method="POST" class="p-6 sm:p-8">
                    @csrf

                    @include('teachers.form')

                    <div class="mt-8 pt-6 border-t border-secondary">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('teachers.index') }}"
                               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-paragraph bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Cancelar
                            </a>
                            <x-primary-button>
                                Salvar Professor
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
