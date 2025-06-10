@extends('layouts.app')

@section('content')
<div class="container">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestão de Telefones</h1>
    <a href="{{ route('agendaai.phones.create') }}" class="btn btn-success">+ Telefone</a>
</div>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h5 class="panel-title">Telefones Cadastrados</h5>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
    <div class="panel-body">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>DDD</th>
                <th>DDI</th>
                <th>Phone</th>
                <th>Professional</th>
                <th>Establishment</th>
                <th>Criado em</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($phones as $phone)
            <tr>
                <td>{{ $phone->id }}</td>
                <td>{{ $phone->ddd }}</td>
                <td>{{ $phone->ddi }}</td>
                <td>{{ $phone->phone }}</td>
                <td>{{ optional(optional($phone->professional)->user)->name ?? '-' }}</td>
                <td>{{ optional($phone->establishment)->name ?? '-' }}</td>
                <td>{{ $phone->created_at->format('d/m/Y H:i') }}</td>
                <td class="d-flex gap-1">
                    <a href="{{ route('agendaai.phones.edit', $phone->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('agendaai.phones.destroy', $phone->id) }}" method="POST" onsubmit="return confirm('Delete this phone?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted">Telefone não encontrado.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
</div>
</div>
@endsection
