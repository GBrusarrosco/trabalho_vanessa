<div class="space-y-6">
    {{-- Campo Título --}}
    <div>
        {{-- Classe adicionada para melhorar a visibilidade --}}
        <x-input-label for="title" value="Título do Formulário" class="!font-semibold !text-paragraph" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $form->title ?? '')" required placeholder="Ex: Avaliação Semestral da Disciplina X" />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    {{-- Novos Campos para Turma e Ano Letivo --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            {{-- Classe adicionada para melhorar a visibilidade --}}
            <x-input-label for="turma" value="Turma" class="!font-semibold !text-paragraph" />
            <select name="turma" id="turma" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm text-paragraph bg-background focus:border-primary focus:ring-primary">
                <option value="">Selecione a turma...</option>
                @foreach($turmas->unique('turma') as $turmaOption)
                    <option value="{{ $turmaOption->turma }}" {{ (old('turma', $form->turma ?? '') == $turmaOption->turma) ? 'selected' : '' }}>
                        {{ $turmaOption->turma }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('turma')" class="mt-2" />
        </div>
        <div>
            {{-- Classe adicionada para melhorar a visibilidade --}}
            <x-input-label for="ano_letivo" value="Ano Letivo" class="!font-semibold !text-paragraph" />
            <select name="ano_letivo" id="ano_letivo" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm text-paragraph bg-background focus:border-primary focus:ring-primary">
                <option value="">Selecione o ano letivo...</option>
                @foreach($turmas->unique('ano_letivo') as $ano)
                    <option value="{{ $ano->ano_letivo }}" {{ (old('ano_letivo', $form->ano_letivo ?? '') == $ano->ano_letivo) ? 'selected' : '' }}>
                        {{ $ano->ano_letivo }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('ano_letivo')" class="mt-2" />
        </div>
    </div>

    {{-- Campo Descrição --}}
    <div>
        {{-- Classe adicionada para melhorar a visibilidade --}}
        <x-input-label for="description" value="Descrição (Opcional)" class="!font-semibold !text-paragraph" />
        <textarea id="description" name="description" rows="4" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm text-paragraph bg-background focus:border-primary focus:ring-primary">{{ old('description', $form->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
</div>
