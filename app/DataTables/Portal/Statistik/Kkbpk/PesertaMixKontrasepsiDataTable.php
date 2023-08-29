<?php

namespace App\DataTables\Portal\Statistik\Kkbpk;

use Cache;
use App\Models\Portal\Statistik\Kkbpk\PesertaMixKontrasepsi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\DataTables\Portal\Statistik\FilterRegional;

class PesertaMixKontrasepsiDataTable extends CachedDataTable
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
     * @param \App\Models\Portal\Statistik\Kkbpk\PesertaMixKontrasepsi $model
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
        $request['statistic'] = 'kkbpk-mix-kontrasepsi';
        $key = md5(json_encode($request));

        #set 1 day expired cache
        $data = Cache::remember($key, config('kpkb.statistik.cache.lifetime'), function (){

            $sql = file_get_contents(base_path('database/sql/statistik/kkbpk/peserta-mix-kontrasepsi.sql'));
            #alias table master
            $provinsi = "d";
            $kabupaten = "e";
            $kecamatan = "f";
            $desa = "g";

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
                                <th colspan="2">Implan</th>
                                <th colspan="2">UID</th>
                                <th colspan="2">Kondom</th>
                                <th colspan="2">MOP</th>
                                <th colspan="2">MOW</th>
                                <th colspan="2">PIL</th>
                                <th colspan="2">Suntik</th>
                                <th></th>
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
                    var columnLength = document.getElementById('datatable').rows[2].cells.length - 1;
                    var sumTotal = table.column(columnLength).data().sum();

                    var rowTotal = '<tr id=" . '"total"' . "name=" . '"total"' . " style=". '"font-weight:bold; "' . " class=". '"even"' . "> <td colspan=2> Total </td>';
                    var sumJumlahPeserta = table.column(columnLength - 3).data().sum();

                    for(i = 2; i < (columnLength - 5); i++){

                        var sumData = table.column(i).data().sum();
                        var sumDataPersen = (sumData/sumJumlahPeserta) * 100;

                        rowTotal += '<td class=".'colnum'.">' + sumData  + '</td>';
                        rowTotal += '<td class=".'colnum'.">' + ((isNaN(sumDataPersen)) ? 0 : parseFloat(sumDataPersen).toFixed(2))  + '</td>';
                        i++;

                    }
                    var sumPUS = table.column(16).data().sum();
                    var sumKontrasepsi = table.column(17).data().sum();
                    var sumIsi = table.column(18).data().sum();
                    var sumBelumIsi = table.column(19).data().sum();

                    rowTotal += '<td class=".'colnum'.">' + sumPUS  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + sumKontrasepsi  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + sumIsi  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + sumBelumIsi  + '</td>';
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
            'regional' => [
                'title' => 'Provinsi', 'width' => '40%',
                'orderable' => false,
            ],
            'implan' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum',
            ],
            'implan_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'iud' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum',
            ],
            'iud_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'kondom' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum',
            ],
            'kondom_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'mop' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum',
            ],
            'mop_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'mow' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum',
            ],
            'mow_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'pil' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum',
            ],
            'pil_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'suntik' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum',
            ],
            'suntik_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'total_kontrasepsi' => [
                'title' => 'Jumlah Peserta KB',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'pus' => [
                'title' => 'Jumlah PUS',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'ada' => [
                'title' => 'Kampung KB yang Mengisi',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'belum' => [
                'title' => 'Kampung KB Yang Belum Isi',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'total' => [
                'title' => __('statistik.regional_jumlah'),
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
        return 'kkbpk-mix-kontrasepsi_' . date('YmdHis');
    }
}
