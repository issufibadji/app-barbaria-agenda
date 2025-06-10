@extends('layouts.app')

@section('content')
<div class="container">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestão Profissional</h1>
    {{-- Botão de adicionar --}}
    <a href="{{ route('agendaai.professionals.create') }}" class="btn btn-success">+ Profissional</a>
</div>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h5 class="panel-title">Profissionais</h5>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
    <div class="panel-body">
    {{-- Barra de busca --}}
        <form method="GET" action="{{ route('agendaai.professionals.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Pesquisa nome do Usuário aqui...">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        {{-- Listagem dos profissionais --}}
        <div class="row">
            @forelse ($professionals as $professional)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Nome: {{ $professional->user->name ?? 'N/A' }}</h5>
                            <p class="card-text">
                                Estabelecimento: {{ $professional->establishment->name ?? 'N/A' }}<br>
                                Comissão: {{ number_format($professional->commission, 2) }}%
                            </p>
                            <p class="card-text">
                                <strong>Telefone:</strong><br>
                                @foreach ($professional->phones as $phone)
                                    +{{ $phone->ddi }} ({{ $phone->ddd }}) {{ $phone->phone }}<br>
                                @endforeach
                            </p>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('agendaai.professionals.edit', $professional->uuid) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('agendaai.professionals.destroy', $professional->uuid) }}" method="POST" onsubmit="return confirm('Delete this professional?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Proficional não encontra.</p>
            @endforelse
        </div>
    </div>
   </div>
</div>
@endsection
