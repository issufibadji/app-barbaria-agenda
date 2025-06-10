@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">Editar Agenda</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('agendaai.schedules.update', $schedule->id) }}" method="POST">
    @method('PUT')
    @include('agendaai::agendaai_schedules.partials.form')
    <button type="submit" class="btn btn-primary">Atualizar Agenda</button>
    <a href="{{ route('agendaai.schedules.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
@endsection
