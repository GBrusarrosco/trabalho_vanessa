<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-br from-pink-500 via-purple-500 to-indigo-500">
        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
            @if(session('success'))
                <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 text-center animate-fade-in">
                    🎉 {{ session('success') }} Seja bem-vindo(a) ao sistema! Agora é só fazer o login e aproveitar! 🚀
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 text-center animate-fade-in">
                    😅 Opa! Algo não deu certo...<br>
                    @foreach($errors->all() as $error)
                        <span>👉 {{ $error }}</span><br>
                    @endforeach
                    <span class="font-bold">Confira o(s) campo(s) abaixo que precisam de correção e tente novamente! 💡</span>
                </div>
            @endif
            <h2 class="text-3xl font-bold text-center text-indigo-700 dark:text-white mb-6">Cadastro</h2>
            <form id="chooseProfileForm" class="space-y-6">
                <div>
                    <label for="profile" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Quem é você?</label>
                    <select id="profile" name="profile" required class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-900 dark:text-white">
                        <option value="">Selecione...</option>
                        <option value="aluno">Aluno</option>
                        <option value="professor">Professor</option>
                        <option value="coordenador">Coordenador</option>
                    </select>
                </div>
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-200">Avançar</button>
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400">Já tem uma conta? Entrar</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('chooseProfileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const perfil = document.getElementById('profile').value;
            if (perfil === 'aluno') {
                window.location.href = "{{ route('students.create') }}";
            } else if (perfil === 'professor') {
                window.location.href = "{{ route('teachers.create') }}";
            } else if (perfil === 'coordenador') {
                window.location.href = "{{ route('coordinators.create') }}";
            }
        });
    </script>
    <style>
        .animate-fade-in {
            animation: fadeIn 0.7s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</x-guest-layout>
