@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Cadastrar Novo Plano</h1>
  <div class="panel panel-inverse">
    <div class="panel-heading">
        <h5 class="panel-title">Editar Produto</h5>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
    </div>
    <div class="panel-body">
    <form action="{{ route('agendaai.plans.store') }}" method="POST">
        @csrf
        @include('agendaai::agendaai_plans.partials.form')
        <button class="btn btn-primary">Salvar</button>
        <a href="{{ route('agendaai.plans.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
    </div>
  </div>
</div>
@endsection
