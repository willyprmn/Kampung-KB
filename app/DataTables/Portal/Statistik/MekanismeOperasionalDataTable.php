<?php

namespace App\DataTables\Portal\Statistik;

use Cache;
use App\Models\Portal\Statistik\MekanismeOperasional;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\DataTables\Portal\Statistik\FilterRegional;

class MekanismeOperasionalDataTable extends CachedDataTable
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
     * @param \App\Models\Portal\Statistik\MekanismeOperasional $model
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
        $request['statistic'] = 'mekaniskme-operasional';
        $key = md5(json_encode($request));

        #set 1 day expired cache
        $data = Cache::remember($key, config('kpkb.statistik.cache.lifetime'), function (){

            $sql = file_get_contents(base_path('database/sql/statistik/mekanisme-operasional.sql'));
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
                                <th colspan="2">Rapat Perencanaan Kagiatan</th>
                                <th colspan="2">Koordinasi dengan Lintas Sektor Terkait Pendukung Kegiatan</th>
                                <th colspan="2">Sosialisasi Kegiatan</th>
                                <th colspan="2">Monitoring dan Evaluasi Kegiatan</th>
                                <th colspan="2">Penyusunan Laporan</th>
                                <th colspan="2">Tidak Melakukan Kegiatan Mekop</th>
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
                    var columnLength = document.getElementById('datatable').rows[1].cells.length - 1;
                    var sumTotal = table.column(columnLength).data().sum();

                    var rowTotal = '<tr id=" . '"total"' . "name=" . '"total"' . "  style=". '"font-weight:bold; "' . " class=". '"even"' . "><td></td> <td> Total </td>';

                    for(i = 2; i < 14; i++){
                        var sumData = table.column(i).data().sum();
                        var sumDataPersen = (sumData/sumTotal) * 100;

                        rowTotal += '<td class=".'colnum'.">' + sumData  + '</td>';
                        rowTotal += '<td class=".'colnum'.">' + ((isNaN(sumDataPersen)) ? 0 : parseFloat(sumDataPersen).toFixed(2))  + '</td>';

                        i +=1; //add 1 jump to next column to get sum of value column
                    }

                    var operasional_1 = table.column(14).data().sum();
                    var operasional_2 = table.column(15).data().sum();
                    var operasional_3 = table.column(16).data().sum();
                    var belum_isi = table.column(17).data().sum();

                    rowTotal += '<td class=".'colnum'.">' + operasional_1  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + operasional_2  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + operasional_3  + '</td>';
                    rowTotal += '<td class=".'colnum'.">' + belum_isi  + '</td>';
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
                'title' => 'Provinsi',
                'width' => '40%',
                'orderable' => false
            ],
            'rapat_perencanaan' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
            ],
            'rapat_perencanaan_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'rapat_koordinasi' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
            ],
            'rapat_koordinasi_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'sosialisasi_kegiatan' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
            ],
            'sosialisasi_kegiatan_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'monitoring' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
            ],
            'monitoring_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'penyusunan_laporan' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
            ],
            'penyusunan_laporan_persen' => [
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
                'orderable' => false
            ],
            'operasional_1' => [
                'title' => 'Melakukan 1-2 Jenis Kegiatan Mekop',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'operasional_2' => [
                'title' => 'Melakukan 3-4 Jenis Kegiatan Mekop',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'operasional_3' => [
                'title' => 'Melakukan 5 Jenis Kegiatan Mekop',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'belum_isi' => [
                'title' => 'Belum Isi',
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
        return 'mekanisme-operasional-table_' . date('YmdHis');
    }
}
