@php
  // in create, $product will be null; in edit it's the model instance
  $product = $product ?? null;
@endphp

@csrf

{{-- Nome e preço --}}
<div class="row mb-3">
  <div class="col-md-6">
    <label for="name">Nome do Produto</label>
    <input
      type="text"
      name="name"
      id="name"
      value="{{ old('name', optional($product)->name) }}"
      class="form-control @error('name') is-invalid @enderror"
      required
    >
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-3">
    <label for="price">Preço (R$)</label>
    <input
      type="number"
      name="price"
      id="price"
      step="0.01"
      value="{{ old('price', optional($product)->price) }}"
      class="form-control @error('price') is-invalid @enderror"
      required
    >
    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

{{-- Imagem --}}
<div class="row mb-3">
  <div class="col-md-6">
    <label for="image">Imagem do Produto</label>
    <input
      type="file"
      name="image"
      id="image"
      class="form-control @error('image') is-invalid @enderror"
    >
    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

    @if($product && $product->image)
      <div class="mt-2">
        <img
          src="{{ asset('storage/' . $product->image) }}"
          alt="Imagem atual"
          style="max-height: 120px; border-radius:4px;"
        >
      </div>
    @endif
  </div>
</div>

{{-- Descrição --}}
<div class="row mb-3">
  <div class="col-md-8">
    <label for="descrition">Descrição</label>
    <textarea
      name="descrition"
      id="descrition"
      rows="4"
      class="form-control @error('descrition') is-invalid @enderror"
      required
    >{{ old('descrition', optional($product)->descrition) }}</textarea>
    @error('descrition')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

{{-- Botões --}}
<div class="row mb-3">
  <div class="col-md-4">
    <button type="submit" class="btn btn-{{ $product ? 'primary' : 'success' }}">
      {{ $product ? 'Atualizar' : 'Salvar' }}
    </button>
    <a href="{{ route('agendaai.products.index') }}" class="btn btn-secondary">Cancelar</a>
  </div>
</div>
