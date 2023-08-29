<?php

namespace App\DataTables\Portal\Statistik\Kkbpk;

use Cache;
use App\Models\Portal\Statistik\Kkbpk\AngkaPartisipasiKegiatanPoktan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\DataTables\Portal\Statistik\FilterRegional;

class AngkaPartisipasiKegiatanPoktanDataTable extends CachedDataTable
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
     * @param \App\Models\Portal\Statistik\Kkbpk\AngkaPartisipasiKegiatanPoktan $model
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
        $request['statistic'] = 'angka-partisipasi-kegiatan';
        $key = md5(json_encode($request));

        #set 1 day expired cache
        $data = Cache::remember($key, config('kpkb.statistik.cache.lifetime'), function (){

            $sql = file_get_contents(base_path('database/sql/statistik/kkbpk/angka-partisipan-kegiatan-poktan.sql'));
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
            ])
            ->drawCallback("function() {
                var table = $('#datatable').DataTable();
                $('#datatable').on( 'draw.dt', function () {
                    var columnLength = document.getElementById('datatable').rows[1].cells.length - 1;
                    var sumTotal = table.column(columnLength).data().sum();

                    var rowTotal = '<tr id=" . '"total"' . "name=" . '"total"' . " style=". '"font-weight:bold; "' . " class=". '"even"' . "> <td class=".'colnum'."></td><td> Total </td>';

                    for(i = 2; i < columnLength+1; i++){
                        var sumData = table.column(i).data().sum();
                        if( i < 7 ){

                            rowTotal += '<td class=".'colnum'.">' + sumData.toFixed(2)  + '</td>';

                        }else{

                            rowTotal += '<td class=".'colnum'.">' + sumData  + '</td>';

                        }
                    }

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
            'regional' => ['title' => 'Provinsi', 'width' => '40%', 'orderable' => false],
            'bkb' => [
                'title' => 'BKB<br/>(%)',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkr' => [
                'title' => 'BKR<br/>(%)',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'bkl' => [
                'title' => 'BKL<br/>(%)',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'uppks' => [
                'title' => 'UPPKA<br/>(%)',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'pikr' => [
                'title' => 'PIK R<br/>(%)',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'ada' => [
                'title' => 'Kampung KB Yang Mengisi',
                'orderable' => false,
                'className' => 'colnum',
            ],
            'belum' => [
                'title' => 'Kampung KB Yang Belum Isi',
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
        return 'kkbpk-angka-pertisipan-kegiatan-poktan_' . date('YmdHis');
    }
}
