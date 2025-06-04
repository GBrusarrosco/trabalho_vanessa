<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-paragraph"> {{-- Cor de texto padrão para o corpo --}}
{{-- Fundo geral da página usando a cor da sua paleta (consistente com seu app.css) --}}
<div class="min-h-screen bg-light-gray-bg">
    @include('layouts.navigation')

    @isset($header)
        <header class="bg-background shadow"> {{-- Fundo do cabeçalho com a cor 'background' (branco) --}}
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{-- O conteúdo do $header (título) deve ser estilizado na view específica. Ex: text-headline --}}
                {{ $header }}
            </div>
        </header>
    @endisset

    <main>
        @yield('content')
    </main>
</div>
</body>
</html>
