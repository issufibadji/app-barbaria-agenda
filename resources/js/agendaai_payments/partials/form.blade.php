@php
  // $payment é instância ou null em create
  $payment = $payment ?? null;
@endphp

<div class="row mb-3">
  {{-- Plano --}}
  <div class="col-md-4">
    <label for="plan_id">Plano</label>
    <select name="plan_id" id="plan_id"
            class="form-control @error('plan_id') is-invalid @enderror"
            required>
      <option value="">– selecione –</option>
      @foreach($plans as $id => $name)
        <option value="{{ $id }}"
          {{ old('plan_id', optional($payment)->plan_id)==$id ? 'selected' : '' }}>
          {{ $name }}
        </option>
      @endforeach
    </select>
    @error('plan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  {{-- Estabelecimento --}}
  <div class="col-md-4">
    <label for="establishment_id">Estabelecimento</label>
    <select name="establishment_id" id="establishment_id"
            class="form-control @error('establishment_id') is-invalid @enderror"
            required>
      <option value="">– selecione –</option>
      @foreach($establishments as $id => $name)
        <option value="{{ $id }}"
          {{ old('establishment_id', optional($payment)->establishment_id)==$id ? 'selected' : '' }}>
          {{ $name }}
        </option>
      @endforeach
    </select>
    @error('establishment_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  {{-- Pagamento MercadoPago --}}
  <!-- <div class="col-md-4">
    <label for="mercado_payment_id">Pagamento (MercadoPago)</label>
    <select name="mercado_payment_id" id="mercado_payment_id"
            class="form-control @error('mercado_payment_id') is-invalid @enderror"
            required>
      <option value="">– selecione –</option>
      @foreach($mercadoPayments as $id => $label)
        <option value="{{ $id }}"
          {{ old('mercado_payment_id', optional($payment)->mercado_payment_id)==$id ? 'selected' : '' }}>
          {{ $label }}
        </option>
      @endforeach
    </select>
    @error('mercado_payment_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div> -->
  {{-- Pagamento Estatico e temporaria --}}
    @php
    $staticPayments = [
        'abc123' => 'abc123 – Pix de Teste',
        'def456' => 'def456 – Boleto de Teste',
        'ghi789' => 'ghi789 – Cartão de Teste',
    ];
    $selMp = old('mercado_payment_id', optional($payment)->mercado_payment_id);
    @endphp

    <div class="col-md-4">
    <label for="mercado_payment_id">Pagamento (MercadoPago)</label>
    <select name="mercado_payment_id" id="mercado_payment_id"
            class="form-control @error('mercado_payment_id') is-invalid @enderror"
            required>
        <option value="">– selecione –</option>
        @foreach($staticPayments as $id => $label)
        <option value="{{ $id }}" {{ $selMp === $id ? 'selected' : '' }}>
            {{ $label }}
        </option>
        @endforeach
    </select>
    @error('mercado_payment_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>
</div>
