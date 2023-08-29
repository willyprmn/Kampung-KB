<?php

namespace App\DataTables\Portal\Statistik;

use Cache;
use App\Models\Portal\Statistik\PenggunaanDatum;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\DataTables\Portal\Statistik\FilterRegional;

class PenggunaanDataDataTable extends CachedDataTable
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
     * @param \App\Models\Portal\Statistik\PenggunaanDatum $model
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
        $request['statistic'] = 'penggunaan-data';
        $key = md5(json_encode($request));

        #set 1 day expired cache
        $data = Cache::remember($key, config('kpkb.statistik.cache.lifetime'), function (){

            $sql = file_get_contents(base_path('database/sql/statistik/penggunaan-data.sql'));
            #alias table master
            $provinsi = "e";
            $kabupaten = "f";
            $kecamatan = "g";
            $desa = "h";

            $request = request();
            $filterRegional = $this->filterRegional->getQueryCondition($request, $provinsi, $kabupaten, $kecamatan, $desa);

            $tableMaster = $filterRegional['tableMaster'];
            $whereMaster = $filterRegional['whereMaster'];
            $where = $filterRegional['where'];
            $grouping = $filterRegional['grouping'];
            $whereHistory = $filterRegional['whereHistory'];

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
                'initComplete' => <<<JAVASCRIPT
                    function (setting, json) {
                        $(`
                            <tr>
                                <th></th>
                                <th></th>
                                <th colspan="2">PK dan Pemutahiran Data</th>
                                <th colspan="2">Data Rutin BKKBN</th>
                                <th colspan="2">Potensi Desa</th>
                                <th colspan="2">Data Sektoral</th>
                                <th colspan="2">Lainnya</th>
                                <th colspan="2">Tidak Menggunakan Data</th>
                                <th colspan="2">Belum Isi</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        `).insertAfter(`#titleHeader`)
                    }
JAVASCRIPT
            ])
            ->drawCallback("function() {
                var table = $('#datatable').DataTable();
                $('#datatable').on( 'draw.dt', function () {
                    var columnLength = document.getElementById('datatable').rows[1].cells.length - 1;
                    var sumTotal = table.column(columnLength).data().sum();

                    var rowTotal = '<tr id=" . '"total"' . "name=" . '"total"' . " style=". '"font-weight:bold; "' . " class=". '"even"' . "><td></td> <td> Total </td>';

                    for(i = 2; i < 16; i++){
                        var sumData = table.column(i).data().sum();
                        var sumDataPersen = (sumData/sumTotal) * 100;

                        rowTotal += '<td class=".'colnum'.">' + sumData  + '</td>';
                        rowTotal += '<td class=".'colnum'.">' + ((isNaN(sumDataPersen)) ? 0 : parseFloat(sumDataPersen).toFixed(2))  + '</td>';

                        i +=1; //add 1 jump to next column to get sum of value column
                    }

                    var penggunaan_data_1 = table.column(16).data().sum();
                    var penggunaan_data_2 = table.column(17).data().sum();
                    var penggunaan_data_3 = table.column(18).data().sum();

                    rowTotal += '<td class=".'colnum'.">' + penggunaan_data_1  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + penggunaan_data_2  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + penggunaan_data_3  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + sumTotal  + '</td>';
                    rowTotal += '</tr>'

                    if ($('#total').length) {
                        $('#total').remove();
                    }
                    $('#datatable').append(rowTotal);

                    //generate header title
                    generateHeader();

                } );
            }");
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'no' => [
                'title' => 'No',
                'render' => 'meta.row + meta.settings._iDisplayStart + 1',
                'orderable' => false
            ],
            'nama' => ['title' => 'Provinsi', 'width' => '40%', 'orderable' => false],
            'pemutahiran_data' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'pemutahiran_data_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'data_rutin' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'data_rutin_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'potensi_desa' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'potensi_desa_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'data_sektoral' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'data_sektoral_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'lainnya' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'lainnya_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'tidak_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'tidak_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'belum_isi' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'belum_isi_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'penggunaan_data_1' => [
                'title' => 'Menggunakan 1 Jenis Data',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'penggunaan_data_2' => [
                'title' => 'Menggunakan 2 Jenis Data',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'penggunaan_data_3' => [
                'title' => 'Menggunakan > 2 Jenis Data',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'total' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'penggunaan-data-table_' . date('YmdHis');
    }
}
