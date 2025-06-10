<h5 class="mt-4">Telefones</h5>
<div id="phone-list">
  @foreach($phones as $index => $phone)
    <div class="row phone-group mb-3">
      <div class="col-md-1">
        <input type="text"
               name="phones[{{ $index }}][ddi]"
               class="form-control"
               placeholder="DDI"
               value="{{ $phone['ddi'] }}">
      </div>
      <div class="col-md-1">
        <input type="text"
               name="phones[{{ $index }}][ddd]"
               class="form-control"
               placeholder="DDD"
               value="{{ $phone['ddd'] }}">
      </div>
      <div class="col-md-2">
        <input type="text"
               name="phones[{{ $index }}][phone]"
               class="form-control"
               placeholder="Phone"
               value="{{ $phone['phone'] }}">
      </div>

      <div class="col-md-3">
        <select name="phones[{{ $index }}][professional_id]" class="form-control">
          <option value="">-- Select Professional --</option>
          @foreach($professionals as $p)
            <option value="{{ $p->id }}"
              {{ $phone['professional_id'] == $p->id ? 'selected' : '' }}>
              {{ $p->user->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <select name="phones[{{ $index }}][establishment_id]" class="form-control">
          <option value="">-- Select Establishment --</option>
          @foreach($establishments as $e)
            <option value="{{ $e->id }}"
              {{ $phone['establishment_id'] == $e->id ? 'selected' : '' }}>
              {{ $e->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-1 text-end">
        <button type="button" class="btn btn-danger btn-remove-phone">Remove</button>
      </div>
    </div>
  @endforeach
</div>

<button type="button" class="btn btn-outline-primary mt-2" id="add-phone">+ Telefone</button>

@push('scripts')
<script>
  const profOptions = `@foreach($professionals as $p)
    <option value="{{ $p->id }}">{{ $p->user->name }}</option>
  @endforeach`;

  const estOptions = `@foreach($establishments as $e)
    <option value="{{ $e->id }}">{{ $e->name }}</option>
  @endforeach`;

  document.getElementById('add-phone').addEventListener('click', function () {
    const container = document.getElementById('phone-list');
    const i = container.querySelectorAll('.phone-group').length;
    const row = `
      <div class="row phone-group mb-3">
        <div class="col-md-1">
          <input type="text" name="phones[\${i}][ddi]" class="form-control" placeholder="DDI">
        </div>
        <div class="col-md-1">
          <input type="text" name="phones[\${i}][ddd]" class="form-control" placeholder="DDD">
        </div>
        <div class="col-md-2">
          <input type="text" name="phones[\${i}][phone]" class="form-control" placeholder="Phone">
        </div>
        <div class="col-md-3">
          <select name="phones[\${i}][professional_id]" class="form-control">
            <option value="">-- Select Professional --</option>
            \${profOptions}
          </select>
        </div>
        <div class="col-md-4">
          <select name="phones[\${i}][establishment_id]" class="form-control">
            <option value="">-- Select Establishment --</option>
            \${estOptions}
          </select>
        </div>
        <div class="col-md-1 text-end">
          <button type="button" class="btn btn-danger btn-remove-phone">Remove</button>
        </div>
      </div>`;
    container.insertAdjacentHTML('beforeend', row);
  });

  document.addEventListener('click', e => {
    if (e.target.matches('.btn-remove-phone')) {
      e.target.closest('.phone-group').remove();
    }
  });
</script>
@endpush
