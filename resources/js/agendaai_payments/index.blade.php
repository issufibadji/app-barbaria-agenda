@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestão de Pagamentos</h1>
    <a href="{{ route('agendaai.payments.create') }}" class="btn btn-success">
      + Pagamento
    </a>
  </div>
  <div class="panel panel-inverse">
<div class="panel-heading">
    <h5 class="panel-title">Pagamentos Cadastrados</h5>
    <div class="panel-heading-btn">
        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
    </div>
</div>
<div class="panel-body">
  <div class="row">
    @forelse($payments as $payment)
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">
              Plano: {{ $payment->plan?->name ?? '—' }}
            </h5>
            <p class="card-text text-muted mb-2">
              Estab.: {{ $payment->establishment->name ?? '-' }}
            </p>
            @if($payment->mercado_payment_id)
              <p class="card-text mb-3">
                MercadoPago ID:
                <small>{{ $payment->mercado_payment_id ?? '-' }}</small>
              </p>
            @endif

            <div class="mt-auto d-flex justify-content-between">
              <a
                href="{{ route('agendaai.payments.edit', $payment->id) }}"
                class="btn btn-sm btn-warning"
              ><i class="fa fa-pen"></i> Editar</a>

              <form
                action="{{ route('agendaai.payments.destroy', $payment->id) }}"
                method="POST"
                onsubmit="return confirm('Excluir este pagamento?')"
              >
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">
                  <i class="fa fa-trash"></i> Excluir
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center text-muted">
        Nenhum pagamento cadastrado.
      </div>
    @endforelse
  </div>
</div>
</div>
</div>
@endsection
