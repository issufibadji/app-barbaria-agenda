@csrf

<div class="row mb-3">
  <div class="col-md-8">
    <label for="schedule">Título da Agenda</label>
    <input type="text"
           name="schedule"
           id="schedule"
           class="form-control @error('schedule') is-invalid @enderror"
           value="{{ old('schedule', $schedule->schedule ?? '') }}"
           placeholder="Ex: Consultas Matinais"
           required>
    @error('schedule')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4">
    <label for="professional_id">Profissional</label>
    <select name="professional_id"
            id="professional_id"
            class="form-control @error('professional_id') is-invalid @enderror"
            required>
      <option value="">-- Selecione o Profissional --</option>
      @foreach($professionals as $id => $name)
        <option value="{{ $id }}"
          {{ old('professional_id', $schedule->professional_id ?? '') == $id ? 'selected' : '' }}>
          {{ $name }}
        </option>
      @endforeach
    </select>
    @error('professional_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>
