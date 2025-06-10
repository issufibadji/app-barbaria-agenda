<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use App\Models\ReportField;
use App\Models\ReportLayout;
use App\Models\ReportModel;
use App\Models\ReportRelationship;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {   
        if (!Auth::user()->can('report::listar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 

        $relatorios = ReportModel::all();
        return view('report::index', compact('relatorios'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {   
        if (!Auth::user()->can('report::criar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 

        // Recupere todas as tabelas do banco de dados
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        // $permissions = DB::select('SELECT * FROM `permissions` WHERE `name` LIKE "script::%";');
        $permissions = DB::select('SELECT * FROM `permissions` WHERE 1');
        return view('report::create', compact('tables', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('report::criar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 

        if ($request->has('report_model_uuid') && !empty($request->input('report_model_uuid'))) {
            // Atualizar o modelo existente
            $reportModel = ReportModel::where('uuid', $request->input('report_model_uuid'))->firstOrFail();
            $reportModel->update([
                'name' => $request->input('reportName'),
                'open_mode' => $request->input('openMode'),
                'acl' => json_encode($request->input('acl')),
                'user_id' => Auth::user()->id,
            ]);

            ReportRelationship::where('report_model_id', $reportModel->id)->delete();

            // Passo 2: Salvar os relacionamentos
            foreach ($request->input('relationships') as $relationship) {
                if ($relationship['table_origin'] == 'null')
                    continue;

                ReportRelationship::create([
                    'report_model_id' => $reportModel->id,
                    'table_origin' => $relationship['table_origin'],
                    'column_origin' => $relationship['column_origin'],
                    'relationship_type' => $relationship['relationship_type'],
                    'table_target' => $relationship['table_target'],
                    'column_target' => $relationship['column_target'],
                ]);
            }

            ReportField::where('report_model_id', $reportModel->id)->delete();
            // Passo 3: Salvar os campos selecionados
            foreach ($request->input('fields') as $field) {
                if ($field['field'] == 'null')
                    continue;

                ReportField::create([
                    'report_model_id' => $reportModel->id,
                    'field' => $field['field'],
                    'alias' => $field['alias'] ?? null,
                    'is_filter' => isset($field['isFilter']),
                    'orderby' => isset($field['orderby']),
                    'groupby' => isset($field['groupby']),
                    'filter_operator' => $field['filter_operator'] ?? null,
                    'default_value' => $field['default_value'] ?? null,
                    'logic' => $field['orand'],
                    'visible_filter' => isset($field['visible_filter']),
                    'field_type' => $field['field_type'],
                ]);
            }

            // Passo 4: Gerar o SQL e salvar o layout
            // $sql = $this->generateSQL($reportModel->id); // Função para gerar o SQL

            $sql = $request->input('sql');
            $blade_template = $request->input('blade-editor');

            ReportLayout::where('report_model_id', $reportModel->id)->delete();
            ReportLayout::create([
                'report_model_id' => $reportModel->id,
                'sql_query' => $sql,
                'blade_template' => $blade_template,
            ]);
        } else {
            // Passo 1: Salvar o modelo de relatório
            $reportModel = ReportModel::create([
                'name' => $request->input('reportName'),
                'open_mode' => $request->input('openMode'),
                'acl' => json_encode($request->input('acl')), // Salva as permissões como JSON
                'user_id' => Auth::user()->id,
            ]);

            // Passo 2: Salvar os relacionamentos
            foreach ($request->input('relationships') as $relationship) {
                if ($relationship['table_origin'] == 'null')
                    continue;

                ReportRelationship::create([
                    'report_model_id' => $reportModel->id,
                    'table_origin' => $relationship['table_origin'],
                    'column_origin' => $relationship['column_origin'],
                    'relationship_type' => $relationship['relationship_type'],
                    'table_target' => $relationship['table_target'],
                    'column_target' => $relationship['column_target'],
                ]);
            }

            // Passo 3: Salvar os campos selecionados
            foreach ($request->input('fields') as $field) {
                if ($field['field'] == 'null')
                    continue;

                ReportField::create([
                    'report_model_id' => $reportModel->id,
                    'field' => $field['field'],
                    'alias' => $field['alias'] ?? null,
                    'is_filter' => isset($field['isFilter']),
                    'orderby' => isset($field['orderby']),
                    'groupby' => isset($field['groupby']),
                    'filter_operator' => $field['filter_operator'] ?? null,
                    'default_value' => $field['default_value'] ?? null,
                    'logic' => $field['orand'],
                    'visible_filter' => isset($field['visible_filter']),
                    'field_type' => $field['field_type'],
                ]);
            }

            // Passo 4: Gerar o SQL e salvar o layout
            // $sql = $this->generateSQL($reportModel->id); // Função para gerar o SQL
            $sql = $request->input('sql');
            $blade_template = $request->input('blade-editor');

            ReportLayout::create([
                'report_model_id' => $reportModel->id,
                'sql_query' => $sql,
                'blade_template' => $blade_template,
            ]);
        }

        return redirect()->route('relatorios.index')->with('success', 'Relatório criado com sucesso!');
    }

    public function previewReport(Request $request)
    {
        if (!Auth::user()->can('report::criar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 

        // Simular a geração de SQL e Template sem salvar no banco
        $sql = $this->generateSQL(null, $request->input('relationships'), $request->input('fields'));
        $view = $this->generateBladeTemplate(null, $request->input('fields'), $request->input('reportName'));

        // Retornar para pré-visualização
        return response()->json(['SQL' => $sql, 'VIEW' => $view]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        if (!Auth::user()->can('report::listar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 
        return view('report::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($uuid)
    {
        if (!Auth::user()->can('report::criar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 

        $relatorioModelo = ReportModel::with(['relationships', 'fields', 'layout'])->where('uuid', $uuid)->firstOrFail();
        $permissions = DB::select('SELECT * FROM `permissions` WHERE 1');

        return view('report::create', compact(['relatorioModelo', 'permissions']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($uuid)
    {
        if (!Auth::user()->can('report::criar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 

        $relatorio = ReportModel::where('uuid', $uuid)->firstOrFail();
        $relatorio->delete();

        return redirect()->back()->with('success', 'Relatório excluído com sucesso!');
    }

    public function listaTabelasRelacionadas(Request $request)
    {

        if (!Auth::user()->can('report::listar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 

        $nome_tabela = $request->input('tabela');

        // Obter todas as tabelas na base de dados
        // $tables = DB::select('SHOW TABLES');
        $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        $tabelas_relacionadas = [];

        foreach ($tables as $table) {
            // Obter informações sobre as chaves estrangeiras da tabela
            $foreignKeys = DB::select("
                                        SELECT
                                            table_name,
                                            column_name,
                                            referenced_table_name,
                                            referenced_column_name
                                        FROM information_schema.key_column_usage
                                        WHERE referenced_table_name IS NOT NULL
                                            AND table_name = :table
                                    ", ['table' => $table]);


            if ($nome_tabela == NULL || $nome_tabela[0] == NULL || in_array($table, $nome_tabela)) {
                $tabelas_relacionadas[] = $table;
            } else {
                // Imprimir informações sobre as chaves estrangeiras
                foreach ($foreignKeys as $foreignKey) {
                    if (in_array($foreignKey->referenced_table_name, $nome_tabela)) {
                        $tabelas_relacionadas[] = $table;
                    }
                }
            }
        }
        $tabelas_relacionadas = array_unique($tabelas_relacionadas);
        return response()->json($tabelas_relacionadas);
    }

    public function listaColunasFK(Request $request)
    {
        if (!Auth::user()->can('report::listar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 

        $nome_tabela = $request->input('tabela');
        $colunas_relacionadas = [];

        $foreignKeys = DB::select("
                                        SELECT
                                            table_name,
                                            column_name,
                                            referenced_table_name,
                                            referenced_column_name
                                        FROM information_schema.key_column_usage
                                        WHERE referenced_table_name IS NOT NULL
                                            AND table_name = :table
                                    ", ['table' => $nome_tabela]);

        // Imprimir informações sobre as chaves estrangeiras
        foreach ($foreignKeys as $foreignKey) {
            $colunas_relacionadas[] = $foreignKey->column_name;
        }
        return response()->json($colunas_relacionadas);
    }

    public function listaColunasPK(Request $request)
    {
        if (!Auth::user()->can('report::listar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 

        $nome_tabela = $request->input('tabela');
        $colunas_relacionadas = [];
        $primaryKeyIndexes = DB::select("
                                            SELECT
                                                COLUMN_NAME
                                            FROM information_schema.statistics
                                            WHERE (index_name = 'PRIMARY'
                                                OR index_name NOT LIKE '%foreign%')
                                                AND table_name = :table
                                        ", ['table' => $nome_tabela]);


        // Imprimir informações sobre as chaves estrangeiras
        foreach ($primaryKeyIndexes as $foreignKey) {
            $colunas_relacionadas[] = $foreignKey->COLUMN_NAME;
        }

        return response()->json($colunas_relacionadas);
    }

    public function listaColunas(Request $request)
    {
        if (!Auth::user()->can('report::listar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 

        $nome_tabela = $request->input('tabela');
        $data = [];

        foreach ($nome_tabela as $nt) {
            // Verifique se a tabela existe no banco de dados
            if (Schema::hasTable($nt)) {
                // Obtenha todas as colunas da tabela
                $columns = Schema::getColumnListing($nt);

                // Obtenha os tipos de coluna
                $types = [];
                $data[$nt] = [];

                foreach ($columns as $column) {
                    $data[$nt][$column] = Schema::getColumnType($nt, $column);
                }

                // Adicione as colunas ao array de colunas
                // $data[$nt] = $columns;
            }
        }


        // Retorne as colunas como JSON
        return response()->json($data);
    }

    // Função para gerar o SQL com base nos relacionamentos e campos selecionados
    private function generateSQL($reportModelId = null, $relationships = [], $fields = [])
    {
        if (!Auth::user()->can('report::criar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 

        if ($reportModelId) {
            // Se temos um ID de modelo, buscar do banco
            $reportModel = ReportModel::with(['relationships', 'fields'])->find($reportModelId);
            $relationships = $reportModel->relationships;
            $fields = $reportModel->fields;
        } else {
            // Se não, estamos lidando com dados diretos
            $relationships = array_values($relationships);
            $relationships = array_filter($relationships, function ($e) {
                return !($e['table_origin'] == 'null');
            });
            $fields = array_filter($fields, function ($e) {
                return !($e['field'] == 'null');
            });
            $relationships = array_map(function ($value) {
                return $this->arrayToObject($value);
            }, $relationships);
            $fields = array_map(function ($value) {
                return $this->arrayToObject($value);
            }, $fields);
        }

        $sql = "SELECT ";

        // Adicionar os campos
        foreach ($fields as $field) {
            $sql .= $field->field;
            if ($field->alias) {
                $sql .= " AS " . $field->alias;
            }
            $sql .= ", ";
        }
        $sql = rtrim(str_replace('::', '.', $sql), ', ') . " FROM " . $relationships[0]->table_origin;

        // Adicionar os relacionamentos
        foreach ($relationships as $relationship) {
            if($relationship->table_target != 'null'){
                $sql .= " " . strtoupper($relationship->relationship_type) . " " . $relationship->table_target;
                $sql .= " ON " . $relationship->table_origin . "." . $relationship->column_origin;
                $sql .= " = " . $relationship->table_target . "." . $relationship->column_target;
            }
        }

        // Adicionar os filtros
        $sql .= " WHERE 1=1 "; // Base para os filtros

        foreach ($fields as $field) {
            if (($field->is_filter ?? isset($field->isFilter))) {
                $sql .= ($field->logic ?? $field->orand) . " " . str_replace('::', '.', $field->field) . " ";

                $fieldAux = str_replace('::', '_', $field->field);
                // Operadores de filtro com placeholders

                if (in_array($field->field_type, ['text', 'date'])) {
                    switch ($field->filter_operator) {
                        case '<':
                            $sql .= "< ':{$fieldAux}_param' ";
                            break;
                        case '>':
                            $sql .= "> ':{$fieldAux}_param' ";
                            break;
                        case '=':
                            $sql .= "= ':{$fieldAux}_param' ";
                            break;
                        case '!=':
                            $sql .= "!= ':{$fieldAux}_param' ";
                            break;
                        case 'BETWEEN':
                            $sql .= "BETWEEN ':{$fieldAux}_param_start' AND ':{$fieldAux}_param_end' ";
                            break;
                        case 'LIKE':
                            $sql .= "LIKE '%:{$fieldAux}_param%' ";
                            break;
                        case 'BEFORELIKE':
                            $sql .= "LIKE ':{$fieldAux}_param%' ";
                            break;
                        case 'ENDLIKE':
                            $sql .= "LIKE '%:{$fieldAux}_param' ";
                            break;
                    }
                } else {
                    switch ($field->filter_operator) {
                        case '<':
                            $sql .= "< :{$fieldAux}_param ";
                            break;
                        case '>':
                            $sql .= "> :{$fieldAux}_param ";
                            break;
                        case '=':
                            $sql .= "= :{$fieldAux}_param ";
                            break;
                        case '!=':
                            $sql .= "!= :{$fieldAux}_param ";
                            break;
                        case 'BETWEEN':
                            $sql .= "BETWEEN :{$fieldAux}_param_start AND :{$fieldAux}_param_end ";
                            break;
                        case 'LIKE':
                            $sql .= "LIKE '%:{$fieldAux}_param%' ";
                            break;
                        case 'BEFORELIKE':
                            $sql .= "LIKE ':{$fieldAux}_param%' ";
                            break;
                        case 'ENDLIKE':
                            $sql .= "LIKE '%:{$fieldAux}_param' ";
                            break;
                    }
                }
            }
        }

        return $sql;
    }

    // Função para gerar o template Blade com base nos campos selecionados
    private function generateBladeTemplate($reportModelId = null, $fields = [], $nameReport = '')
    {

        if (!Auth::user()->can('report::criar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 

        if ($reportModelId) {
            // Se temos um ID de modelo, buscar do banco
            $reportModel = ReportModel::with('fields')->find($reportModelId);
            $fields = $reportModel->fields;
        } else {

            $fields = array_filter($fields, function ($e) {
                return !($e['field'] == 'null');
            });

            $fields = array_map(function ($value) {
                return $this->arrayToObject($value);
            }, $fields);
        }

        $blade = '@extends("layouts.app")
    @section("content")';

        $blade .= '<div class="panel panel-inverse">
    <div class="panel-heading">
        <h5 class="panel-title">Relatório</h5>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i
                    class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i
                    class="fa fa-minus"></i></a>
        </div>
    </div>
    <div class="panel-body">';

        $blade .= "<h3>$nameReport</h3>";

        // Adicionar os campos de filtro antes da tabela
        $blade .= $this->generateFilterForm($fields);

        // Começo da tabela
        $blade .= "<table name='$nameReport' id='$nameReport' class='table table-bordered'>\n<thead>\n<tr>\n";

        // Cabeçalhos
        foreach ($fields as $field) {
            $blade .= "<th>" . ($field->alias ?? str_replace('::', '.', $field->field)) . "</th>\n";
        }

        $blade .= "</tr>\n</thead>\n";
        $blade .= "<tbody>\n";

        // Laço para gerar os resultados dinamicamente
        $blade .= '@foreach ($results as $result)';
        $blade .= "<tr>\n";

        // Dados (dinâmicos)
        foreach ($fields as $field) {
            $blade .= "<td>{{ $" . "result->" . ($field->alias ?? explode('::', $field->field)[1]) . " }}</td>\n";
        }

        $blade .= "</tr>\n";
        $blade .= '@endforeach';

        $blade .= "</tbody>\n</table>\n";

        $blade .= '</div>
    </div>';

        // Scripts para DataTables e filtros
        $blade .= '<link href="{{ asset(\'/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css\') }}" rel="stylesheet" />
    <script src="{{ asset(\'plugins/datatables.net/js/jquery.dataTables.min.js\') }}" type="text/javascript"></script>
    <script src="{{ asset(\'plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js\') }}" type="text/javascript"></script>
    <script src="{{ asset(\'plugins/datatables.net-responsive/js/dataTables.responsive.min.js\') }}" type="text/javascript"></script>
    <link href="{{ asset(\'/plugins/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css\') }}" rel="stylesheet" />
    <script src="{{ asset(\'plugins/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js\') }}" type="text/javascript"></script>
    <link href="{{ asset(\'/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css\') }}" rel="stylesheet" />
    <script src="{{ asset(\'plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js\') }}" type="text/javascript"></script>
    
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <!-- JSZip -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <!-- PDFMake -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <!-- PDFMake (vfs_fonts) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <!-- DataTables Buttons HTML5 Export -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <!-- DataTables Buttons Print -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>';

        $blade .= "<script>
    $(document).ready(function() {
        $('.table').DataTable({
            dom: 'Bfrtip',
            language: {
                'url': '{{ asset('lang/pt-BR.json') }}'
            },
            buttons: [
            {
                extend: 'csv',
                filename: '$nameReport'
            },
            {
                extend: 'excel',
                filename: '$nameReport'
            },
            {
                extend: 'pdf',
                filename: '$nameReport'
            }
            ],
            pageLength: 10,
            responsive: true,
        });
    });
    </script>\n";

        $blade .= "@endsection";

        return $blade;
    }

    // Função para gerar o formulário de filtros
    private function generateFilterForm($fields)
    {

        if (!Auth::user()->can('report::criar-admin')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 
        
        $form = '<form method="GET" action="{{ url()->current() }}" class="mb-3">';
        $form .= '<div class="row">';
        foreach ($fields as $field) {
            if (($field->is_filter ?? isset($field->isFilter)) && ($field->visible_filter ?? isset($field->visible_filter))) {
                $label = $field->alias ?? str_replace('::', '.', $field->field);
                $fieldName = str_replace('::', '_', $field->field); // Substitua "::" por "_" para os nomes dos inputs

                if ($field->filter_operator == "BETWEEN") {
                    // Verifica o tipo de filtro e cria o campo adequado
                    if ($field->field_type === 'text') {
                        // Campo de texto
                        $form .= '<div class="form-group mb-3 col-6">
                                <label for="' . $fieldName . '_start">' . $label . ' Inicio</label>
                                <input type="text" class="form-control" id="' . $fieldName . '_start" name="' . $fieldName . '_start" placeholder="Filtro: ' . $label . ' Inicio" value="{{ request(\'' . $fieldName . '_start' . '\') }}">
                              </div>';
                        $form .= '<div class="form-group mb-3 col-6">
                              <label for="' . $fieldName . '_end">' . $label . ' Fim</label>
                              <input type="text" class="form-control" id="' . $fieldName . '_end" name="' . $fieldName . '_end" placeholder="Filtro: ' . $label . ' Fim" value="{{ request(\'' . $fieldName . '_end' . '\') }}">
                            </div>';
                    } elseif ($field->field_type === 'number') {
                        // Campo numérico
                        $form .= '<div class="form-group mb-3 col-6">
                                <label for="' . $fieldName . '_start">' . $label . ' Inicio</label>
                                <input type="number" class="form-control" id="' . $fieldName . '_start" name="' . $fieldName . '_start" placeholder="Filtro: ' . $label . ' Inicio" value="{{ request(\'' . $fieldName . '_start' . '\') }}">
                              </div>';
                        $form .= '<div class="form-group mb-3 col-6">
                              <label for="' . $fieldName . '_end">' . $label . ' Fim</label>
                              <input type="number" class="form-control" id="' . $fieldName . '_end" name="' . $fieldName . '_end" placeholder="Filtro: ' . $label . ' Fim" value="{{ request(\'' . $fieldName . '_end' . '\') }}">
                            </div>';
                    } elseif ($field->field_type === 'date') {
                        // Intervalo de datas
                        $form .= '<div class="form-group mb-3 col-6">
                                <label for="' . $fieldName . '_start">' . $label . ' Início</label>
                                <input type="date" class="form-control" id="' . $fieldName . '_start" name="' . $fieldName . '_start" placeholder="Data início" value="{{ request(\'' . $fieldName . '_start' . '\') }}">
                              </div>';
                        $form .= '<div class="form-group mb-3 col-6">
                                <label for="' . $fieldName . '_end">' . $label . ' Fim</label>
                                <input type="date" class="form-control" id="' . $fieldName . '_end" name="' . $fieldName . '_end" placeholder="Data fim" value="{{ request(\'' . $fieldName . '_end' . '\') }}">
                              </div>';
                    }
                } else {
                    // Verifica o tipo de filtro e cria o campo adequado
                    if ($field->field_type === 'text') {
                        // Campo de texto
                        $form .= '<div class="form-group mb-3 col-6">
                                <label for="' . $fieldName . '">' . $label . '</label>
                                <input type="text" class="form-control" id="' . $fieldName . '" name="' . $fieldName . '" placeholder="Filtro: ' . $label . '" value="{{ request(\'' . $fieldName . '\') }}">
                              </div>';
                    } elseif ($field->field_type === 'number') {
                        // Campo numérico
                        $form .= '<div class="form-group mb-3 col-6">
                                <label for="' . $fieldName . '">' . $label . '</label>
                                <input type="number" class="form-control" id="' . $fieldName . '" name="' . $fieldName . '" placeholder="Filtro: ' . $label . '" value="{{ request(\'' . $fieldName . '\') }}">
                              </div>';
                    } elseif ($field->field_type === 'date') {
                        // Intervalo de datas
                        $form .= '<div class="form-group mb-3 col-6">
                                <label for="' . $fieldName . '">' . $label . '</label>
                                <input type="date" class="form-control" id="' . $fieldName . '" name="' . $fieldName . '" placeholder="Data" value="{{ request(\'' . $fieldName . '\') }}">
                              </div>';
                    } elseif ($field->field_type === 'boolean') {
                        $form .= '<div class="form-group mb-3 col-6">';
                        $form .= '<label for="' . $fieldName . '">' . $label . '</label>';
                        $form .= '<select class="form-control" name="' . $fieldName . '">';
                        $form .= '<option value="true" {{ request(\'' . $fieldName . '\') == "true" ? "selected" : "" }}>Sim</option>';
                        $form .= '<option value="false" {{ request(\'' . $fieldName . '\') == "false" ? "selected" : "" }}>Não</option>';
                        $form .= '</select>';
                        $form .= '</div>';
                    }
                }
            }
        }

        // Botão de submissão dos filtros
        $form .= '</div>';
        $form .= '<button type="submit" class="btn btn-primary mb-2">Filtrar</button>';
        $form .= '</form>';

        return $form;
    }

    // Método para executar o relatório
    public function executeReport($reportUuid, Request $request)
    {
        // Passo 1: Recuperar o modelo de relatório com SQL salvo
        $report = ReportModel::with(['relationships', 'fields', 'layout'])->where('uuid', $reportUuid)->firstOrFail();
        $sql = $report->layout->sql_query; // Recupera o SQL salvo

        // Passo 2: Preparar os parâmetros de filtro com base na requisição
        $bindings = [];
        foreach ($report->fields->where('is_filter', true) as $field) {
            $filterKey = str_replace('::', '_', $field->field);
            $requestValue = $request->input($filterKey);

            if ($requestValue) {
                // Adicionar ao array de bindings com os placeholders
                $bindings[":{$filterKey}_param"] = $requestValue;
            } else {
                switch ($field->field_type) {
                    case 'text':
                        $requestValue = !is_null($field->default_value) ? $field->default_value : '';
                        break;
                    case 'number':
                        $requestValue = !is_null($field->default_value) ? $field->default_value : 0;
                        break;
                    case 'boolean':
                        $requestValue = !is_null($field->default_value) ? $field->default_value : true;
                        break;
                    case 'date':
                        $requestValue = !is_null($field->default_value) ? $field->default_value : '';
                        break;
                }

                if ($field->filter_operator !== 'BETWEEN') {
                    $bindings[":{$filterKey}_param"] = $requestValue;
                }
            }

            if ($field->filter_operator === 'BETWEEN' && $field->field_type === 'date') {
                $bindings[":{$filterKey}_param_start"] = $request->input("{$filterKey}_start") ? $request->input("{$filterKey}_start") . ' 00:00:00' : '1900-01-01 00:00:00';
                $bindings[":{$filterKey}_param_end"] = $request->input("{$filterKey}_end") ? $request->input("{$filterKey}_end") . ' 23:59:59' : '3000-01-01 00:00:00';
            } else if ($field->filter_operator === 'BETWEEN') {
                $bindings[":{$filterKey}_param_start"] = is_null($request->input("{$filterKey}_start")) ? 0 : $request->input("{$filterKey}_start");
                $bindings[":{$filterKey}_param_end"] = is_null($request->input("{$filterKey}_end")) ? 0 : $request->input("{$filterKey}_end");
            }
        }

        $sql = str_replace(array_keys($bindings), array_values($bindings), $sql);
        // dd($bindings, $sql);
        // Passo 3: Executar o SQL com bindings seguros
        $results = DB::select($sql);
        // $results = [];

        // Passo 4: Renderizar a view com o template salvo na base
        $htmlFromDatabase = $report->layout->blade_template; // Aqui você recupera a view salva no banco

        // Compilar o template Blade
        $compiledHtml = Blade::compileString($htmlFromDatabase);

        // Renderizar o HTML com os dados retornados da consulta
        $htmlOutput = Blade::render($compiledHtml, ['results' => $results]);

        // Retornar o HTML renderizado como resposta
        echo $htmlOutput; // Aqui você pode criar um layout específico para exibir os relatórios
    }

    private function arrayToObject($array)
    {

        // Converte o array em objeto
        return json_decode(json_encode(array_map(function ($item) {
            return $item;
        }, $array)));
    }
}
