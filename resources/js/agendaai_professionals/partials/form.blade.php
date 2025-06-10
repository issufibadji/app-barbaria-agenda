<div class="row">
    <div class="col-md-6">
    <label for="user_id">Usuário</label>
    <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
        <option value="">-- Selecione o Usuário --</option>
        @foreach($users as $id => $name)
            <option value="{{ $id }}" {{ old('user_id', $professional->user_id ?? '') == $id ? 'selected':'' }}>
            {{ $name }}
            </option>
        @endforeach
        </select>
    @error('user_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    </div>
    <div class="col-md-6">
        <label for="commission">Commission (%)</label>
        <input type="number" name="commission" step="0.01"
               class="form-control @error('commission') is-invalid @enderror"
               value="{{ old('commission', $professional->commission ?? '') }}" required>
        @error('commission')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mt-3">
    <label for="establishment_id">Establishment</label>
    <select name="establishment_id" class="form-control @error('establishment_id') is-invalid @enderror" required>
        <option value="">Select...</option>
        @foreach ($establishments as $establishment)
            <option value="{{ $establishment->id }}" {{ old('establishment_id', $professional->establishment_id ?? '') == $establishment->id ? 'selected' : '' }}>
                {{ $establishment->name }}
            </option>
        @endforeach
    </select>
    @error('establishment_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<hr>
<h5 class="mt-4">Telefones</h5>
<div id="phone-list">
    @php
        $phones = old('phones', $professional->phones ?? [[]]);
    @endphp

    @foreach ($phones as $index => $phone)
        <div class="row phone-group mb-2">
            <div class="col-md-2">
                <input name="phones[{{ $index }}][ddi]" class="form-control" placeholder="DDI"
                       value="{{ old("phones.$index.ddi", is_array($phone) ? $phone['ddi'] ?? '' : $phone->ddi ?? '') }}">
            </div>
            <div class="col-md-2">
                <input name="phones[{{ $index }}][ddd]" class="form-control" placeholder="DDD"
                       value="{{ old("phones.$index.ddd", is_array($phone) ? $phone['ddd'] ?? '' : $phone->ddd ?? '') }}">
            </div>
            <div class="col-md-6">
                <input name="phones[{{ $index }}][phone]" class="form-control" placeholder="Phone"
                       value="{{ old("phones.$index.phone", is_array($phone) ? $phone['phone'] ?? '' : $phone->phone ?? '') }}">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-remove-phone w-100">Remove</button>
            </div>
        </div>
    @endforeach
</div>

<button type="button" class="btn btn-outline-primary mt-2" id="add-phone">+ Telefone</button>

@push('scripts')
<script>
    document.getElementById('add-phone').addEventListener('click', function () {
        const container = document.getElementById('phone-list');
        const index = container.querySelectorAll('.phone-group').length;

        const html = `
            <div class="row phone-group mb-2">
                <div class="col-md-2">
                    <input name="phones[\${index}][ddi]" class="form-control" placeholder="DDI">
                </div>
                <div class="col-md-2">
                    <input name="phones[\${index}][ddd]" class="form-control" placeholder="DDD">
                </div>
                <div class="col-md-6">
                    <input name="phones[\${index}][phone]" class="form-control" placeholder="Phone">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-remove-phone w-100">Remove</button>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('btn-remove-phone')) {
            e.target.closest('.phone-group').remove();
        }
    });
</script>
@endpush
