<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-headline leading-tight">
            Novo Formulário de Avaliação
        </h2>
    </x-slot>

    {{-- Conteúdo principal da página, que será injetado no $slot do layouts.app.blade.php --}}
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('forms.store') }}" method="POST" class="p-6 sm:p-8">
                    @csrf

                    {{-- O parcial forms.form já está estilizado com Tailwind --}}
                    @include('forms.form')

                    <div class="mt-8 pt-5 border-t border-secondary">
                        <div class="flex justify-end space-x-3"> {{-- Adicionado space-x-3 para espaçamento entre botões --}}
                            <a href="{{ route('forms.index') }}"
                               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-paragraph bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-button-text uppercase tracking-widest hover:bg-opacity-90 active:bg-primary focus:outline-none focus:border-primary focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                                Salvar Formulário
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
