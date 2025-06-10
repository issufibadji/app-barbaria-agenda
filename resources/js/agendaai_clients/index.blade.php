@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestão de Clientes</h1>
    <a href="{{ route('agendaai.clients.create') }}" class="btn btn-success">
      + Cliente
    </a>
  </div>
  <div class="panel panel-inverse">
    <div class="panel-heading">
        <h5 class="panel-title">Clientes Cadastrados</h5>
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
        <th>Usuário</th>
        <th>Gênero</th>
        <th class="text-end">Ações</th>
      </tr>
    </thead>
    <tbody>
      @forelse($clients as $client)
        <tr>
          <td>{{ $client->id }}</td>
          <td>{{ $client->user->name }}</td>
          <td>{{ $client->gender ?? '—' }}</td>
          <td class="text-end">
            <a href="{{ route('agendaai.clients.edit', $client->id) }}"
               class="btn btn-sm btn-primary">Editar</a>
            <form action="{{ route('agendaai.clients.destroy', $client->id) }}"
                  method="POST" class="d-inline"
                  onsubmit="return confirm('Remover este cliente?');">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center">Nenhum cliente cadastrado.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{ $clients->links() }}
</div>
</div>
</div>
@endsection
