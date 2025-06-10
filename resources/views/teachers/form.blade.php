<div class="space-y-6">
    {{-- Campo Nome --}}
    <div>
        <x-input-label for="name" value="Nome Completo" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $teacher->user->name ?? '')" required autofocus autocomplete="name" placeholder="Nome completo do professor" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    {{-- Campo E-mail --}}
    <div>
        <x-input-label for="email" value="E-mail" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $teacher->user->email ?? '')" required autocomplete="username" placeholder="email@dominio.com" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    {{-- Campo Documento --}}
    <div>
        <x-input-label for="document" value="Documento (CPF)" />
        <x-text-input
            id="document"
            name="document"
            type="text"
            class="mt-1 block w-full"
            :value="old('document', $teacher->user->document ?? '')"
            required
            placeholder="___.___.___-__"
            x-data="{
            formatCpf(value) {
                // Remove tudo que não for dígito
                let onlyNumbers = value.replace(/\D/g, '');

                // Limita a 11 dígitos
                onlyNumbers = onlyNumbers.substring(0, 11);

                // Aplica a formatação do CPF
                return onlyNumbers
                    .replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            }
        }"
            @input="$event.target.value = formatCpf($event.target.value)"
        />
        <x-input-error :messages="$errors->get('document')" class="mt-2" />
    </div>

    {{-- Mostra campos de senha apenas no formulário de criação --}}
    @if (!isset($teacher))
        <div>
            <x-input-label for="password" value="Senha" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" placeholder="Mínimo de 6 caracteres" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirmar Senha" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" placeholder="Repita a senha" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
    @endif

    {{-- Campo Área --}}
    <div>
        <x-input-label for="area" value="Área de Atuação" />
        <x-text-input id="area" name="area" type="text" class="mt-1 block w-full" :value="old('area', $teacher->area ?? '')" required placeholder="Ex: Matemática, História" />
        <x-input-error :messages="$errors->get('area')" class="mt-2" />
    </div>

    {{-- Campo Observações --}}
    <div>
        <x-input-label for="observacoes" value="Observações (Opcional)" />
        <textarea id="observacoes" name="observacoes" rows="4" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm text-paragraph bg-background focus:border-primary focus:ring-primary">{{ old('observacoes', $teacher->observacoes ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('observacoes')" class="mt-2" />
    </div>
</div>
