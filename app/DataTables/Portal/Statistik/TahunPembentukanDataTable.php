<?php

namespace App\DataTables\Portal\Statistik;

use Cache;
use Str;

use App\Models\Portal\Statistik\TahunPembentukan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;
use Marsflow\CachedDataTable\Services\CachedDataTable;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use App\DataTables\Portal\Statistik\FilterRegional;

class TahunPembentukanDataTable extends CachedDataTable
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
     * @param \App\Models\Portal\Statistik\TahunPembentukan $model
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
        $request['statistic'] = 'tahun-pembentukan';
        $key = md5(json_encode($request));

        #set 1 day expired cache
        $data = Cache::remember($key, config('kpkb.statistik.cache.lifetime'), function (){
            $sql = file_get_contents(base_path('database/sql/statistik/tahun-pembentukan.sql'));

            #search codition
            #initial table
            $provinsi = "b";
            $kabupaten = "c";
            $kecamatan = "d";
            $desa = "e";

            $request = request();
            $filterRegional = $this->filterRegional->getQueryCondition($request, $provinsi, $kabupaten, $kecamatan, $desa);

            $tableMaster = $filterRegional['tableMaster'];
            $whereMaster = $filterRegional['whereMaster'];
            $where = $filterRegional['where'];
            $grouping = $filterRegional['grouping'];

            $sql = sprintf($sql, $grouping, str_replace("'", "''", $where), $tableMaster, str_replace("'", "''", $whereMaster));

            $data = DB::select($sql);

            return DB::select("select * from ct_view order by id");
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
            ->orderBy(0, 'asc')
            // ->scrollX(true)
            ->parameters([
                'buttons' => [
                    [
                        'extend' =>'excel', 'footer' => true,
                    ]
                ],
            ])
            ->drawCallback("function() {
                var table = $('#datatable').DataTable();
                $('#datatable').on( 'draw.dt', function () {
                    var columnLength = document.getElementById('datatable').rows[1].cells.length - 1;
                    var i;
                    var rowTotal = '<tr id=" . '"total"' . "name=" . '"total"' . " style=". '"font-weight:bold; "' . " class=". '"even"' . "> <td></td><td> Total </td>';

                    for(i = 2; i < (columnLength); i++){
                        //sum column total
                        var sumTotal = table.column(columnLength).data().sum();

                        var sumData = table.column(i).data().sum();
                        var sumDataPersen = (100*sumData)/sumTotal;

                        rowTotal += '<td class=" . 'colnum' . ">' + (isNaN(sumData) ? 0 : sumData ) + '</td>';
                        rowTotal += '<td class=" . 'colnum' . ">' + ((isNaN(sumDataPersen)) ? 0 : parseFloat(sumDataPersen).toFixed(2)) + '</td>';

                        i +=1; //add 1 jump to next column to get sum of value column
                    }
                    rowTotal += '<td class=\"colnum\">' + table.column(columnLength).data().sum()  + '</td>';
                    rowTotal += '</tr>'

                    if ($('#total').length) {
                        $('#total').remove();
                    }
                    // var column = table.column( 0 );
                    // $(rowTotal).appendTo($(column.footer()).empty())
                    $('#datatable').append(rowTotal);

                    //generate header title
                    generateHeader();
                });
            }")
            ;
    }


    protected function yearSplit($header)
    {

        if (Str::contains($header, ['TAHUN'])) {
            return Str::replaceFirst('_', ' ', $header);
        }

        return $header;
    }


    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $query = $this->query();
        if(count($query) !== 0){
            $datas = json_decode(json_encode($query), true);
            //get first row
            $data = array_keys($datas[0]);

            $arrayColumn = array('id' => [
                'title' => 'No',
                'render' => 'meta.row + meta.settings._iDisplayStart + 1',
                'orderable' => false
            ]);
            $columns = array_map(function($item) use(&$arrayColumn){

                $arrayColumn[(string) $item] = [
                    'title' => $this->yearSplit(strtoupper((string) $item)),
                    'orderable' => false,
                    'className' => !in_array($item, ['id', 'provinsi']) ? 'colnum' : '',
                ];

                if (!in_array($item, ['id', 'provinsi']) && $item !== 'total') {

                    $persenColumn = ['render' => 'full.' . $item];

                    $arrayColumn['persen_' . $item] = [
                        'title' => '%',
                        'render' => '(isNaN((100*full.' . (string)$item . ')/full.total)) ? 0 : parseFloat((100*full.' . (string)$item . ')/full.total).toFixed(2)',
                        'orderable' => false,
                        'className' => 'colnum',
                    ];

                }

                return [
                    $item => ['title' => (string)$item]
                ];

            }, $data);

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
        return 'TahunPembentukan_' . date('YmdHis');
    }
}
