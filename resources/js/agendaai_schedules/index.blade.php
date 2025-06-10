@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestão de Agendas</h1>
    <a href="{{ route('agendaai.schedules.create') }}" class="btn btn-success">
    + Agenda
    </a>
  </div>
  <div class="panel panel-inverse">
    <div class="panel-heading">
        <h5 class="panel-title">Agendas Cadastradas</h5>
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
        <th>Agenda</th>
        <th>Profissional</th>
        <th class="text-end">Ações</th>
      </tr>
    </thead>
    <tbody>
      @forelse($schedules as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->schedule }}</td>
          <td>{{ $item->professional->user->name }}</td>
          <td class="text-end">
            <a href="{{ route('agendaai.schedules.edit',    $item->id) }}"
               class="btn btn-sm btn-primary">Edit</a>
            <form action="{{ route('agendaai.schedules.destroy', $item->id) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Delete this schedule?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">
                Delete
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
        <td colspan="4" class="text-center">Nenhuma agenda encontrada.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{ $schedules->links() }}
</div>
</div>
</div>
@endsection
