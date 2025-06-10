<div class="form-group">
    <label>Nome</label>
    <input type="text" name="name" value="{{ old('name', $establishment->name ?? '') }}" class="form-control" required>
</div>
<div class="form-group">
    <label>Link</label>
    <input type="url" name="link" value="{{ old('link', $establishment->link ?? '') }}" class="form-control" required>
</div>
<div class="form-group">
    <label>Imagem</label>
    <input type="file" name="image" class="form-control">
    @if (!empty($establishment->image))
        <img src="{{ asset('storage/' . $establishment->image) }}" alt="Imagem" style="max-height: 150px; margin-top: 10px;">
    @endif
</div>
<div class="form-group">
    <label>Descrição</label>
    <textarea name="descrition" rows="4" class="form-control">{{ old('descrition', $establishment->descrition ?? '') }}</textarea>
</div>
