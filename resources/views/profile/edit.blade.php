<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-headline leading-tight"> {{-- Alterado para text-headline --}}
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Card para Informações do Perfil --}}
            <div class="p-4 sm:p-8 bg-background shadow sm:rounded-lg"> {{-- Alterado para bg-background --}}
                <div class="max-w-xl">
                    {{-- Os parciais inclusos aqui (update-profile-information-form, etc.) --}}
                    {{-- também precisarão ter seus textos, labels, inputs e botões ajustados --}}
                    {{-- para usar as cores da paleta (text-headline, text-paragraph, bg-primary, etc.) --}}
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Card para Atualizar Senha --}}
            <div class="p-4 sm:p-8 bg-background shadow sm:rounded-lg"> {{-- Alterado para bg-background --}}
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Card para Deletar Conta --}}
            <div class="p-4 sm:p-8 bg-background shadow sm:rounded-lg"> {{-- Alterado para bg-background --}}
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
