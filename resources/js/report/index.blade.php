@extends('layouts.app')

@section('content')
    <div class="container">
        <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}" type="text/javascript">
        </script>

        <link href="{{ asset('/plugins/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}"
            rel="stylesheet" />
        <script src="{{ asset('plugins/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}"
            type="text/javascript"></script>

        <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
            rel="stylesheet" />
        <script src="{{ asset('plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"
            type="text/javascript"></script>

        <h1>Modelos de Relatórios</h1>

        <div class="text-end">
            <a href="{{ route('relatorios.create') }}" class="btn btn-success mb-3">Novo Relatório</a>
        </div>

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h5 class="panel-title">Relatórios</h5>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i
                            class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i
                            class="fa fa-minus"></i></a>
                </div>
            </div>
            <div class="panel-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Modo Abertura</th>
                            <th>Data Modificação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($relatorios as $relatorio)
                            <tr>
                                <td>{{ $relatorio->uuid }}</td>
                                <td>{{ $relatorio->name }}</td>
                                <td>{{ $relatorio->open_mode }}</td>
                                <td>{{ $relatorio->updated_at }}</td>
                                <td>
                                    <a href="{{ route('relatorios.renderReport', $relatorio->uuid) }}"
                                        class="btn btn-info btn-sm" target="_blank">Visualizar</a>

                                    <a href="{{ route('relatorios.edit', $relatorio->uuid) }}"
                                        class="btn btn-primary btn-sm">Editar</a>

                                    <form action="{{ route('relatorios.destroy', $relatorio->uuid) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Você tem certeza?')">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('.table').DataTable({
                pageLength: 10,
                responsive: true,
                language: {
                    "url": "{{ asset('lang/pt-BR.json') }}"
                },
            });

        });
    </script>
@endsection
