@extends('layouts.app')

@push('style')
    {{-- personalizacao do serach-select --}}
    <style>
        .select2-results__option {
            font-weight: normal !important;
        }

        .select2 {
            font-size: small;
        }
    </style>
@endpush

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css">
    <!-- Tema escuro (paraiso-dark como exemplo) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/theme/paraiso-dark.min.css">


    <div class="container">
        <h1>Cadastro Modelos de Relatórios</h1>

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
                <form action="{{ route('relatorios.store') }}" method="post" id="reports" class="row g-3">
                    @csrf
                    <input type="hidden" name="report_model_uuid" id="report_model_uuid"
                        value="{{ $relatorioModelo->uuid ?? '' }}">
                    <div class="my-5">
                        <div class="nav-wizards-container">
                            <nav class="nav nav-wizards-1 mb-2">
                                <div class="nav-item col" id="wizardStep1">
                                    <a class="nav-link active" href="#">
                                        <div class="nav-no">1</div>
                                        <div class="nav-text">Dados do Modelo</div>
                                    </a>
                                </div>

                                <div class="nav-item col" id="wizardStep2">
                                    <a class="nav-link" href="#">
                                        <div class="nav-no">2</div>
                                        <div class="nav-text">Relacionamentos</div>
                                    </a>
                                </div>

                                <div class="nav-item col" id="wizardStep3">
                                    <a class="nav-link" href="#">
                                        <div class="nav-no">3</div>
                                        <div class="nav-text">Filtros</div>
                                    </a>
                                </div>

                                <div class="nav-item col" id="wizardStep4">
                                    <a class="nav-link" href="#">
                                        <div class="nav-no">4</div>
                                        <div class="nav-text">SQL</div>
                                    </a>
                                </div>

                                <div class="nav-item col" id="wizardStep5">
                                    <a class="nav-link" href="#">
                                        <div class="nav-no">5</div>
                                        <div class="nav-text">VIEW Modelo</div>
                                    </a>
                                </div>
                            </nav>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div id="wizardContent1" class="row">
                                    <div class="form-group col-6 mb-3">
                                        <label for="reportName">Nome do Relatório:</label>
                                        <input type="text" class="form-control" id="reportName" name="reportName"
                                            value="{{ $relatorioModelo->name ?? '' }}">
                                    </div>
                                    <div class="form-group col-6 mb-3">
                                        <label for="openMode">Modo de Abertura:</label>
                                        <select class="form-control" id="openMode" name="openMode">
                                            <option value="samePage"
                                                {{ ($relatorioModelo->open_mode ?? '') == 'samePage' ? 'selected' : '' }}>Na
                                                Mesma Página</option>
                                            <option value="newPage"
                                                {{ ($relatorioModelo->open_mode ?? '') == 'newPage' ? 'selected' : '' }}>
                                                Nova Página</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6 mb-3">
                                        <label for="acl">Permissões do Relatório (ACL):</label>
                                        <select class="form-control" id="acl" name="acl[]" multiple>
                                            <option value="0">Nenhum</option>
                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->name }}"
                                                    {{ in_array($permission->name, json_decode($relatorioModelo->acl ?? '[]')) ? 'selected' : '' }}>
                                                    {{ $permission->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="wizardContent2" class="row" style="display:none;">
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            <h3>Agora as Tabelas</h3>
                                            <p>Selecione as tabelas do relatório</p>
                                        </div>
                                        <div class="col-4" style="align-self: end;">
                                            <a id="novo_relacionamento" class="btn btn-sm btn-info"
                                                style="float: right;">Novo Relacionamento</a>
                                        </div>
                                    </div>

                                    <div class="container mb-3" id="relacionamentos">
                                        @isset($relatorioModelo)
                                            @foreach ($relatorioModelo->relationships as $index => $relationship)
                                                <div class="row"
                                                    style="overflow-x: auto; white-space: nowrap; border-bottom: groove; padding-bottom: 5px;">
                                                    <div class="form-group col-md-2">
                                                        <label for="tabelas">Tabela:</label>
                                                        <select name="relationships[{{ $index }}][table_origin]"
                                                            class="form-control tabelas">
                                                            <option value="null">N/A</option>
                                                            <option value="{{ $relationship->table_origin }}" selected>
                                                                {{ $relationship->table_origin }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="colunas">Coluna:</label>
                                                        <select name="relationships[{{ $index }}][column_origin]"
                                                            class="form-control colunas">
                                                            <option value="null">N/A</option>
                                                            <option value="{{ $relationship->column_origin }}" selected>
                                                                {{ $relationship->column_origin }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="relacionamentos">Relacionamento:</label>
                                                        <select name="relationships[{{ $index }}][relationship_type]"
                                                            class="form-control relacionamentos">
                                                            <option value="JOIN"
                                                                {{ $relationship->relationship_type == 'JOIN' ? 'selected' : '' }}>
                                                                Join</option>
                                                            <option value="LEFT JOIN"
                                                                {{ $relationship->relationship_type == 'LEFT JOIN' ? 'selected' : '' }}>
                                                                LeftJoin</option>
                                                            <option value="RIGHT JOIN"
                                                                {{ $relationship->relationship_type == 'RIGHT JOIN' ? 'selected' : '' }}>
                                                                RigthJoin</option>
                                                            <option value="INNER JOIN"
                                                                {{ $relationship->relationship_type == 'INNER JOIN' ? 'selected' : '' }}>
                                                                InnerJoin</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="tabelas_relacionadas">Tabela:</label>
                                                        <select name="relationships[{{ $index }}][table_target]"
                                                            class="form-control tabelas_relacionadas">
                                                            <option value="null">N/A</option>
                                                            <option value="{{ $relationship->table_target }}" selected>
                                                                {{ $relationship->table_target }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="colunas_relacionadas">Coluna:</label>
                                                        <select name="relationships[{{ $index }}][column_target]"
                                                            class="form-control colunas_relacionadas">
                                                            <option value="null">N/A</option>
                                                            <option value="{{ $relationship->column_target }}" selected>
                                                                {{ $relationship->column_target }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-1 d-flex align-items-center">
                                                        <a class="btn btn-sm btn-danger apagar_relacionamento"
                                                            style="float: right;">Excluir</a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endisset

                                        <div class="row clone_relacionamento"
                                            style="overflow-x: auto; white-space: nowrap; display:none;  border-bottom: groove; padding-bottom: 5px;">
                                            <div class="form-group col-md-2">
                                                <label for="tabelas">Tabela:</label>
                                                <select name="relationships[-1][table_origin]"
                                                    class="form-control tabelas">
                                                    <option value="null">N/A</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="colunas">Coluna:</label>
                                                <select name="relationships[-1][column_origin]"
                                                    class="form-control colunas">
                                                    <option value="null">N/A</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="relacionamentos">Relacionamento:</label>
                                                <select
                                                    name="relationships[-1][relationship_type]"class="form-control relacionamentos">
                                                    <option value="null">N/A</option>
                                                    <option value="JOIN">Join</option>
                                                    <option value="LEFT JOIN">LeftJoin</option>
                                                    <option value="RIGHT JOIN">RigthJoin</option>
                                                    <option value="INNER JOIN">InnerJoin</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="tabelas_relacionadas">Tabela:</label>
                                                <select name="relationships[-1][table_target]"
                                                    class="form-control tabelas_relacionadas">
                                                    <option value="null">N/A</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="colunas_relacionadas">Coluna:</label>
                                                <select name="relationships[-1][column_target]"
                                                    class="form-control colunas_relacionadas">
                                                    <option value="null">N/A</option>
                                                </select>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <a class="btn btn-sm btn-danger apagar_relacionamento"
                                                    style="float: right;">Excluir</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div id="wizardContent3" class="row" style="display:none;">
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            <h3>Agora as Colunas</h3>
                                            <p>Selecione o filtro e as colunas...</p>
                                        </div>
                                        <div class="col-4" style="align-self: end;">
                                            <a id="novo_campo" class="btn btn-sm btn-info" style="float: right;">Novo
                                                Campo</a>
                                        </div>
                                    </div>

                                    <div class="mb-3 container" id="colunas">
                                        @isset($relatorioModelo)
                                            @foreach ($relatorioModelo->fields as $index => $field)
                                                <div class="row"
                                                    style="overflow-x: auto; white-space: nowrap; border-bottom: groove; padding:1em;">
                                                    <div class="col-11">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="campos">Campo:</label>
                                                                <select name="fields[{{ $index }}][field]"
                                                                    class="form-control campos">
                                                                    <option value="{{ $field->field }}" selected>
                                                                        {{ $field->field }}</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="alias">Alias:</label>
                                                                <input type="text"
                                                                    name="fields[{{ $index }}][alias]"
                                                                    class="form-control" value="{{ $field->alias }}">
                                                            </div>
                                                        </div>
                                                        <div class="row m-4">
                                                            <div class="form-group col-md-3">
                                                                <label for="isFilter"
                                                                    class="form-check-label">isFilter:</label>
                                                                <input type="checkbox"
                                                                    name="fields[{{ $index }}][isFilter]"
                                                                    class="form-check-input toggle-filter"
                                                                    data-index="{{ $index }}"
                                                                    {{ $field->is_filter ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="orderby"
                                                                    class="form-check-label">OrderBY:</label>
                                                                <input type="checkbox"
                                                                    name="fields[{{ $index }}][orderby]"
                                                                    class="form-check-input"
                                                                    {{ $field->orderby ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="groupby"
                                                                    class="form-check-label">GroupBY:</label>
                                                                <input type="checkbox"
                                                                    name="fields[{{ $index }}][groupby]"
                                                                    class="form-check-input"
                                                                    {{ $field->groupby ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="visible_filter" class="form-check-label">Filtro
                                                                    Visível:</label>
                                                                <input type="checkbox"
                                                                    name="fields[{{ $index }}][visible_filter]"
                                                                    class="form-check-input"
                                                                    {{ $field->visible_filter ? 'checked' : '' }}>
                                                            </div>
                                                        </div>
                                                        <div class="row filter-fields" data-index="{{ $index }}"
                                                            style="{{ $field->is_filter ? '' : 'display:none;' }}">
                                                            <div class="form-group col-md-3">
                                                                <label for="filter">Filter:</label>
                                                                <select name="fields[{{ $index }}][filter_operator]"
                                                                    class="form-control">
                                                                    <option value="null">N/A</option>
                                                                    <option value="<"
                                                                        {{ $field->filter_operator == '<' ? 'selected' : '' }}>
                                                                        menor</option>
                                                                    <option value=">"
                                                                        {{ $field->filter_operator == '>' ? 'selected' : '' }}>
                                                                        maior</option>
                                                                    <option value="="
                                                                        {{ $field->filter_operator == '=' ? 'selected' : '' }}>
                                                                        igual</option>
                                                                    <option value="!="
                                                                        {{ $field->filter_operator == '!=' ? 'selected' : '' }}>
                                                                        diferente</option>
                                                                    <option value="BETWEEN"
                                                                        {{ $field->filter_operator == 'BETWEEN' ? 'selected' : '' }}>
                                                                        entre</option>
                                                                    <option value="LIKE"
                                                                        {{ $field->filter_operator == 'LIKE' ? 'selected' : '' }}>
                                                                        contem</option>
                                                                    <option value="BEFORELIKE"
                                                                        {{ $field->filter_operator == 'BEFORELIKE' ? 'selected' : '' }}>
                                                                        comecaCom</option>
                                                                    <option value="ENDLIKE"
                                                                        {{ $field->filter_operator == 'ENDLIKE' ? 'selected' : '' }}>
                                                                        terminaCom</option>
                                                                    <!-- Outros valores aqui -->
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="defaultValue">DefaultValue:</label>
                                                                <input type="text"
                                                                    name="fields[{{ $index }}][default_value]"
                                                                    class="form-control" value="{{ $field->default_value }}">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="orand">Operador Lógico:</label>
                                                                <select name="fields[{{ $index }}][orand]"
                                                                    class="form-control">
                                                                    <option value="AND"
                                                                        {{ $field->or_and == 'AND' ? 'selected' : '' }}>AND
                                                                    </option>
                                                                    <option value="OR"
                                                                        {{ $field->or_and == 'OR' ? 'selected' : '' }}>OR
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="field_type">Tipo de Campo:</label>
                                                                <select name="fields[{{ $index }}][field_type]"
                                                                    class="form-control">
                                                                    <option value="text"
                                                                        {{ $field->field_type == 'text' ? 'selected' : '' }}>
                                                                        Texto</option>
                                                                    <option value="number"
                                                                        {{ $field->field_type == 'number' ? 'selected' : '' }}>
                                                                        Número</option>
                                                                    <option value="date"
                                                                        {{ $field->field_type == 'date' ? 'selected' : '' }}>
                                                                        Data</option>
                                                                    <option value="boolean"
                                                                        {{ $field->field_type == 'boolean' ? 'selected' : '' }}>
                                                                        Booleano</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-1">
                                                        <div class="col-1 d-flex align-items-center">
                                                            <a class="btn btn-sm btn-danger apagar_campo"
                                                                style="float: right;">Excluir</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endisset
                                        <div class="row clone_campo"
                                            style="overflow-x: auto; white-space: nowrap; display:none;  border-bottom: groove; padding:1em;">
                                            <div class="col-11">
                                                <div class="row">
                                                    <div class="form-group col-md-8">
                                                        <label for="campos">Campo:</label>
                                                        <select name="fields[-1][field]" class="form-control campos">
                                                            <option value="null">N/A</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="alias">Alias:</label>
                                                        <input type="text" name="fields[-1][alias]"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row m-4">
                                                    <div class="form-group col-md-3">
                                                        <label for="isFilter" class="form-check-label">isFilter:</label>
                                                        <input type="checkbox" name="fields[-1][isFilter]"
                                                            data-index="-1" class="form-check-input toggle-filter">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="orderby" class="form-check-label">OrderBY:</label>
                                                        <input type="checkbox" name="fields[-1][orderby]"
                                                            class="form-check-input">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="groupby" class="form-check-label">GroupBY:</label>
                                                        <input type="checkbox" name="fields[-1][groupby]"
                                                            class="form-check-input">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="visible_filter" class="form-check-label">Filtro
                                                            Visivel:</label>
                                                        <input type="checkbox" name="fields[-1][visible_filter]"
                                                            class="form-check-input">
                                                    </div>
                                                </div>
                                                <div class="row filter-fields" data-index='-1' style="display: none;">
                                                    <div class="form-group col-md-3">
                                                        <label for="filter">Filter:</label>
                                                        <select name="fields[-1][filter_operator]" class="form-control">
                                                            <option value="null">N/A</option>
                                                            <option value="<">menor</option>
                                                            <option value=">">maior</option>
                                                            <option value="=">igual</option>
                                                            <option value="!=">diferente</option>
                                                            <option value="BETWEEN">entre</option>
                                                            <option value="LIKE">contem</option>
                                                            <option value="BEFORELIKE">comecaCom</option>
                                                            <option value="ENDLIKE">terminaCom</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="defaultValue">DefaultValue:</label>
                                                        <input type="text" name="fields[-1][default_value]"
                                                            class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="orand">Operador Lógico:</label>
                                                        <select name="fields[-1][orand]" class="form-control">
                                                            <option value="AND">AND</option>
                                                            <option value="OR">OR</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="field_type">Tipo de Campo:</label>
                                                        <select name="fields[-1][field_type]" class="form-control">
                                                            <option value="text">Texto</option>
                                                            <option value="number">Número</option>
                                                            <option value="date">Data</option>
                                                            <option value="boolean">Booleano</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="col-1 d-flex align-items-center">
                                                    <a class="btn btn-sm btn-danger apagar_campo"
                                                        style="float: right;">Excluir</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="wizardContent4" class="row  mb-3" style="display:none;">
                                    <div class="row">
                                        <div class="col-8">
                                            <h3>SQL</h3>
                                            <p>Revise aqui o SQL e teste na base de dados.</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <textarea id="sql" name="sql" style="display:none;"></textarea>
                                        </div>
                                        <a id="gerarSQLVIEW" class="btn btn-primary">Gerar SQL e View</a>
                                    </div>
                                </div>
                                <div id="wizardContent5" class="row  mb-3" style="display:none;">
                                    <div class="row">
                                        <div class="col-8">
                                            <h3>View e Blade</h3>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="blade-editor">Revise o HTML gerado</label>
                                            <textarea id="blade-editor" name="blade-editor" style="display:none;"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Salvar Modelo</button>
                                    </div>
                                </div>
                                <!-- Buttons for navigation -->
                                <div class="d-flex justify-content-between">
                                    <a id="prevStep" class="btn btn-secondary" style="display:none;">Voltar</a>
                                    <a id="nextStep" class="btn btn-primary">Próximo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/sql/sql.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/css/css.min.js"></script>

    {{-- Formatar o SQL --}}
    <script src="https://cdn.jsdelivr.net/npm/sql-formatter-plus@1.3.6/dist/sql-formatter.min.js"></script>

    <script>
        // Para relacionamento
        var relationshipIndex = 5000;
        var fieldIndex = 5000;

        function toggleFilterFields(index, isChecked) {
            const filterFields = $(`.filter-fields[data-index="${index}"]`);
            if (isChecked) {
                filterFields.show(); // Mostrar os campos de filtro
            } else {
                filterFields.hide(); // Esconder os campos de filtro
            }
        }

        $(document).on('click', '.apagar_relacionamento', function() {
            $(this).closest('.row').remove();
        });

        $(document).on('click', '#novo_relacionamento', function() {
            var div = $('.clone_relacionamento').clone().show().removeClass('clone_relacionamento');
            var token = $('meta[name="csrf-token"]').attr('content');

            var tabelasSelecionadas = [];

            // Substitui os nomes dos campos com o índice atual
            div.find('select').each(function() {
                let name = $(this).attr('name');
                name = name.replace('[-1]', '[' + relationshipIndex + ']');
                $(this).attr('name', name);
            });

            // Incrementa o índice para o próximo relacionamento
            relationshipIndex++;

            $('.tabelas').each(function() {
                var valorSelecionado = $(this).val();
                if (valorSelecionado != 'null') {
                    tabelasSelecionadas.push(valorSelecionado);
                }
            });

            $('.tabelas_relacionadas').each(function() {
                var valorSelecionado = $(this).val();
                if (valorSelecionado != 'null') {
                    tabelasSelecionadas.push(valorSelecionado);
                }
            });

            var dados = {
                tabela: tabelasSelecionadas,
                _token: token // Inclua o token CSRF nos dados da solicitação
            };

            // Fazendo a requisição AJAX
            $.ajax({
                type: 'POST',
                url: '/relatorio/lista_tabelas_relacionadas',
                data: dados,
                async: true,
                success: function(response) {
                    // Adiciona as novas opções

                    div.closest('.row').find('.tabelas').empty();
                    div.closest('.row').find('.tabelas').append('<option value="null">N/A</option>');

                    $.each(response, function(key, value) {
                        div.closest('.row').find('.tabelas').append('<option value="' + value +
                            '">' + value + '</option>');
                    });

                    div.closest('.row').find('.tabelas').select2();
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                }
            });

            $('div#wizardContent2 > #relacionamentos').children().last().before(div);
        });

        // Para colunas
        $(document).on('click', '.apagar_campo', function() {
            $(this).closest('.row').remove();
        });

        $(document).on('click', '#novo_campo', function() {
            var div = $('.clone_campo').clone().show().removeClass('clone_campo');
            var token = $('meta[name="csrf-token"]').attr('content');

            var tabelasSelecionadas = [];

            $('.tabelas').each(function() {
                var valorSelecionado = $(this).val();
                if (valorSelecionado != 'null') {
                    tabelasSelecionadas.push(valorSelecionado);
                }
            });

            $('.tabelas_relacionadas').each(function() {
                var valorSelecionado = $(this).val();
                if (valorSelecionado != 'null') {
                    tabelasSelecionadas.push(valorSelecionado);
                }
            });

            // Substitui os nomes dos campos com o índice atual
            div.find('select').each(function() {
                let name = $(this).attr('name');
                name = name.replace('[-1]', '[' + fieldIndex + ']');
                $(this).attr('name', name);
            });

            div.find('input').each(function() {
                let name = $(this).attr('name');
                name = name.replace('[-1]', '[' + fieldIndex + ']');
                $(this).attr('name', name);
            });

            div.find('.toggle-filter').each(function() {
                $(this).attr('data-index', fieldIndex);
                $(this).onchange = function() {
                    const index = $(this).data('index');
                    const isChecked = $(this).is(':checked');
                    toggleFilterFields(index, isChecked);
                }
            });

            div.find('.filter-fields').each(function() {
                $(this).attr('data-index', fieldIndex);
            });

            // Incrementa o índice para o próximo relacionamento
            fieldIndex++;

            var dados = {
                tabela: tabelasSelecionadas,
                _token: token // Inclua o token CSRF nos dados da solicitação
            };

            // Fazendo a requisição AJAX
            $.ajax({
                type: 'POST',
                url: '/relatorio/lista_colunas',
                data: dados,
                async: true,
                success: function(response) {
                    // Adiciona as novas opções

                    div.closest('.row').find('.campos').empty();

                    $.each(response, function(nomeTabela, arrayColunas) {
                        $.each(arrayColunas, function(nomeColuna, tipoColuna) {
                            div.closest('.row').find('.campos').append(
                                '<option value="' + nomeTabela + '::' + nomeColuna +
                                '">' + nomeTabela + '::' + nomeColuna + '</option>');
                        });
                    });

                    div.closest('.row').find('.campos').select2();

                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                }
            });

            $('div#wizardContent3 > #colunas').children().last().before(div);
        });

        //Ajax para configurar tabelas e colunas relacionadas
        $(document).on('change', '.tabelas', function() {
            var tabela = $(this).val();
            var tabelaSelecionada = $(this).val();
            var selectTabelasRelacionadas = $(this).closest('.row').find('.tabelas_relacionadas');
            var colunasSelect = $(this).closest('.row').find('.colunas');
            var token = $('meta[name="csrf-token"]').attr('content');

            // Dados a serem enviados via AJAX
            var dados = {
                tabela: Array(tabela),
                _token: token // Inclua o token CSRF nos dados da solicitação
            };

            // Fazendo a requisição AJAX para as tabelas relacionadas
            $.ajax({
                type: 'POST',
                url: '/relatorio/lista_tabelas_relacionadas',
                data: dados,
                async: false,
                success: function(response) {
                    // Adiciona as novas opções

                    selectTabelasRelacionadas.empty();
                    selectTabelasRelacionadas.append('<option value="null">N/A</option>');

                    $.each(response, function(key, value) {
                        selectTabelasRelacionadas.append('<option value="' + value +
                            '">' + value + '</option>');
                    });

                    selectTabelasRelacionadas.select2();
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                }
            });

            // Fazendo a requisição AJAX e para as colunas da tabela
            $.ajax({
                type: 'POST',
                url: '/relatorio/lista_colunas_pk',
                data: {
                    tabela: tabela,
                    _token: token
                },
                async: true,
                success: function(response) {
                    // Preencher o select com as colunas retornadas
                    colunasSelect.empty();
                    colunasSelect.append('<option value="null">N/A</option>');

                    $.each(response, function(key, value) {
                        colunasSelect.append('<option value="' + value + '">' +
                            value + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                }
            });

            selectTabelasRelacionadas.change();
        });

        $(document).on('change', '.tabelas_relacionadas', function() {
            var tabela = $(this).val();
            var tabelaSelecionada = $(this).val();
            var colunasSelect = $(this).closest('.row').find('.colunas_relacionadas');
            var token = $('meta[name="csrf-token"]').attr('content');

            // Fazendo a requisição AJAX
            $.ajax({
                type: 'POST',
                url: '/relatorio/lista_colunas_fk',
                data: {
                    tabela: tabela,
                    _token: token
                },
                async: true,
                success: function(response) {
                    // Preencher o select com as colunas retornadas
                    colunasSelect.empty();
                    colunasSelect.append('<option value="null">N/A</option>');

                    $.each(response, function(key, value) {
                        colunasSelect.append('<option value="' + value + '">' +
                            value + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                }
            });
        });

        // Alterar a visibilidade dos campos ao mudar o isFilter (para elementos existentes)
        $(document).on('change', '.toggle-filter', function() {
            const index = $(this).data('index');
            const isChecked = $(this).is(':checked');
            toggleFilterFields(index, isChecked);
        });

        function updateWizardClasses(currentStep) {
            // Atualiza a classe de cada passo
            $('.nav-link').each(function(index) {
                const step = index + 1; // Passos começam no 1
                if (step < currentStep) {
                    $(this).removeClass('active').addClass('completed');
                } else if (step === currentStep) {
                    $(this).removeClass('completed').addClass('active');
                } else {
                    $(this).removeClass('active completed');
                }
            });
        }

        $(document).ready(function() {

            let currentStep = 1;
            let numMaxStep = 5;
            var token = $('meta[name="csrf-token"]').attr('content');

            var originalSQL = '';

            $('#acl').select2();

            var editorSQL = CodeMirror.fromTextArea(document.getElementById('sql'), {
                mode: "text/x-sql",
                theme: "paraiso-dark", // Você pode alterar o tema
                lineNumbers: true, // Mostrar números de linha
                tabSize: 2, // Tamanho do tab (opcional)
                indentWithTabs: true // Usar tabs para indentação
            });

            var editorBLADE = CodeMirror.fromTextArea(document.getElementById('blade-editor'), {
                mode: "htmlmixed", // Suporte para HTML e Blade (que inclui HTML, CSS, JS)
                theme: "paraiso-dark", // Tema opcional
                lineNumbers: true, // Mostrar números de linha
                matchBrackets: true, // Destacar colchetes correspondentes
                tabSize: 2, // Tamanho do tab (opcional)
                indentWithTabs: true // Usar tabs para indentação
            });

            $('.toggle-filter').each(function() {
                const index = $(this).data('index');
                const isChecked = $(this).is(':checked');
                toggleFilterFields(index, isChecked);
            });

            // Para o SQL
            editorSQL.setValue(sqlFormatter.format(@json($relatorioModelo->layout->sql_query ?? ''), {
                language: 'sql', // Defaults to "sql"
                indent: '    ', // Defaults to two spaces,
                uppercase: true, // Defaults to false
                linesBetweenQueries: 2 // Defaults to 1
            }));

            // Para o Blade
            editorBLADE.setValue(@json($relatorioModelo->layout->blade_template ?? ''));

            //Enable Tooltips
            var tooltipTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="tooltip"]')
            );
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Next button click handler
            $('#nextStep').click(function() {
                if (currentStep < numMaxStep) {

                    $('#wizardContent' + currentStep).hide();
                    currentStep++;
                    $('#wizardContent' + currentStep).show();

                    updateWizardClasses(currentStep);

                    // Show previous button if we're not on the first step
                    if (currentStep > 1) {
                        $('#prevStep').show();
                    }

                    // Hide next button on the last step
                    if (currentStep === numMaxStep) {
                        $('#nextStep').hide();
                    }
                }
            });

            // Previous button click handler
            $('#prevStep').click(function() {
                if (currentStep > 1) {
                    $('#wizardContent' + currentStep).hide();
                    currentStep--;
                    $('#wizardContent' + currentStep).show();

                    updateWizardClasses(currentStep);


                    // Show next button if we're not on the last step
                    if (currentStep < numMaxStep) {
                        $('#nextStep').show();
                    }

                    // Hide previous button on the first step
                    if (currentStep === 1) {
                        $('#prevStep').hide();
                    }
                }
            });

            $(document).on('click', '#gerarSQLVIEW', function() {
                if (currentStep >= 3) {
                    // Fazendo a requisição AJAX para as tabelas relacionadas
                    var formData = $('#reports').serialize();
                    $.ajax({
                        method: 'POST',
                        type: 'POST',
                        url: '/relatorio/preview-store',
                        data: formData,
                        async: false,
                        success: function(response) {
                            // Adiciona as novas opções
                            originalSQL = response.SQL;

                            var currentContentSQL = editorSQL
                                .getValue(); // Pega o conteúdo atual
                            editorSQL.setValue(sqlFormatter
                                .format(response.SQL, {
                                    language: 'sql', // Defaults to "sql"
                                    indent: '    ', // Defaults to two spaces,
                                    uppercase: true, // Defaults to false
                                    linesBetweenQueries: 2 // Defaults to 1
                                })
                            );

                            var currentContentBLADE = editorBLADE
                                .getValue(); // Pega o conteúdo atual
                            editorBLADE.setValue(response
                                .VIEW);

                            editorBLADE.refresh();
                            editorSQL.refresh();

                            $('<div class="alert alert-success">SQL e View Gerados!</div>')
                                .insertBefore('#reports')
                                .delay(3000).fadeOut('slow');
                        },
                        error: function(xhr, status, error) {
                            console.error('Erro na requisição:', error);
                        }
                    });
                }
            });

        });
    </script>
@endpush
