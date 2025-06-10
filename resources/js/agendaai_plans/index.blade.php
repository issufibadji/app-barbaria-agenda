@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestão de Planos</h1>
    <a href="{{ route('agendaai.plans.create') }}" class="btn btn-success">+ Plano</a>
  </div>
<div class="panel panel-inverse">
<div class="panel-heading">
    <h5 class="panel-title">Planos Cadastrados</h5>
    <div class="panel-heading-btn">
        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
    </div>
</div>
<div class="panel-body">
  <div class="row">
    @forelse($plans as $plan)
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $plan->name }}</h5>
            <p class="card-text text-muted" style="font-size:0.95rem;">
              {{ \Illuminate\Support\Str::limit($plan->descrition, 120) }}
            </p>
            <p class="card-text mb-2">
              Dias: {{ $plan->days }}<br>
              Valor: R$ {{ number_format($plan->price,2,',','.') }}
            </p>
            <span class="badge {{ $plan->active ? 'bg-success' : 'bg-secondary' }}">
              {{ $plan->active ? 'Ativo' : 'Inativo' }}
            </span>

            <div class="mt-auto d-flex justify-content-between">
              <a
                href="{{ route('agendaai.plans.edit', $plan->id) }}"
                class="btn btn-sm btn-warning"
              ><i class="fa fa-pen"></i> Editar</a>
              <form
                action="{{ route('agendaai.plans.destroy', $plan->id) }}"
                method="POST"
                onsubmit="return confirm('Excluir este plano?')"
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
        Nenhum plano cadastrado.
      </div>
    @endforelse
  </div>
</div>
</div>
</div>
@endsection
