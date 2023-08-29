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

class KlasifikasiDataTable extends CachedDataTable
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
        $request['statistic'] = 'classification';
        $key = md5(json_encode($request));

        #set 1 day expired cache
        $data = Cache::remember($key, config('kpkb.statistik.cache.lifetime'), function (){

            $sql = file_get_contents(base_path('database/sql/statistik/classification/query.sql'));
            #alias table master
            $provinsi = "l";
            $kabupaten = "m";
            $kecamatan = "n";
            $desa = "o";

            $request = request();
            $filterRegional = $this->filterRegional->getQueryCondition($request, $provinsi, $kabupaten, $kecamatan, $desa);

            $tableMaster = $filterRegional['tableMaster'];
            $whereMaster = $filterRegional['whereMaster'];
            $where = $filterRegional['where'];
            $grouping = $filterRegional['grouping'];
            $whereHistory = $filterRegional['whereHistory'];

            $sql = sprintf($sql, $tableMaster, $grouping, $where, $whereMaster, $whereHistory);
            // dd($sql);
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
                                <th colspan="2">Dasar</th>
                                <th colspan="2">Berkembang</th>
                                <th colspan="2">Mandiri</th>
                                <th colspan="2">Berkelanjutan</th>
                                <th></th>
                            </tr>
                        `).insertAfter(`#titleHeader`)
                    }
JAVASCRIPT
            ])
            ->drawCallback(<<<'JAVASCRIPT'
                function() {
                    var table = $('#datatable').DataTable();
                    $('#datatable').on( 'draw.dt', function () {
                        var columnLength = document.getElementById('datatable').rows[2].cells.length - 1;
                        var sumTotal = table.column(columnLength).data().sum();

                        var rowTotal = `<tr id="total" "name="total" style="font-weight:bold;" class="even"><td colspan=2> Total </td>`;

                        for (i = 2; i < columnLength; i++) {
                            var sumData = table.column(i).data().sum();
                            var sumDataPersen = (sumData/sumTotal) * 100;

                            rowTotal += `<td class="colnum">${sumData}</td>`;
                            rowTotal += `<td class="colnum">${((isNaN(sumDataPersen)) ? 0 : parseFloat(sumDataPersen).toFixed(2))}</td>`;

                            console.log(i);
                            i +=1; //add 1 jump to next column to get sum of value column
                        }

                        rowTotal += `<td class="colnum">${sumTotal}</td>`;
                        rowTotal += `</tr>`;

                        if ($('#total').length) {
                            $('#total').remove();
                        }

                        $('#datatable').append(rowTotal);

                        //generate header title
                        generateHeader();

                    } );
                }
JAVASCRIPT
        );
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
            'dasar' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
            ],
            'dasar_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'berkembang' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
            ],
            'berkembang_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'mandiri' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
            ],
            'mandiri_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'berkelanjutan' => [
                'title' => __('statistik.th_jumlah'),
                'orderable' => false,
                'className' => 'colnum'
            ],
            'berkelanjutan_persen' => [
                'title' => '%',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'total' => [
                'title' => 'Total',
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
        return 'classification-table_' . date('YmdHis');
    }
}
