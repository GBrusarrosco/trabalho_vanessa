<div class="space-y-6" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 50)">

    {{-- Campo Nome --}}
    <div class="transition-all duration-300 ease-out" :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }">
        <x-input-label for="name" value="Nome Completo" class="!text-sm !font-semibold !text-paragraph" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $coordinator->user->name ?? '')" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    {{-- Campo E-mail --}}
    <div class="transition-all duration-300 ease-out" style="transition-delay: 50ms" :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }">
        <x-input-label for="email" value="E-mail" class="!text-sm !font-semibold !text-paragraph" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $coordinator->user->email ?? '')" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    {{-- Campo Documento com Máscara --}}
    <div class="transition-all duration-300 ease-out" style="transition-delay: 100ms" :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }">
        <x-input-label for="document" value="Documento (CPF)" class="!text-sm !font-semibold !text-paragraph" />
        <x-text-input
            id="document"
            name="document"
            type="text"
            class="mt-1 block w-full"
            :value="old('document', $coordinator->user->document ?? '')"
            required
            placeholder="___.___.___-__"
            x-data="{
                formatCpf(value) {
                    let onlyNumbers = value.replace(/\D/g, '').substring(0, 11);
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

    {{-- Campos de Senha (condicional) --}}
    @if (!isset($coordinator))
        <div class="transition-all duration-300 ease-out" style="transition-delay: 150ms" :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }">
            <x-input-label for="password" value="Senha" class="!text-sm !font-semibold !text-paragraph" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="transition-all duration-300 ease-out" style="transition-delay: 200ms" :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }">
            <x-input-label for="password_confirmation" value="Confirmar Senha" class="!text-sm !font-semibold !text-paragraph" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
        </div>
    @endif

    {{-- Campo Departamento --}}
    <div class="transition-all duration-300 ease-out" style="transition-delay: 250ms" :class="{ 'opacity-100 translate-y-0': loaded, 'opacity-0 translate-y-4': !loaded }">
        <x-input-label for="departamento" value="Departamento" class="!text-sm !font-semibold !text-paragraph" />
        <x-text-input id="departamento" name="departamento" type="text" class="mt-1 block w-full" :value="old('departamento', $coordinator->departamento ?? '')" required />
        <x-input-error :messages="$errors->get('departamento')" class="mt-2" />
    </div>
</div>
