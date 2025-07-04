<div class="mb-4 transition-all duration-700 ease-in-out" x-data x-init="$el.classList.add('opacity-0','translate-y-5'); setTimeout(()=>{$el.classList.remove('opacity-0','translate-y-5');$el.classList.add('opacity-100','translate-y-0');},50)" :class="{'opacity-100 translate-y-0': true, 'opacity-0 translate-y-5': false}">
    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
    <input type="text" name="name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" value="{{ old('name', $student->user->name ?? '') }}" required>
</div>

<div class="mb-4 transition-all duration-700 ease-in-out" x-data x-init="$el.classList.add('opacity-0','translate-y-5'); setTimeout(()=>{$el.classList.remove('opacity-0','translate-y-5');$el.classList.add('opacity-100','translate-y-0');},100)" :class="{'opacity-100 translate-y-0': true, 'opacity-0 translate-y-5': false}">
    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
    <input type="email" name="email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" value="{{ old('email', $student->user->email ?? '') }}" required>
</div>

{{-- ===== INÍCIO DA ALTERAÇÃO ===== --}}
<div class="mb-4 transition-all duration-700 ease-in-out" x-data x-init="$el.classList.add('opacity-0','translate-y-5'); setTimeout(()=>{$el.classList.remove('opacity-0','translate-y-5');$el.classList.add('opacity-100','translate-y-0');},150)" :class="{'opacity-100 translate-y-0': true, 'opacity-0 translate-y-5': false}">
    <label for="document" class="block text-sm font-medium text-gray-700 mb-1">Documento (CPF)</label>
    <input type="text" name="document"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900"
           value="{{ old('document', $student->user->document ?? '') }}" required
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
           @input="$event.target.value = formatCpf($event.target.value)">
</div>
{{-- ===== FIM DA ALTERAÇÃO ===== --}}


@if (!isset($student->id) || !$student->exists)
    <div class="mb-4 transition-all duration-700 ease-in-out" x-data x-init="$el.classList.add('opacity-0','translate-y-5'); setTimeout(()=>{$el.classList.remove('opacity-0','translate-y-5');$el.classList.add('opacity-100','translate-y-0');},200)" :class="{'opacity-100 translate-y-0': true, 'opacity-0 translate-y-5': false}">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
        <input type="password" name="password" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required>
    </div>

    <div class="mb-4 transition-all duration-700 ease-in-out" x-data x-init="$el.classList.add('opacity-0','translate-y-5'); setTimeout(()=>{$el.classList.remove('opacity-0','translate-y-5');$el.classList.add('opacity-100','translate-y-0');},250)" :class="{'opacity-100 translate-y-0': true, 'opacity-0 translate-y-5': false}">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Senha</label>
        <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900" required>
    </div>
@endif

<div class="mb-4 transition-all duration-700 ease-in-out" x-data x-init="$el.classList.add('opacity-0','translate-y-5'); setTimeout(()=>{$el.classList.remove('opacity-0','translate-y-5');$el.classList.add('opacity-100','translate-y-0');},300)" :class="{'opacity-100 translate-y-0': true, 'opacity-0 translate-y-5': false}">
    <label for="turma" class="block text-sm font-medium text-gray-700 mb-1">Turma</label>
    <input type="text" name="turma" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900 @if(isset($turma) && $turma) bg-gray-100 @endif"
           value="{{ old('turma', $turma ?? ($student->turma ?? '')) }}" required
           @if(isset($turma) && $turma) readonly @endif>
</div>

<div class="mb-4 transition-all duration-700 ease-in-out" x-data x-init="$el.classList.add('opacity-0','translate-y-5'); setTimeout(()=>{$el.classList.remove('opacity-0','translate-y-5');$el.classList.add('opacity-100','translate-y-0');},350)" :class="{'opacity-100 translate-y-0': true, 'opacity-0 translate-y-5': false}">
    <label for="ano_letivo" class="block text-sm font-medium text-gray-700 mb-1">Ano Letivo</label>
    <input type="text" name="ano_letivo" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900 @if(isset($ano_letivo) && $ano_letivo) bg-gray-100 @endif"
           value="{{ old('ano_letivo', $ano_letivo ?? ($student->ano_letivo ?? '')) }}" required
           @if(isset($ano_letivo) && $ano_letivo) readonly @endif>
</div>
