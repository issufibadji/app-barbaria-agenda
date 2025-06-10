@php
  // create & edit
  $message = $message ?? null;
@endphp

<div class="row mb-3">
  <div class="col-md-4">
    <label for="type">Tipo</label>
    <input
      type="text"
      name="type"
      id="type"
      value="{{ old('type', optional($message)->type) }}"
      class="form-control @error('type') is-invalid @enderror"
      required>
    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-4">
    <label for="establishment_id">Estabelecimento</label>
    <select
      name="establishment_id"
      id="establishment_id"
      class="form-control @error('establishment_id') is-invalid @enderror"
      required>
      <option value="">– selecione –</option>
      @foreach($establishments as $id => $name)
        <option value="{{ $id }}"
          {{ old('establishment_id', optional($message)->establishment_id)==$id ? 'selected' : '' }}>
          {{ $name }}
        </option>
      @endforeach
    </select>
    @error('establishment_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-8">
    <label for="message">Mensagem</label>
    <textarea
      name="message"
      id="message"
      rows="4"
      class="form-control @error('message') is-invalid @enderror"
      required>{{ old('message', optional($message)->message) }}</textarea>
    @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>
