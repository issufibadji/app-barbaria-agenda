@php $plan = $plan ?? null; @endphp

<div class="row mb-3">
  <div class="col-md-6">
    <label for="name">Nome do Plano</label>
    <input
      type="text"
      name="name"
      id="name"
      value="{{ old('name', optional($plan)->name) }}"
      class="form-control @error('name') is-invalid @enderror"
      required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-3">
    <label for="days">Dias</label>
    <input
      type="number"
      name="days"
      id="days"
      value="{{ old('days', optional($plan)->days) }}"
      class="form-control @error('days') is-invalid @enderror"
      required>
    @error('days')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-3 d-flex align-items-center">
    <div class="form-check mt-4">
      <input
        class="form-check-input"
        type="checkbox"
        name="active"
        id="active"
        {{ old('active', optional($plan)->active) ? 'checked' : '' }}>
      <label class="form-check-label" for="active">Ativo</label>
    </div>
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-4">
    <label for="price">Valor (R$)</label>
    <input
      type="number"
      step="0.01"
      name="price"
      id="price"
      value="{{ old('price', optional($plan)->price) }}"
      class="form-control @error('price') is-invalid @enderror"
      required>
    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-12">
    <label for="descrition">Descrição</label>
    <textarea
      name="descrition"
      id="descrition"
      rows="3"
      class="form-control @error('descrition') is-invalid @enderror"
    >{{ old('descrition', optional($plan)->descrition) }}</textarea>
    @error('descrition')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>
