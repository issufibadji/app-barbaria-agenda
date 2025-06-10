@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestão Endereço</h1>
    <a href="{{ route('agendaai.addresses.create') }}" class="btn btn-success">
      + Endereço
    </a>
  </div>
  <div class="panel panel-inverse">
    <div class="panel-heading">
        <h5 class="panel-title">Endereço Cadastrados</h5>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
    </div>
  <div class="panel-body">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>CEP</th>
        <th>Rua/Avanida</th>
        <th>Complemento</th>
        <th>Cidade</th>
        <th>UF</th>
        <th>Estabelecimento</th>
        <th class="text-end">Ações</th>
      </tr>
    </thead>
    <tbody>
      @forelse($addresses as $addr)
        <tr>
          <td>{{ $addr->id }}</td>
          <td>{{ $addr->cep }}</td>
          <td>{{ $addr->street }}</td>
          <td>{{ $addr->city }}</td>
          <td>{{ $addr->complement }}</td>
          <td>{{ $addr->uf }}</td>
          <td>{{ optional($addr->establishment)->name ?? '-' }}</td>
          <td class="text-end">
            <a
              href="{{ route('agendaai.addresses.edit', $addr->id) }}"
              class="btn btn-sm btn-primary">
              Edit
            </a>
            <form
              action="{{ route('agendaai.addresses.destroy', $addr->id) }}"
              method="POST"
              class="d-inline"
              onsubmit="return confirm('Delete this address?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8" class="text-center">Nenhum Endereço encontrado.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{ $addresses->links() }}
</div>
</div>
</div>
@endsection
