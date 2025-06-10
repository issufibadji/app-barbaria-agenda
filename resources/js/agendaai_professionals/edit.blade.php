@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ataulizar Profissional</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h5 class="panel-title">Editar Profissional</h5>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('agendaai.professionals.update', $professional->uuid) }}">
                @csrf
                @method('PUT')
                @include('agendaai::agendaai_professionals.partials.form', ['professional' => $professional])

                <button type="submit" class="btn btn-primary mt-3">Update</button>
                <a href="{{ route('agendaai.professionals.index') }}" class="btn btn-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
