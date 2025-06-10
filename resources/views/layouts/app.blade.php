<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- ADICIONE ESTA LINHA PARA O CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-paragraph">
<div class="min-h-screen bg-light-gray-bg">
    @include('layouts.navigation')

    @isset($header)
        <header class="bg-background shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main x-data="{ showContent: false }"
          x-init="
          showContent = false; // Reseta no início
          const initAnimation = () => {
              showContent = false;
              requestAnimationFrame(() => {
                  setTimeout(() => {
                      showContent = true;
                  }, 50);
              });
          };
          initAnimation(); // Executa na carga inicial

          // Para Turbo (se estiver usando) - descomente se necessário
          // document.addEventListener('turbo:load', initAnimation);

          // Para bfcache (navegação de voltar/avançar do navegador)
          window.addEventListener('pageshow', function(event) {
              if (event.persisted) {
                  initAnimation();
              }
          });
      "
          class="transition-all duration-700 ease-in-out" {{-- Sua duração e easing --}}
          :class="{ 'opacity-100 translate-y-0': showContent, 'opacity-0 translate-y-5': !showContent }"> {{-- Seu translate --}}
        {{ $slot }}
    </main>
</div>
</body>
</html>
