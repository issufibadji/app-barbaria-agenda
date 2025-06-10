@extends('layouts.app')

@section('content')
<div class="container">
<h1>Cadatro de Profissional</h1>
    {{-- Formulário --}}
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h5 class="panel-title">Cadatro Profissional</h5>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="panel-body">
        {{-- Conteudo --}}
        <form method="POST" action="{{ route('agendaai.professionals.store') }}">
            @csrf
            @include('agendaai::agendaai_professionals.partials.form', ['professional' => null])

            <button type="submit" class="btn btn-success mt-3">Salvar</button>
            <a href="{{ route('agendaai.professionals.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
       </form>
        </div>
    </div>
</div>
@endsection




