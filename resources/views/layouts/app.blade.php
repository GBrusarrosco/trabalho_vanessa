<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .preloader-container {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background-color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }
        .preloader-container.hidden {
            opacity: 0;
            pointer-events: none;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #d1d1e9;
            border-top-color: #6246ea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body class="font-sans antialiased text-paragraph">

<div id="preloader" class="preloader-container">
    <div class="spinner"></div>
</div>

<div class="min-h-screen bg-light-gray-bg">
    <header class="bg-background shadow-sm sticky top-0 z-40">
        @include('layouts.navigation')

        @isset($header)
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        @endisset
    </header>

    <main class="transition-all duration-700 ease-in-out"
          x-data="{ showContent: false }"
          x-init="
              showContent = false;
              const initAnimation = () => {
                  showContent = false;
                  requestAnimationFrame(() => {
                      setTimeout(() => { showContent = true; }, 50);
                  });
              };
              initAnimation();
              window.addEventListener('pageshow', function(event) {
                  if (event.persisted) { initAnimation(); }
              });
          "
          :class="{ 'opacity-100 translate-y-0': showContent, 'opacity-0 translate-y-5': !showContent }">
        {{ $slot }}
    </main>
</div>

<script>
    window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.classList.add('hidden');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    });
</script>

</body>
</html>
