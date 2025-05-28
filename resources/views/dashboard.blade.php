<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-indigo-700 dark:text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="text-gray-900 dark:text-gray-100 text-xl font-semibold mb-4">
                    @if(Auth::user()->perfil == 'aluno')
                        Bem-vindo, <span class="text-indigo-600 dark:text-indigo-400">Aluno</span>!
                        <p class="mt-2 text-base font-normal">Aqui você pode visualizar suas atividades, formulários e informações acadêmicas enviadas pelos professores. Você pode gerenciar apenas seus próprios dados.</p>
                    @elseif(Auth::user()->perfil == 'professor')
                        Bem-vindo, <span class="text-pink-600 dark:text-pink-400">Professor</span>!
                        <p class="mt-2 text-base font-normal">Aqui você pode cadastrar avaliações, lançar informações, gerenciar seus alunos e também gerenciar seus próprios dados. Suas informações serão posteriormente confirmadas pelo coordenador.</p>
                    @elseif(Auth::user()->perfil == 'coordenador')
                        Bem-vindo, <span class="text-purple-600 dark:text-purple-400">Coordenador</span>!
                        <p class="mt-2 text-base font-normal">Aqui você pode visualizar e confirmar as informações enviadas pelos professores, gerenciar os professores do seu curso e também gerenciar seus próprios dados.</p>
                    @else
                        Bem-vindo!
                        <p class="mt-2 text-base font-normal">Seu perfil não foi identificado. Entre em contato com o suporte.</p>
                    @endif
                </div>
                <div class="mt-8 flex flex-col md:flex-row gap-6">
                    <div class="flex-1 bg-indigo-100 dark:bg-indigo-900 rounded-lg p-6 shadow text-center">
                        <h3 class="text-lg font-bold text-indigo-700 dark:text-indigo-300 mb-2">Notificações</h3>
                        <p class="text-gray-700 dark:text-gray-200">Nenhuma notificação no momento.</p>
                    </div>
                    <div class="flex-1 bg-pink-100 dark:bg-pink-900 rounded-lg p-6 shadow text-center">
                        <h3 class="text-lg font-bold text-pink-700 dark:text-pink-300 mb-2">Atividades Recentes</h3>
                        <p class="text-gray-700 dark:text-gray-200">Você está atualizado!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>