@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">Atualizar Agendamento</h1>
  <div class="panel panel-inverse">
    <div class="panel-heading">
        <h5 class="panel-title">Editar Produto</h5>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
    </div>
    <div class="panel-body">
  <form action="{{ route('agendaai.appointments.update', $appointment->id) }}" method="POST">
    @csrf @method('PUT')
    @include('agendaai::agendaai_appointments.partials.form')
    <button type="submit" class="btn btn-primary">Atualizar</button>
    <a href="{{ route('agendaai.appointments.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</div>
</div>
@endsection
