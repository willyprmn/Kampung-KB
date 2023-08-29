<?php

namespace App\DataTables\Portal\Statistik;

use Cache;
use App\Models\Portal\Statistik\KepemilikanPlkbPendamping;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\DataTables\Portal\Statistik\FilterRegional;

class KepemilikanPlkbPendampingDataTable extends CachedDataTable
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
     * @param \App\Models\Portal\Statistik\KepemilikanPlkbPendamping $model
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
        $request['statistic'] = 'plkb-pendamping';
        $key = md5(json_encode($request));

        #set 1 day expired cache
        $data = Cache::remember($key, config('kpkb.statistik.cache.lifetime'), function (){

            $sql = file_get_contents(base_path('database/sql/statistik/kepemilikan-plkb-pendamping.sql'));

            #alias table master
            $provinsi = "c";
            $kabupaten = "d";
            $kecamatan = "e";
            $desa = "f";

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
                                <th colspan="2">Ada</th>
                                <th colspan="2">Tidak Ada</th>
                                <th colspan="2">Belum Isi</th>
                                <th></th>
                            </tr>
                        `).insertAfter(`#titleHeader`)
                    }
JAVASCRIPT
            ])
            ->drawCallback("function() {
                var table = $('#datatable').DataTable();
                $('#datatable').on( 'draw.dt', function () {
                    var sumTotal = table.column(8).data().sum();
                    var sumAda = table.column(2).data().sum();
                    var sumAdaPersen = (sumAda/sumTotal) * 100;
                    var sumTidakAda = table.column(4).data().sum();
                    var sumTidakAdaPersen = (sumTidakAda/sumTotal) * 100;
                    var sumBelumAda = table.column(6).data().sum();
                    var sumBelumAdaPersen = (sumBelumAda/sumTotal) * 100;
                    if ($('#total').length) {
                        $('#total').remove();
                    }
                    $('#datatable').append('<tr id=" . '"total"' . "name=" . '"total"' . " style=". '"font-weight:bold; "' . " class=". '"even"' . ">".
                        "<td colspan=" . '"2"' . ">Jumlah</td> " .
                        "<td class=".'colnum'.">' + sumAda  + ' </td> <td>' + ((isNaN(sumAdaPersen)) ? 0 : parseFloat(sumAdaPersen).toFixed(2))  + '</td> ".
                        "<td class=".'colnum'.">' + sumTidakAda  + '</td> <td>' + ((isNaN(sumTidakAdaPersen)) ? 0 : parseFloat(sumTidakAdaPersen).toFixed(2))  + '</td> ".
                        "<td class=".'colnum'.">' + sumBelumAda  + '</td> <td>' + ((isNaN(sumBelumAdaPersen)) ? 0 : parseFloat(sumBelumAdaPersen).toFixed(2))  + '</td> ".
                        "<td class=".'colnum'.">' + sumTotal  + '</td> </tr>'
                    );

                    //generate header title
                    generateHeader();

                });
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
            'ada' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
            ],
            'ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'tidak_ada' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
            ],
            'tidak_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'belum_ada' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
            ],
            'belum_ada_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'total' => [
                'title' => __('statistik.regional_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
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
        return 'kepemilikan-plbk-pendamping-table_' . date('YmdHis');
    }
}
