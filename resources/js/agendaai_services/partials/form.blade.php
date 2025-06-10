@php
  $service = $service ?? null;
  $selectedProfessionals = old(
    'professionals',
    $service
      ? $service->professionals->pluck('id')->toArray()
      : []
  );
@endphp

@csrf

{{-- Linha 1: nome, duração e preço --}}
<div class="row mb-3">
  <div class="col-md-4">
    <label for="name">Nome do Serviço</label>
    <input
      type="text"
      name="name"
      id="name"
      value="{{ old('name', optional($service)->name) }}"
      class="form-control @error('name') is-invalid @enderror"
      required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-3">
    <label for="duration_min">Duração (min)</label>
    <input
      type="number"
      name="duration_min"
      id="duration_min"
      value="{{ old('duration_min', optional($service)->duration_min) }}"
      class="form-control @error('duration_min') is-invalid @enderror"
      required>
    @error('duration_min')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-3">
    <label for="price">Valor (R$)</label>
    <input
      type="number"
      name="price"
      id="price"
      step="0.01"
      value="{{ old('price', optional($service)->price) }}"
      class="form-control @error('price') is-invalid @enderror"
      required>
    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-2 d-flex align-items-end">
    <button type="submit" class="btn btn-primary w-100">
      {{ $service ? 'Atualizar' : 'Salvar' }}
    </button>
  </div>
</div>

{{-- Linha 2: imagem e descrição --}}
<div class="row mb-3">
  <div class="col-md-4">
    <label for="image">Imagem do Serviço</label>
    <input
      type="file"
      name="image"
      id="image"
      class="form-control @error('image') is-invalid @enderror">
    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

    @if($service && $service->image)
      <div class="mt-2">
        <img
          src="{{ asset('storage/' . $service->image) }}"
          alt="Imagem atual"
          style="max-height:150px; border-radius:6px;">
      </div>
    @endif
  </div>

  <div class="col-md-8">
    <label for="descrition">Descrição</label>
    <textarea
      name="descrition"
      id="descrition"
      rows="4"
      class="form-control @error('descrition') is-invalid @enderror"
      required>{{ old('descrition', optional($service)->descrition) }}</textarea>
    @error('descrition')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

{{-- Linha 3: select múltiplo de profissionais --}}
<div class="row mb-3">
  <div class="col-md-12">
    <label for="professionals">Profissionais</label>
    <select
      name="professionals[]"
      id="professionals"
      class="form-control @error('professionals') is-invalid @enderror"
      multiple>
      @foreach($professionals as $id => $label)
        <option value="{{ $id }}"
          {{ in_array($id, $selectedProfessionals) ? 'selected' : '' }}>
          {{ $label }}
        </option>
      @endforeach
    </select>
    @error('professionals')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>
