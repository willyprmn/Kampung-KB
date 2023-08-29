<?php

namespace App\DataTables\Portal\Statistik;

use Cache;
use App\Models\Portal\Statistik\KepemilikanPoktan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\DataTables\Portal\Statistik\FilterRegional;

class KepemilikanPoktanDataTable extends CachedDataTable
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
     * @param \App\Models\Portal\Statistik\KepemilikanPoktan $model
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
        $request['statistic'] = 'poktan';
        $key = md5(json_encode($request));

        #set 1 day expired cache
        $data = Cache::remember($key, config('kpkb.statistik.cache.lifetime'), function (){

            $sql = file_get_contents(base_path('database/sql/statistik/kepemilikan-poktan.sql'));
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
                                <th colspan="4">BKB</th>
                                <th colspan="4">BKR</th>
                                <th colspan="4">BKL</th>
                                <th colspan="4">UPPKA</th>
                                <th colspan="4">PIK-R</th>
                                <th colspan="4">POKTAN</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th colspan="2">Ada</th>
                                <th colspan="2">Tidak Ada</th>
                                <th colspan="2">Ada</th>
                                <th colspan="2">Tidak Ada</th>
                                <th colspan="2">Ada</th>
                                <th colspan="2">Tidak Ada</th>
                                <th colspan="2">Ada</th>
                                <th colspan="2">Tidak Ada</th>
                                <th colspan="2">Ada</th>
                                <th colspan="2">Tidak Ada</th>
                                <th colspan="2">Ada</th>
                                <th colspan="2">Tidak Ada</th>
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

                    var rowTotal = '<tr id=" . '"total"' . "name=" . '"total"' . " style=". '"font-weight:bold; "' . " class=". '"even"' . "><td class=".'colnum'."></td> <td > Total </td>';

                    for(i = 2; i < 26; i++){
                        var sumData = table.column(i).data().sum();
                        var sumDataPersen = (sumData/sumTotal) * 100;

                        rowTotal += '<td class=".'colnum'.">' + sumData  + '</td>';
                        rowTotal += '<td class=".'colnum'.">' + ((isNaN(sumDataPersen)) ? 0 : parseFloat(sumDataPersen).toFixed(2))  + '</td>';

                        console.log(i);
                        i +=1; //add 1 jump to next column to get sum of value column
                    }

                    var sumPoktan1 = table.column(26).data().sum();
                    var sumPoktan2 = table.column(27).data().sum();
                    var sumPoktan3 = table.column(28).data().sum();

                    rowTotal += '<td class=".'colnum'.">' + sumPoktan1  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + sumPoktan2  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + sumPoktan3  + '</td>';
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
            'bkb_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkb_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkb_tidak_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkb_tidak_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkr_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkr_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkr_tidak_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkr_tidak_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkl_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkl_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkl_tidak_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkl_tidak_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'uppks_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'uppks_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'uppks_tidak_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'uppks_tidak_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'pikr_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'pikr_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'pikr_tidak_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'pikr_tidak_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'poktan_tidak_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'poktan_tidak_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'poktan_belum_ada' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'poktan_belum_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'poktan_1_2' => [
                'title' => 'Memiliki 1-2 Jenis Poktan',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'poktan_3_4' => [
                'title' => 'Memiliki 4-4 Jenis Poktan',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'poktan_5' => [
                'title' => 'Memiliki 5 Jenis Poktan',
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
        return 'kepemilikan-poktan-table_' . date('YmdHis');
    }
}
