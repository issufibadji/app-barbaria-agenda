@extends('layouts.app')

@section('content')
<div class="container">
  {{-- Cabeçalho com título e botão de criação --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestão de Serviços</h1>
    <a href="{{ route('agendaai.services.create') }}" class="btn btn-success">
      + Serviço
    </a>
  </div>
  <div class="panel panel-inverse">
    <div class="panel-heading">
        <h5 class="panel-title">Serviço Cadastrados</h5>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
    </div>
 <div class="panel-body">
  {{-- Lista de serviços como cards --}}
  <div class="row">
    @forelse ($services as $service)
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          {{-- Imagem --}}
          <img src="{{ $service->image
                        ? asset('storage/'.$service->image)
                        : asset('storage/images/servico-default.jpg') }}"
               class="card-img-top"
               alt="Imagem do serviço"
               style="height:220px;object-fit:cover;border-radius:6px 6px 0 0;">

          <div class="card-body d-flex flex-column">
            {{-- Título e descrição --}}
            <h5 class="card-title">{{ $service->name }}</h5>
            <p class="card-text text-muted" style="font-size:0.95rem;">
              {{ \Illuminate\Support\Str::limit($service->descrition, 120) }}
            </p>

            {{-- Duração e preço --}}
            <p class="card-text mb-2">
              Duração: {{ $service->duration_min }} min<br>
              Valor: R$ {{ number_format($service->price,2,',','.') }}
            </p>

            {{-- Profissionais vinculados --}}
            @if($service->professionals->isNotEmpty())
              <div class="mb-2">
                <small class="text-muted">Profissionais:</small><br>
                @foreach($service->professionals as $prof)
                  <span class="badge bg-secondary">
                    {{ $prof->user->name }}
                  </span>
                @endforeach
              </div>
            @endif

            {{-- Botões de ação --}}
            <div class="mt-auto d-flex justify-content-between">
              <a href="{{ route('agendaai.services.edit', $service->uuid) }}"
                 class="btn btn-sm btn-warning">
                <i class="fa fa-pen"></i> Editar
              </a>
              <form action="{{ route('agendaai.services.destroy', $service->uuid) }}"
                    method="POST"
                    onsubmit="return confirm('Deseja realmente excluir este serviço?')">
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
      <div class="col-12">
        <p class="text-center text-muted">Nenhum serviço cadastrado.</p>
      </div>
    @endforelse
  </div>
 </div>
  </div>
</div>
@endsection
