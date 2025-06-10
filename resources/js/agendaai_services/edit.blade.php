@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Editar Serviço</h1>
  <div class="panel panel-inverse">
    <div class="panel-heading">
        <h5 class="panel-title">Editar Produto</h5>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
    </div>
    <div class="panel-body">
    <form method="POST" action="{{ route('agendaai.services.update', $service->uuid) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('agendaai::agendaai_services.partials.form')
        <button class="btn btn-primary mt-3">Atualizar</button>
        <a href="{{ route('agendaai.services.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
    </div>
  </div>
</div>
@endsection
