<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen py-8 sm:pt-0 bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100">
        <div class="w-full sm:max-w-2xl mt-6 px-6 py-10 bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="mb-8 text-center">
                <a href="/">
                    {{-- Logo da Aplicação --}}
                    <x-application-logo class="w-24 h-24 mx-auto text-indigo-600" />
                </a>
                <h2 class="mt-6 text-3xl font-extrabold text-center text-indigo-700">
                    Crie sua Conta
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Preencha os campos abaixo para começar.
                </p>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 rounded-md bg-green-100 border border-green-300 text-sm text-green-700 text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-md bg-red-50 border border-red-300 text-sm text-red-700">
                    <p class="font-semibold mb-1">Por favor, corrija os erros abaixo:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.perform') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nome Completo</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                           class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 placeholder-gray-400 text-gray-800 @error('name') border-red-500 @enderror"
                           placeholder="Seu nome completo">
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                           class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 placeholder-gray-400 text-gray-800 @error('email') border-red-500 @enderror"
                           placeholder="seu@email.com">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="document" class="block text-sm font-semibold text-gray-700 mb-1">Documento (CPF/Matrícula)</label>
                    <input id="document" type="text" name="document" value="{{ old('document') }}" required
                           class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 placeholder-gray-400 text-gray-800 @error('document') border-red-500 @enderror"
                           placeholder="Seu documento">
                    @error('document')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Senha</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 placeholder-gray-400 text-gray-800 @error('password') border-red-500 @enderror"
                           placeholder="Mínimo 6 caracteres">
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar Senha</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 placeholder-gray-400 text-gray-800"
                           placeholder="Repita a senha">
                    {{-- Erro para password_confirmation é geralmente tratado pelo erro de 'password' se a confirmação falhar --}}
                </div>

                <div>
                    <label for="type" class="block text-sm font-semibold text-gray-700 mb-1">Eu sou um(a):</label>
                    <select id="type" name="type" required
                            class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 text-gray-800 bg-white @error('type') border-red-500 @enderror"
                            onchange="toggleProfileFields()">
                        <option value="">Selecione seu perfil...</option>
                        <option value="aluno" {{ old('type') === 'aluno' ? 'selected' : '' }}>Aluno</option>
                        <option value="professor" {{ old('type') === 'professor' ? 'selected' : '' }}>Professor</option>
                        <option value="coordenador" {{ old('type') === 'coordenador' ? 'selected' : '' }}>Coordenador</option>
                    </select>
                    @error('type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="student_fields" class="space-y-4" style="{{ old('type') === 'aluno' ? '' : 'display:none;' }}">
                    <div>
                        <label for="turma" class="block text-sm font-semibold text-gray-700 mb-1">Turma</label>
                        <input id="turma" type="text" name="turma" value="{{ old('turma') }}"
                               class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 placeholder-gray-400 text-gray-800 @error('turma') border-red-500 @enderror"
                               placeholder="Ex: 3º Ano A">
                        @error('turma')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="ano_letivo" class="block text-sm font-semibold text-gray-700 mb-1">Ano Letivo</label>
                        <input id="ano_letivo" type="text" name="ano_letivo" value="{{ old('ano_letivo') }}"
                               class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 placeholder-gray-400 text-gray-800 @error('ano_letivo') border-red-500 @enderror"
                               placeholder="Ex: 2024">
                        @error('ano_letivo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div id="teacher_fields" class="space-y-4" style="{{ old('type') === 'professor' ? '' : 'display:none;' }}">
                    <div>
                        <label for="area" class="block text-sm font-semibold text-gray-700 mb-1">Área de Atuação</label>
                        <input id="area" type="text" name="area" value="{{ old('area') }}"
                               class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 placeholder-gray-400 text-gray-800 @error('area') border-red-500 @enderror"
                               placeholder="Ex: Matemática, Português">
                        @error('area')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="observacoes" class="block text-sm font-semibold text-gray-700 mb-1">Observações (Opcional)</label>
                        <textarea id="observacoes" name="observacoes" rows="3"
                                  class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 placeholder-gray-400 text-gray-800 @error('observacoes') border-red-500 @enderror"
                                  placeholder="Alguma observação adicional?">{{ old('observacoes') }}</textarea>
                        @error('observacoes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div id="coordinator_fields" class="space-y-4" style="{{ old('type') === 'coordenador' ? '' : 'display:none;' }}">
                    <div>
                        <label for="departamento" class="block text-sm font-semibold text-gray-700 mb-1">Departamento</label>
                        <input id="departamento" type="text" name="departamento" value="{{ old('departamento') }}"
                               class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 placeholder-gray-400 text-gray-800 @error('departamento') border-red-500 @enderror"
                               placeholder="Seu departamento">
                        @error('departamento')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Cadastrar
                    </button>
                </div>
            </form>

            <p class="mt-8 text-sm text-center text-gray-600">
                Já tem uma conta?
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 hover:underline">
                    Faça login
                </a>
            </p>
        </div>
    </div>

    <script>
        function toggleProfileFields() {
            var type = document.getElementById('type').value;

            var studentFields = document.getElementById('student_fields');
            var turmaInput = document.getElementById('turma');
            var anoLetivoInput = document.getElementById('ano_letivo');

            var teacherFields = document.getElementById('teacher_fields');
            var areaInput = document.getElementById('area');

            var coordinatorFields = document.getElementById('coordinator_fields');
            var departamentoInput = document.getElementById('departamento');

            // Primeiro, oculta todos e remove 'required'
            studentFields.style.display = 'none';
            if (turmaInput) turmaInput.required = false;
            if (anoLetivoInput) anoLetivoInput.required = false;

            teacherFields.style.display = 'none';
            if (areaInput) areaInput.required = false;

            coordinatorFields.style.display = 'none';
            if (departamentoInput) departamentoInput.required = false;

            // Depois, mostra e torna obrigatório conforme o tipo
            if (type === 'aluno') {
                studentFields.style.display = 'block';
                if (turmaInput) turmaInput.required = true;
                if (anoLetivoInput) anoLetivoInput.required = true;
            } else if (type === 'professor') {
                teacherFields.style.display = 'block';
                if (areaInput) areaInput.required = true;
            } else if (type === 'coordenador') {
                coordinatorFields.style.display = 'block';
                if (departamentoInput) departamentoInput.required = true;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleProfileFields();
            // Adiciona um listener para o evento 'pageshow' para reavaliar os campos
            // caso o usuário volte para a página usando o botão "Voltar" do navegador
            // e o formulário retenha os valores 'old'.
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) { // Verifica se a página foi carregada do bfcache
                    toggleProfileFields();
                }
            });
        });
    </script>
</x-guest-layout>
