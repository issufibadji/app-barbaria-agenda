@extends('layouts.app')

@section('content')
<div class="container">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestão de Estabelecimentos</h1>
    <a href="{{ route('agendaai.establishments.create') }}" class="btn btn-success">+ Estabelecimento</a>
</div>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h5 class="panel-title">Estabelecimentos Cadastrados</h5>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
    <div class="panel-body">
    {{-- Lista de estabelecimentos --}}
    <div class="mt-4">
        <h4>Estabelecimentos Disponíveis</h4>
        <div class="row">
            @forelse ($establishments as $establishment)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ $establishment->image ? asset('storage/' . $establishment->image) : asset('storage/images/servico-default.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5>{{ $establishment->name }}</h5>
                            <p class="text-muted">{{ Str::limit($establishment->descrition, 120) }}</p>
                            <a href="{{ $establishment->link }}" target="_blank" class="btn btn-sm btn-outline-info">Visitar</a>
                            <a href="{{ route('agendaai.establishments.edit', $establishment->uuid) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('agendaai.establishments.destroy', $establishment->uuid) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este estabelecimento?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Nenhum estabelecimento cadastrado.</p>
            @endforelse
        </div>
    </div>
    </div>
    </div>
</div>
@endsection
