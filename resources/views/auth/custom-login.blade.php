<x-guest-layout>
    {{-- Usando a cor 'secondary' para o fundo da página ou 'light-gray-bg' --}}
    <div class="flex flex-col items-center justify-center min-h-screen px-4 py-8 sm:pt-0 bg-secondary"> {{-- ou bg-light-gray-bg --}}
        <div class="w-full sm:max-w-md mt-6 px-6 py-10 bg-background shadow-xl rounded-2xl overflow-hidden"> {{-- Card com fundo branco --}}
            <div class="mb-8 text-center">
                <a href="/">
                    <x-application-logo class="w-24 h-24 mx-auto text-primary" /> {{-- Logo com cor primária --}}
                </a>
                <h2 class="mt-6 text-3xl font-extrabold text-center text-headline"> {{-- Título com cor headline --}}
                    Bem-vindo de volta!
                </h2>
                <p class="mt-2 text-sm text-paragraph"> {{-- Parágrafo com cor paragraph --}}
                    Faça login para acessar o sistema.
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-md bg-red-50 border border-danger text-sm text-danger"> {{-- Usando 'danger' para texto e borda de erro --}}
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.perform') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-headline mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 placeholder-gray-400 text-paragraph bg-background"
                           placeholder="seu@email.com">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-sm font-semibold text-headline">Senha</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline font-medium">
                                Esqueceu a senha?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 placeholder-gray-400 text-paragraph bg-background"
                           placeholder="Sua senha">
                </div>

                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="h-4 w-4 rounded border-gray-300 text-primary shadow-sm focus:ring-primary">
                    <label for="remember_me" class="ms-2 block text-sm text-paragraph">Lembrar de mim</label>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-button-text bg-button hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 ease-in-out">
                        Entrar
                    </button>
                </div>
            </form>

            <p class="mt-8 text-sm text-center text-paragraph">
                Não tem uma conta?
                <a href="{{ route('register') }}" class="font-medium text-primary hover:underline">
                    Cadastre-se aqui
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
