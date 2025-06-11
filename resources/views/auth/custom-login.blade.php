<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-bg {
            background: linear-gradient(-45deg, #6246ea, #7f5af0, #2b2c34, #16161a);
            background-size: 400% 400%;
            animation: gradient-animation 15s ease infinite;
        }
        @keyframes gradient-animation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="font-sans text-paragraph antialiased">
<div class="min-h-screen flex bg-gray-50">

    <div class="hidden lg:flex w-1/2 items-center justify-center gradient-bg p-12 text-white text-center relative overflow-hidden">
        <div data-aos="fade-right" data-aos-duration="1000">
            <h1 class="text-4xl font-bold tracking-tight">Sistema de Avaliação Institucional</h1>
            <p class="mt-4 text-lg text-indigo-100">Sua plataforma completa para avaliações, relatórios e desenvolvimento contínuo.</p>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-md">
            <div class="text-center lg:text-left mb-10" data-aos="fade-down">
                <h2 class="text-3xl font-bold text-headline">Bem-vindo de volta!</h2>
                <p class="mt-2 text-sm text-paragraph">Faça login para continuar.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />
            @if ($errors->any())
                <div class="mb-4 p-4 rounded-md bg-red-50 border border-danger text-sm text-danger">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.perform') }}" class="space-y-6">
                @csrf
                <div data-aos="fade-up" data-aos-delay="100">
                    <label for="email" class="block text-sm font-semibold text-headline mb-1">Email</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M3 4a2 2 0 012-2h10a2 2 0 012 2v1.158a.75.75 0 01-.12.42l-2.072 3.313a.75.75 0 01-1.11 0L12.5 6.42a.75.75 0 00-1.11 0L10.28 7.74a.75.75 0 01-1.11 0L8.06 5.869a.75.75 0 00-1.11 0L4.12 8.869a.75.75 0 01-1.11 0L.88 5.578A.75.75 0 01.76 5.158V4zM3.5 8.138l.21-.337a.75.75 0 011.11 0l1.11 1.776a.75.75 0 001.11 0l1.11-1.776a.75.75 0 011.11 0l1.11 1.776a.75.75 0 001.11 0l1.11-1.776a.75.75 0 011.11 0l1.468 2.348a.75.75 0 01-.555 1.182H3.5a.75.75 0 01-.555-1.182L3.5 8.138zM2 12a1 1 0 011-1h14a1 1 0 110 2H3a1 1 0 01-1-1zm1 3a1 1 0 100 2h12a1 1 0 100-2H3z" clip-rule="evenodd" /></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="block w-full rounded-lg border-gray-300 py-3 ps-10 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-paragraph" placeholder="seu@email.com">
                    </div>
                </div>
                <div data-aos="fade-up" data-aos-delay="200">
                    <label for="password" class="block text-sm font-semibold text-headline mb-1">Senha</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" /></svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full rounded-lg border-gray-300 py-3 ps-10 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-paragraph" placeholder="Sua senha">
                    </div>
                </div>
                <div class="flex items-center justify-between" data-aos="fade-up" data-aos-delay="300">
                    <label for="remember_me" class="flex items-center"><input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"><span class="ms-2 block text-sm text-paragraph">Lembrar de mim</span></label>
                    @if (Route::has('password.request'))<a href="{{ route('password.request') }}" class="text-sm font-medium text-primary hover:underline">Esqueceu a senha?</a>@endif
                </div>
                <div data-aos="fade-up" data-aos-delay="400">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-button-text bg-button hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 ease-in-out">Entrar</button>
                </div>
            </form>
            <p class="mt-8 text-sm text-center text-paragraph" data-aos="fade-up" data-aos-delay="500">
                Não tem uma conta? <a href="{{ route('register') }}" class="font-medium text-primary hover:underline">Cadastre-se aqui</a>
            </p>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>
