@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Atualizar Mensagem</h1>
    <a href="{{ route('agendaai.messages.index') }}" class="btn btn-secondary">Voltar</a>
  </div>
  <div class="panel panel-inverse">
    <div class="panel-heading">
        <h5 class="panel-title">Editar Mensagens</h5>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
    </div>
    <div class="panel-body">
  <form method="POST" action="{{ route('agendaai.messages.update', $message->id) }}">
    @csrf @method('PUT')
    @include('agendaai::agendaai_messages.partials.form')
    <button type="submit" class="btn btn-primary">Atualizar</button>
    <a href="{{ route('agendaai.messages.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
  </div>
</div>
@endsection
