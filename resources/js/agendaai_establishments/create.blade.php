@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cadastrar Estabelecimento</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h5 class="panel-title">Cadastro de Estabelecimentos</h5>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
    <div class="panel-body">
    <form method="POST" action="{{ route('agendaai.establishments.store') }}" enctype="multipart/form-data">
        @csrf
        @include('agendaai::agendaai_establishments.partials.form')
        <button type="submit" class="btn btn-success mt-3">Salvar</button>
        <a href="{{ route('agendaai.establishments.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
</div>
</div>
@endsection
