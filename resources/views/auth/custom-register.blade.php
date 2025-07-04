<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Cadastro</title>
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
    <div class="hidden lg:flex w-1/2 items-center justify-center gradient-bg p-12 text-white text-center relative">
        <div data-aos="fade-right" data-aos-duration="1000">
            <h1 class="text-4xl font-bold tracking-tight">Junte-se à Nossa Plataforma</h1>
            <p class="mt-4 text-lg text-indigo-100">Crie sua conta para começar a participar das avaliações e contribuir para a melhoria contínua.</p>
        </div>
    </div>
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:py-12 sm:px-12">
        <div class="w-full max-w-md">
            <div class="text-center lg:text-left mb-8" data-aos="fade-down">
                <h2 class="text-3xl font-bold text-headline">Crie sua Conta</h2>
                <p class="mt-2 text-sm text-paragraph">Preencha os campos abaixo para começar.</p>
            </div>
            @if ($errors->any())
                <div class="mb-4 p-4 rounded-md bg-red-50 border border-danger text-sm text-danger">
                    <p class="font-semibold mb-1">Por favor, corrija os erros abaixo:</p>
                    <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            <form method="POST" action="{{ route('register.perform') }}" class="space-y-4">
                @csrf
                <div><label for="name" class="block text-sm font-semibold text-headline mb-1">Nome Completo</label><input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="Seu nome completo"></div>
                <div><label for="email" class="block text-sm font-semibold text-headline mb-1">Email</label><input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="seu@email.com"></div>
                <div>
                    <label for="document" class="block text-sm font-semibold text-headline mb-1">Documento (CPF)</label>
                    <input id="document" type="text" name="document" value="{{ old('document') }}" required class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="___.___.___-__" x-data="{ formatCpf(value) { let onlyNumbers = value.replace(/\D/g, '').substring(0, 11); return onlyNumbers.replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2'); } }" @input="$event.target.value = formatCpf($event.target.value)">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div><label for="password" class="block text-sm font-semibold text-headline mb-1">Senha</label><input id="password" type="password" name="password" required autocomplete="new-password" class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="Mínimo 6 caracteres"></div>
                    <div><label for="password_confirmation" class="block text-sm font-semibold text-headline mb-1">Confirmar Senha</label><input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="Repita a senha"></div>
                </div>
                <div>
                    <label for="type" class="block text-sm font-semibold text-headline mb-1">Eu sou um(a):</label>
                    <select id="type" name="type" required class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 bg-white" onchange="toggleProfileFields()">
                        <option value="">Selecione seu perfil...</option>
                        <option value="aluno" {{ old('type') === 'aluno' ? 'selected' : '' }}>Aluno</option>
                    </select>
                </div>
                <div id="student_fields" class="space-y-4" style="{{ old('type') === 'aluno' ? '' : 'display:none;' }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label for="turma" class="block text-sm font-semibold text-headline mb-1">Turma</label><input id="turma" type="text" name="turma" value="{{ old('turma') }}" class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="Ex: 3º Ano A"></div>
                        <div><label for="ano_letivo" class="block text-sm font-semibold text-headline mb-1">Ano Letivo</label><input id="ano_letivo" type="text" name="ano_letivo" value="{{ old('ano_letivo') }}" class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="Ex: 2025"></div>
                    </div>
                </div>
                <div class="pt-4"><button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-button-text bg-button hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 ease-in-out">Cadastrar</button></div>
            </form>
            <p class="mt-8 text-sm text-center text-paragraph">Já tem uma conta? <a href="{{ route('login') }}" class="font-medium text-primary hover:underline">Faça login</a></p>
        </div>
    </div>
</div>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
    function toggleProfileFields() {
        var type = document.getElementById('type').value;
        var studentFields = document.getElementById('student_fields');
        var turmaInput = document.getElementById('turma');
        var anoLetivoInput = document.getElementById('ano_letivo');
        studentFields.style.display = 'none';
        if (turmaInput) turmaInput.required = false;
        if (anoLetivoInput) anoLetivoInput.required = false;
        if (type === 'aluno') {
            studentFields.style.display = 'block';
            if (turmaInput) turmaInput.required = true;
            if (anoLetivoInput) anoLetivoInput.required = true;
        }
    }
    document.addEventListener('DOMContentLoaded', function() { toggleProfileFields(); });
    window.addEventListener('pageshow', function(event) { if (event.persisted) { toggleProfileFields(); } });
</script>
</body>
</html>
