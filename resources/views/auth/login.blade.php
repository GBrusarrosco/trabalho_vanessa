<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
            <h2 class="text-3xl font-bold text-center text-indigo-700 dark:text-white mb-6">Bem-vindo de volta!</h2>
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">E-mail</label>
                    <input id="email" name="email" type="email" autocomplete="username" required autofocus class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-900 dark:text-white" value="{{ old('email') }}">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Senha</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-900 dark:text-white">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-900">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Lembrar de mim</span>
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline dark:text-indigo-400">Esqueceu a senha?</a>
                    @endif
                </div>
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-200">Entrar</button>
                <div class="text-center mt-4">
                    <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400">Não tem uma conta? Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>