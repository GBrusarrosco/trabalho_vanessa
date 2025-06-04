{{-- Div para agrupar os campos com espaçamento --}}
<div class="space-y-6">
    {{-- Campo Título --}}
    <div>
        <label for="title" class="block text-sm font-semibold text-headline mb-1">Título do Formulário</label>
        <input type="text" name="title" id="title"
               class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 placeholder-gray-400 text-paragraph bg-background @error('title') border-danger @enderror"
               value="{{ old('title', $form->title ?? '') }}" required
               placeholder="Ex: Avaliação Semestral da Disciplina X">
        @error('title')
        <p class="text-danger text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Campo Descrição --}}
    <div>
        <label for="description" class="block text-sm font-semibold text-headline mb-1">Descrição (Opcional)</label>
        <textarea name="description" id="description" rows="4"
                  class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 placeholder-gray-400 text-paragraph bg-background @error('description') border-danger @enderror"
                  placeholder="Forneça uma breve descrição ou instruções para este formulário.">{{ old('description', $form->description ?? '') }}</textarea>
        @error('description')
        <p class="text-danger text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
