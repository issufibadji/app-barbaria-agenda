@extends('layouts.app')

@section('content')
<div class="container">
  {{-- Cabeçalho com título e botão de criação --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestão de Produtos</h1>
    <a href="{{ route('agendaai.products.create') }}" class="btn btn-success">
      + Produto
    </a>
  </div>
  <div class="panel panel-inverse">
        <div class="panel-heading">
            <h5 class="panel-title">Produtos Cadastrados</h5>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
    <div class="panel-body">
  {{-- Lista de produtos como cards --}}
  <div class="row">
    @forelse ($products as $product)
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          {{-- Imagem --}}
          <img src="{{ $product->image
                        ? asset('storage/'.$product->image)
                        : asset('storage/images/product-default.jpg') }}"
               class="card-img-top"
               alt="Imagem do produto"
               style="height:220px;object-fit:cover;border-radius:6px 6px 0 0;">

          <div class="card-body d-flex flex-column">
            {{-- Título e descrição --}}
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text text-muted" style="font-size:0.95rem;">
              {{ \Illuminate\Support\Str::limit($product->descrition, 120) }}
            </p>

            {{-- Preço --}}
            <p class="card-text mb-2">
              Valor: R$ {{ number_format($product->price, 2, ',', '.') }}
            </p>

            {{-- Botões de ação --}}
            <div class="mt-auto d-flex justify-content-between">
              <a href="{{ route('agendaai.products.edit', $product->uuid) }}"
                 class="btn btn-sm btn-warning">
                <i class="fa fa-pen"></i> Editar
              </a>
              <form action="{{ route('agendaai.products.destroy', $product->uuid) }}"
                    method="POST"
                    onsubmit="return confirm('Deseja realmente excluir este produto?')">
                @csrf
                @method('DELETE')
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
        <p class="text-center text-muted">Nenhum produto cadastrado.</p>
      </div>
    @endforelse
  </div>
</div>
</div>
</div>
@endsection
