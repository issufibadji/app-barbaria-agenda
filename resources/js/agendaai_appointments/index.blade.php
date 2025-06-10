@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestão de Agendamentos</h1>
    <a href="{{ route('agendaai.appointments.create') }}" class="btn btn-success">
      + Agendamento
    </a>
  </div>
  <div class="panel panel-inverse">
    <div class="panel-heading">
        <h5 class="panel-title">Agendamentos Cadastrados</h5>
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
        <th>Serviços</th>
        <th>Clientes</th>
        <th>Data & hora</th>
        <th>Status</th>
        <th class="text-end">Açoes</th>
      </tr>
    </thead>
    <tbody>
      @forelse($appointments as $app)
        <tr>
          <td>{{ $app->id }}</td>
          <td>{{ optional($app->service)->name ?? '-' }}</td>
          <td>{{ optional($app->client->user)->name ?? '-' }}</td>
          <td>
            {{ \Carbon\Carbon::parse($app->scheduled_at)->format('d/m/Y H:i') }}
          </td>
          <td>{{ ucfirst($app->status) }}</td>
          <td class="text-end">
            <a href="{{ route('agendaai.appointments.edit', $app->id) }}"
               class="btn btn-sm btn-primary">
              Edit
            </a>
            <form action="{{ route('agendaai.appointments.destroy', $app->id) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Delete this appointment?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">
                Delete
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center">Nenhum Agendamento encontrado.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{ $appointments->links() }}
</div>
  </div>
</div>
@endsection
