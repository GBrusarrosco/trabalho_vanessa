<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-headline leading-tight">
            {{ __('Dashboard') }} - Teste Simples
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8 mb-6">
                <h1 class="text-2xl text-headline">Teste de Conteúdo do Dashboard</h1>

                @if(isset($user))
                    <p class="text-paragraph mt-4">Usuário: {{ $user->name }}</p>
                    <p class="text-paragraph">Papel: {{ $user->role }}</p>
                @else
                    <p class="text-danger">Variável $user não definida!</p>
                @endif

                @if(isset($stats))
                    <p class="text-paragraph mt-2">Stats: Existem</p>
                    <pre class="bg-gray-100 p-2 rounded text-xs">{{ print_r($stats, true) }}</pre>
                @else
                    <p class="text-danger mt-2">Variável $stats NÃO definida!</p>
                @endif

                @if(isset($recentItems))
                    <p class="text-paragraph mt-2">RecentItems: Existem</p>
                    <pre class="bg-gray-100 p-2 rounded text-xs">{{ print_r($recentItems, true) }}</pre>
                @else
                    <p class="text-danger mt-2">Variável $recentItems NÃO definida!</p>
                @endif

                <p class="mt-4 text-paragraph">Se você vê isso, a view está renderizando este conteúdo.</p>
            </div>
        </div>
    </div>
</x-app-layout>
