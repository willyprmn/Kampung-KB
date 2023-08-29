<?php

namespace App\DataTables\Portal\Statistik;

use Cache;
use App\Models\Portal\Statistik\SumberDana;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\DataTables\Portal\Statistik\FilterRegional;

class SumberDanaDataTable extends CachedDataTable
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
     * @param \App\Models\Portal\Statistik\SumberDana $model
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
        $request['statistic'] = 'sumber-dana';
        $key = md5(json_encode($request));

        #set 1 day expired cache
        $data = Cache::remember($key, config('kpkb.statistik.cache.lifetime'), function (){

            $sql = file_get_contents(base_path('database/sql/statistik/sumber-dana.sql'));
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
                                <th colspan="2">APBD</th>
                                <th colspan="2">APBN</th>
                                <th colspan="2">Dana Desa</th>
                                <th colspan="2">Donasi</th>
                                <th colspan="2">Perusahaan</th>
                                <th colspan="2">Swadaya</th>
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

                    var sumAPBD = table.column(2).data().sum();
                    var sumAPBDPersen = (sumAPBD/sumTotal) * 100;
                    var sumAPBN = table.column(4).data().sum();
                    var sumAPBNPersen = (sumAPBN/sumTotal) * 100;
                    var sumDanaDesa = table.column(6).data().sum();
                    var sumDanaDesaPersen = (sumDanaDesa/sumTotal) * 100;
                    var sumDonasi = table.column(8).data().sum();
                    var sumDonasiPersen = (sumDonasi/sumTotal) * 100;
                    var sumPerusahaan = table.column(10).data().sum();
                    var sumPerusahaanPersen = (sumPerusahaan/sumTotal) * 100;
                    var sumSwadaya = table.column(12).data().sum();
                    var sumSwadayaPersen = (sumSwadaya/sumTotal) * 100;
                    var sumBelumIsi = table.column(14).data().sum();
                    var sumBelumIsiPersen = (sumBelumIsi/sumTotal) * 100;
                    var sumSumber1 = table.column(16).data().sum();
                    var sumSumber2 = table.column(17).data().sum();
                    var sumSumber3 = table.column(18).data().sum();

                    if ($('#total').length) {
                        $('#total').remove();
                    }
                    $('#datatable').append('<tr id=" . '"total"' . "name=" . '"total"' . " style=". '"font-weight:bold; "' . " class=". '"even"' . "><td></td><td>Jumlah</td> " .
                        "<td class=".'colnum'.">' + sumAPBD  + ' </td> " .
                        "<td class=".'colnum'.">' + parseFloat(sumAPBDPersen).toFixed(2)  + '</td> ".
                        "<td class=".'colnum'.">' + sumAPBN  + '</td> <td>' + parseFloat(sumAPBNPersen).toFixed(2)  + '</td> " .
                        "<td class=".'colnum'.">' + sumDanaDesa  + '</td> <td>' + parseFloat(sumDanaDesaPersen).toFixed(2)  + '</td> " .
                        "<td class=".'colnum'.">' + sumDonasi  + '</td> <td>' + parseFloat(sumDonasiPersen).toFixed(2)  + '</td> " .
                        "<td class=".'colnum'.">' + sumPerusahaan  + '</td> <td>' + parseFloat(sumPerusahaanPersen).toFixed(2)  + '</td> " .
                        "<td class=".'colnum'.">' + sumSwadaya  + '</td> <td>' + parseFloat(sumSwadayaPersen).toFixed(2)  + '</td> " .
                        "<td class=".'colnum'.">' + sumBelumIsi  + '</td> <td>' + parseFloat(sumBelumIsiPersen).toFixed(2)  + '</td> " .
                        "<td class=".'colnum'.">' + sumSumber1  + ' </td> " .
                        "<td class=".'colnum'.">' + sumSumber2  + ' </td> " .
                        "<td class=".'colnum'.">' + sumSumber3  + ' </td> " .
                        "<td class=".'colnum'.">' + sumTotal  + '</td> </tr>');
                } );

                //generate header title
                generateHeader();
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
            'regional' => ['title' => 'Provinsi', 'width' => '40%', 'orderable' => false],
            'apbd' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'apbd_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'apbn' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'apbn_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'dana_desa' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'dana_desa_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'donasi' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'donasi_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'perusahaan' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'perusahaan_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'swadaya' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'swadaya_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'belum_isi' => [
                'title' => 'Jumlah',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'belum_isi_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'sumber_1' => [
                'title' => '1 Sumber Dana',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'sumber_2' => [
                'title' => '2-3 Sumber Dana',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'sumber_3' => [
                'title' => '4 Sumber Dana',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'total' => [
                'title' => 'Jumlah',
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
        return 'sumber-dana-table_' . date('YmdHis');
    }
}
