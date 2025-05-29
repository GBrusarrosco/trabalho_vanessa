<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-indigo-700 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12 bg-gradient-to-br from-white via-blue-100 to-indigo-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="text-gray-900 text-xl font-semibold mb-4">
                    @php $user = $user ?? Auth::user(); @endphp
                    @if($user->hasRole('aluno'))
                    Bem-vindo, <span class="text-indigo-600">Aluno</span>!
                    <p class="mt-2 text-base font-normal">Aqui você pode visualizar suas atividades, formulários e informações acadêmicas enviadas pelos professores. Você pode gerenciar apenas seus próprios dados.</p>
                    @elseif($user->hasRole('professor'))
                    Bem-vindo, <span class="text-pink-600">Professor</span>!
                    <p class="mt-2 text-base font-normal">Aqui você pode cadastrar avaliações, lançar informações, gerenciar seus alunos e também gerenciar seus próprios dados. Suas informações serão posteriormente confirmadas pelo coordenador.</p>
                    @elseif($user->hasRole('coordenador'))
                    Bem-vindo, <span class="text-purple-600">Coordenador</span>!
                    <p class="mt-2 text-base font-normal">Aqui você pode visualizar e confirmar as informações enviadas pelos professores, gerenciar os professores do seu curso e também gerenciar seus próprios dados.</p>
                    @else
                    Bem-vindo!
                    <p class="mt-2 text-base font-normal">Seu perfil não foi identificado. Entre em contato com o suporte.</p>
                    @endif
                </div>
                <div class="mt-8 flex flex-col md:flex-row gap-6">
                    <div class="flex-1 bg-blue-50 rounded-lg p-6 shadow text-center">
                        <h3 class="text-lg font-bold text-indigo-700 mb-2">Notificações</h3>
                        <p class="text-gray-700">Nenhuma notificação no momento.</p>
                    </div>
                    <div class="flex-1 bg-pink-50 rounded-lg p-6 shadow text-center">
                        <h3 class="text-lg font-bold text-pink-700 mb-2">Atividades Recentes</h3>
                        <p class="text-gray-700">Você está atualizado!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>