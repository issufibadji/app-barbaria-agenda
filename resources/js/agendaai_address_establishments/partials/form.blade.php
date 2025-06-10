@php
    // $address será nulo no create e Model no edit
    $address = $address ?? null;
@endphp

@csrf

<div class="row mb-3">
  <div class="col-md-2">
    <label for="cep">CEP</label>
    <input
      type="text"
      name="cep"
      id="cep"
      class="form-control @error('cep') is-invalid @enderror"
      value="{{ old('cep', optional($address)->cep) }}"
      placeholder="00000-000">
    @error('cep')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-2">
    <label for="uf">UF</label>
    <input
      type="text"
      name="uf"
      id="uf"
      class="form-control @error('uf') is-invalid @enderror"
      value="{{ old('uf', optional($address)->uf) }}"
      placeholder="SP">
    @error('uf')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4">
    <label for="city">Cidade</label>
    <input
      type="text"
      name="city"
      id="city"
      class="form-control @error('city') is-invalid @enderror"
      value="{{ old('city', optional($address)->city) }}"
      placeholder="São Paulo">
    @error('city')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4">
    <label for="street">Endereço</label>
    <input
      type="text"
      name="street"
      id="street"
      class="form-control @error('street') is-invalid @enderror"
      value="{{ old('street', optional($address)->street) }}"
      placeholder="Av. Paulista, 1000">
    @error('street')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-6">
    <label for="complement">Complemento</label>
    <input
      type="text"
      name="complement"
      id="complement"
      class="form-control @error('complement') is-invalid @enderror"
      value="{{ old('complement', optional($address)->complement) }}"
      placeholder="Sala 101">
    @error('complement')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6">
    <label for="establishment_id">Estabelicimento</label>
    <select
      name="establishment_id"
      id="establishment_id"
      class="form-control @error('establishment_id') is-invalid @enderror"
      required>
      <option value="">-- Select Establishment --</option>
      @foreach($establishments as $id => $name)
        <option
          value="{{ $id }}"
          {{ old('establishment_id', optional($address)->establishment_id) == $id ? 'selected' : '' }}>
          {{ $name }}
        </option>
      @endforeach
    </select>
    @error('establishment_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>
