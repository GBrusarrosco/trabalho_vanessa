<div class="mb-3">
    <label for="title">Título</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $form->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="description">Descrição</label>
    <textarea name="description" class="form-control">{{ old('description', $form->description ?? '') }}</textarea>
</div>
