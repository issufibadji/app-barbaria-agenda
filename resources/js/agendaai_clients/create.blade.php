@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">Cadastrar Cliente</h1>
  <div class="panel panel-inverse">
        <div class="panel-heading">
            <h5 class="panel-title">Cadastro de Cliente</h5>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="panel-body">

  <form action="{{ route('agendaai.clients.store') }}" method="POST">
    @include('agendaai::agendaai_clients.partials.form')
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="{{ route('agendaai.clients.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</div>
</div>
@endsection
