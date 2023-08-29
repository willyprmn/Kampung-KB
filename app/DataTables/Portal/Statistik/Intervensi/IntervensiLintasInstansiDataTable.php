<?php

namespace App\DataTables\Portal\Statistik\Intervensi;

use Cache;
use App\Models\Portal\Statistik\IntervensiLintasInstansi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\DataTables\Portal\Statistik\FilterRegional;

class IntervensiLintasInstansiDataTable extends CachedDataTable
{
    protected $filterRegional;
    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->filterRegional = new FilterRegional();
    }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->collection($query)
            ->skipPaging();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Portal\Statistik\IntervensiLintasInstansi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        //initiate key cache
        $request = $this->request->all();
        $request['url'] = $this->request->url();
        unset($request['draw']);
        unset($request['_']);
        $request['columnDef'] = $this->columnDef;
        $request['statistic'] = 'intervensi-lintas-instansi';
        $key = md5(json_encode($request));


        #set 1 day expired cache
        $data = Cache::remember($key, config('kpkb.statistik.cache.lifetime'), function (){

            #alias table master
            $provinsi = "e";
            $kabupaten = "f";
            $kecamatan = "g";
            $desa = "h";

            $request = request();
            $sql = file_get_contents(base_path('database/sql/statistik/intervensi/intervensi-lintas-sektor-tabular.sql'));
            $filterRegional = $this->filterRegional->getQueryCondition($request, $provinsi, $kabupaten, $kecamatan, $desa);

            $tableMaster = $filterRegional['tableMaster'];
            $whereMaster = $filterRegional['whereMaster'];
            $where = $filterRegional['where'];
            $grouping = $filterRegional['grouping'];
            $whereHistory = str_replace('and is_active is true', '', str_replace('created_at', 'b.created_at', $filterRegional['whereHistory']));

            $sql = sprintf($sql, $tableMaster, $grouping, $where, $whereMaster, $whereHistory);
            $data_pivot = DB::select($sql);

            $filterRegional = $this->filterRegional->getQueryCondition($request, $provinsi, $kabupaten, $kecamatan, $desa);

            $sql = file_get_contents(base_path('database/sql/statistik/intervensi/intervensi-lintas-sektor.sql'));
            $tableMaster = $filterRegional['tableMaster'];
            $whereMaster = $filterRegional['whereMaster'];
            $where = $filterRegional['where'];
            $grouping = $filterRegional['grouping'];
            $whereHistory = str_replace('and is_active is true', '', str_replace('created_at', 'b.created_at', $filterRegional['whereHistory']));

            $sql = sprintf($sql, $tableMaster, $grouping, $where, $whereMaster, $whereHistory);

            return DB::select($sql);
        });

        return $data;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('datatable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt')
            ->orderBy(1, 'asc')
            ->parameters([
                'buttons' => ['excel'],
            ])
            ->drawCallback("function() {
                var table = $('#datatable').DataTable();
                $('#datatable').on( 'draw.dt', function () {
                    var columnLength = document.getElementById('datatable').rows[1].cells.length - 1;
                    var sumTotal = table.column(columnLength).data().sum();

                    var rowTotal = '<tr id=" . '"total"' . "name=" . '"total"' . " style=". '"font-weight:bold; "' . " class=". '"even"' . "> <td colspan=2> Total </td>';
                    var columnIntansi = columnLength - 4;

                    for(i = 2; i < (columnIntansi); i++){
                        var sumData = table.column(i).data().sum();
                        var sumDataPersen = (parseFloat(sumData)/parseFloat(sumTotal)) * 100;

                        rowTotal += '<td class=".'colnum'.">' + sumData  + '</td>';
                        rowTotal += '<td class=".'colnum'.">' + parseFloat(sumDataPersen).toFixed(2)  + '</td>';

                        i +=1; //add 1 jump to next column to get sum of value column
                    }

                    var instansi_1 = table.column(columnIntansi).data().sum();
                    var instansi_2 = table.column(columnIntansi + 1).data().sum();
                    var instansi_3 = table.column(columnIntansi + 2).data().sum();
                    var belum_isi = table.column(columnIntansi + 3).data().sum();

                    rowTotal += '<td class=".'colnum'.">' + instansi_1  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + instansi_2  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + instansi_3  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + belum_isi  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + sumTotal + '</td>';
                    rowTotal += '</tr>'

                    if ($('#total').length) {
                        $('#total').remove();
                    }

                    $('#datatable').append(rowTotal);

                    //generate header title
                    generateHeader();

                } );
            }")
            ;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $instansis = DB::table("new_instansi")->orderBy('id')->get()->toArray();
        $query = $this->query();

        if(count($query) !== 0){

            //get master instansi for mapping
            $instansis = json_decode(json_encode($instansis), true);

            $arrayColumn = array(
                'id' => [
                    'title' => 'No',
                    'render' => 'meta.row + meta.settings._iDisplayStart + 1', 'orderable' => false
                ],
                'regional' => [
                    'title' => 'Provinsi', 'orderable' => false
                ]
            );

            //mapping by instansis
            array_map(function($item) use(&$arrayColumn){
                // dd($item);
                $arrayColumn[(string)$item['alias']] = [
                    'title' => (string)$item['name'],
                    'orderable' => false,
                    'className' => 'colnum',
                ];

                $arrayColumn[$item['alias'] . 'persen'] = [
                    'title' => '%',
                    'render' => '((isNaN(parseFloat(full.' . (string)$item['alias'] . '/full.total_kampung).toFixed(2))) ? 0 : parseFloat(full.' . (string)$item['alias'] . '/full.total_kampung).toFixed(2))',
                    'orderable' => false,
                    'className' => 'colnum',
                ];
                return [];
            }, $instansis);

            // dd($arrayColumn);
            $arrayColumn['instansi_1'] = [
                'title' => 'Terintegrasi 1-3 Lintas Sektor',
                'orderable' => false,
                'className' => 'colnum',
            ];
            $arrayColumn['instansi_2'] = [
                'title' => 'Terintegrasi 4-7 Lintas Sektor',
                'orderable' => false,
                'className' => 'colnum',
            ];
            $arrayColumn['instansi_3'] = [
                'title' => 'Terintegrasi Dengan Lebih Dari 7 Lintas Sektor',
                'orderable' => false,
                'className' => 'colnum',
            ];
            $arrayColumn['belum_isi'] = [
                'title' => 'Belum Isi',
                'orderable' => false,
                'className' => 'colnum',
            ];
            $arrayColumn['total_kampung'] = [
                'title' => __('statistik.regional_jumlah'),
                'orderable' => false,
                'className' => 'colnum',
            ];
            return $arrayColumn;
        }
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'intervensi-lintas-sektor-table_' . date('YmdHis');
    }
}
