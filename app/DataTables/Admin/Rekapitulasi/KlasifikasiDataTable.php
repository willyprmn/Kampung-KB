<?php

namespace App\DataTables\Admin\Rekapitulasi;

use Cache;
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
            // ->skipPaging()
            ;
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
        $request['statistic'] = 'classification-kampung';
        $key = md5(json_encode($request));

        #set 1 day expired cache
        $data = Cache::remember($key, 500, function (){

            $sql = file_get_contents(base_path('database/sql/statistik/classification/kampungs.sql'));
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
            ->dom('Blrftip')
            ->parameters([
                'buttons' => ['excel'],
            ])
            ->orderBy(1, 'asc')
            ;
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
            'nama' => [
                'title' => 'Kampung KB',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'provinsi' => [
                'title' => 'Provinsi',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'kabupaten' => [
                'title' => 'Kabupaten',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'kecamatan' => [
                'title' => 'Kecamatan',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'desa' => [
                'title' => 'Desa',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'input_pokja' => [
                'title' => 'Input Pokja',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'input_sumber_dana' => [
                'title' => 'Input Sumber Dana',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'input_poktan' => [
                'title' => 'Input Poktan',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'input_sarana' => [
                'title' => 'Input Sarana',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'input_pkb' => [
                'title' => 'Input PKB/PLKB',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'proses_penggunaan_data' => [
                'title' => 'Proses Penggunaan Data',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'proses_operasional' => [
                'title' => 'Proses Operasional',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'proses_lintas_sektor' => [
                'title' => 'Proses Lintas Sektor',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'output_poktan' => [
                'title' => 'Output Poktan',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'output_cpr' => [
                'title' => 'Output CPR',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'output_mkjp' => [
                'title' => 'Output MKJP',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'output_unmet' => [
                'title' => 'Output Unmet Need',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'index_input' => [
                'title' => 'Index Input',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'index_proses' => [
                'title' => 'Index Proses',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'index_output' => [
                'title' => 'Index Output',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'klasifikasi' => [
                'title' => 'Klasifikasi',
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
