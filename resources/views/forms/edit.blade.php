<x-app-layout>
    <x-slot name="header">
        {{-- ... header ... --}}
    </x-slot>

    {{-- Adicionando x-data para o modal de reprovação --}}
    <div class="py-12" x-data="{ showRejectionModal: false }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Card para o professor editar o formulário --}}
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg">
                {{-- ... (código do formulário de edição como estava) ... --}}
            </div>

            {{-- SEÇÃO DE AÇÕES PARA O COORDENADOR --}}
            @if(Auth::user()->role === 'coordenador' && $form->status === 'pendente')
                <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-headline mb-4">Ações do Coordenador</h3>
                    <div class="flex items-center justify-end space-x-3">
                        {{-- Botão para abrir o modal de reprovação --}}
                        <button type="button" @click="showRejectionModal = true" class="px-4 py-2 bg-danger text-button-text text-xs font-semibold rounded-lg hover:bg-opacity-90 shadow-sm">
                            Reprovar e Enviar para Revisão
                        </button>

                        {{-- Formulário para aprovação direta --}}
                        <form action="{{ route('forms.approve', $form) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white text-xs font-semibold rounded-lg hover:bg-green-600 shadow-sm">
                                Aprovar Formulário
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Seção de Perguntas (permanece igual) --}}
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
                {{-- ... (código da seção de perguntas) ... --}}
            </div>

        </div>

        {{-- MODAL PARA MOTIVO DA REPROVAÇÃO --}}
        <x-modal name="rejection-modal" x-show="showRejectionModal" @close="showRejectionModal = false" focusable>
            <form action="{{ route('forms.reject', $form) }}" method="POST" class="p-6">
                @csrf
                <h2 class="text-lg font-medium text-headline">
                    Reprovar Formulário
                </h2>
                <p class="mt-1 text-sm text-paragraph">
                    Por favor, descreva o motivo da reprovação para que o professor possa fazer os ajustes necessários.
                </p>
                <div class="mt-6">
                    <x-input-label for="rejection_reason" value="Motivo da Reprovação" />
                    <textarea id="rejection_reason" name="rejection_reason" rows="4" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm text-paragraph bg-background focus:border-primary focus:ring-primary" required></textarea>
                    <x-input-error :messages="$errors->get('rejection_reason')" class="mt-2" />
                </div>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button type="button" @click="$dispatch('close')">
                        Cancelar
                    </x-secondary-button>
                    <x-danger-button class="ms-3">
                        Confirmar Reprovação
                    </x-danger-button>
                </div>
            </form>
        </x-modal>

    </div>
</x-app-layout>
