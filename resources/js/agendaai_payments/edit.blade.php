@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Atualizar Pagamento</h1>
  <div class="panel panel-inverse">
    <div class="panel-heading">
        <h5 class="panel-title">Editar Pagamento</h5>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
    </div>
    <div class="panel-body">
  <form action="{{ route('agendaai.payments.update', $payment->id) }}" method="POST">
    @csrf @method('PUT')
    @include('agendaai::agendaai_payments.partials.form')
    <div class="mt-3">
      <button class="btn btn-primary">Atualizar</button>
      <a href="{{ route('agendaai.payments.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
</div>
</div>
</div>
@endsection
