@php
    // Garante que $appointment exista (null no create, model no edit)
    $appointment = $appointment ?? null;
@endphp

@csrf

<div class="row mb-3">
  {{-- Service --}}
  <div class="col-md-4">
    <label for="service_id">Serviço</label>
    <select name="service_id"
            id="service_id"
            class="form-control @error('service_id') is-invalid @enderror"
            required>
      <option value="">-- Select Service --</option>
      @foreach($services as $id => $name)
        <option value="{{ $id }}"
          {{ old('service_id', optional($appointment)->service_id) == $id ? 'selected' : '' }}>
          {{ $name }}
        </option>
      @endforeach
    </select>
    @error('service_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  {{-- Client --}}
  <div class="col-md-4">
    <label for="client_id">Cliente</label>
    <select name="client_id"
            id="client_id"
            class="form-control @error('client_id') is-invalid @enderror"
            required>
      <option value="">-- Select Client --</option>
      @foreach($clients as $id => $name)
        <option value="{{ $id }}"
          {{ old('client_id', optional($appointment)->client_id) == $id ? 'selected' : '' }}>
          {{ $name }}
        </option>
      @endforeach
    </select>
    @error('client_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  {{-- Date & Time --}}
  <div class="col-md-4">
    <label for="scheduled_at">Data & Hora</label>
    <input type="datetime-local"
           name="scheduled_at"
           id="scheduled_at"
           class="form-control @error('scheduled_at') is-invalid @enderror"
           value="{{ old('scheduled_at',
               optional($appointment)->scheduled_at
                   ? \Carbon\Carbon::parse($appointment->scheduled_at)
                       ->format('Y-m-d\TH:i')
                   : ''
           ) }}"
           required>
    @error('scheduled_at')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="row mb-3">
  {{-- Status --}}
  <div class="col-md-4">
    <label for="status">Status</label>
    <select name="status"
            id="status"
            class="form-control @error('status') is-invalid @enderror"
            required>
      @foreach(['pendente','confirmado','cancelado'] as $st)
        <option value="{{ $st }}"
          {{ old('status', optional($appointment)->status ?? 'pendente') == $st ? 'selected' : '' }}>
          {{ ucfirst($st) }}
        </option>
      @endforeach
    </select>
    @error('status')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>
