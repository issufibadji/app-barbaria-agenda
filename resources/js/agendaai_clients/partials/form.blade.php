@csrf

<div class="row">
  <div class="col-md-6 mb-3">
    <label for="user_id">Usuário</label>
    <select name="user_id"
            id="user_id"
            class="form-control @error('user_id') is-invalid @enderror"
            required>
      <option value="">-- Selecione o Usuário --</option>
      @foreach($users as $id => $name)
        <option value="{{ $id }}"
          {{ old('user_id', $client->user_id ?? '') == $id ? 'selected' : '' }}>
          {{ $name }}
        </option>
      @endforeach
    </select>
    @error('user_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6 mb-3">
    <label for="gender">Gênero</label>
    <input type="text"
           name="gender"
           id="gender"
           class="form-control @error('gender') is-invalid @enderror"
           value="{{ old('gender', $client->gender ?? '') }}"
           placeholder="Masculino, Feminino, Outro…">
    @error('gender')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>
