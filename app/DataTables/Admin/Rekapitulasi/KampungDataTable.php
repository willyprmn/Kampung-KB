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

class KampungDataTable extends CachedDataTable
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
        $request['statistic'] = 'rekap-detail-kampung';
        $key = md5(json_encode($request));

        #set 1 day expired cache
        $data = Cache::remember($key, 500, function (){

            $sql = file_get_contents(base_path('database/sql/admin/rekap-detail-kampung.sql'));

            $request = request();
            $whereCondition = " and 1=1 ";
            if(request()->has('provinsi_id') && !empty(request()->provinsi_id)){
                $whereCondition .= " and a.provinsi_id = '" . $request->provinsi_id . "' ";
            }
            if(request()->has('kabupaten_id') && !empty(request()->kabupaten_id)){
                $whereCondition .= " and a.kabupaten_id = '" . $request->kabupaten_id . "' ";
            }
            if(request()->has('kecamatan_id') && !empty(request()->kecamatan_id)){
                $whereCondition .= " and a.kecamatan_id = '" . $request->kecamatan_id . "' ";
            }
            if(request()->has('desa_id') && !empty(request()->desa_id)){
                $whereCondition .= " and a.desa_id = '" . $request->desa_id . "' ";
            }

            $sql = sprintf($sql, $whereCondition);
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

            'jumlah_sumber_dana' => [
                'title' => 'Jumlah Sumber Dana',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'pokja_pengurusan' => [
                'title' => 'Pokja Pengurusan',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'pokja_sk' => [
                'title' => 'Pokja SK',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'pokja_pelatihan' => [
                'title' => 'Pokja Pelatihan',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'pokja_jumlah' => [
                'title' => 'Pokja Jumlah',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'pokja_jumlah_terlatih' => [
                'title' => 'Pokja Jumlah Terlatih',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'plkb_pendamping' => [
                'title' => 'PLKB Pendamping',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'regulasi' => [
                'title' => 'Regulasi',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'jumlah_regulasi' => [
                'title' => 'Regulasi Jumlah',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'rkm' => [
                'title' => 'RKM',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'penggunaan_data' => [
                'title' => 'Penggunaan Data',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'jumlah_mekanisme_operasional' => [
                'title' => 'Jumlah Mekanisme Operasional',
                'orderable' => false,
                'className' => 'colnum'
            ],


            'pus' => [
                'title' => 'Pus',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'penduduk' => [
                'title' => 'Penduduk',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'keluarga' => [
                'title' => 'Keluarga',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'remaja' => [
                'title' => 'Remaja',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'memiliki_balita' => [
                'title' => 'Memiliki Balita',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'memiliki_remaja' => [
                'title' => 'Memiliki Remaja',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'memiliki_lansia' => [
                'title' => 'Memiliki Lansia',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'bkb' => [
                'title' => 'BKB',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'bkr' => [
                'title' => 'BKR',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'bkl' => [
                'title' => 'BKL',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'uppka' => [
                'title' => 'UPPKA',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'pikr' => [
                'title' => 'PIKR',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'iud' => [
                'title' => 'IUD',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'mow' => [
                'title' => 'MOW',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'mop' => [
                'title' => 'MOP',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'kondom' => [
                'title' => 'Kondom',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'implan' => [
                'title' => 'Implan',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'suntik' => [
                'title' => 'Suntik',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'pil' => [
                'title' => 'Pil',
                'orderable' => false,
                'className' => 'colnum'
            ],

            'hamil' => [
                'title' => 'Hamil',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'anak_segera' => [
                'title' => 'Anak Segera',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'anak_kemudian' => [
                'title' => 'Anak Kemudian',
                'orderable' => false,
                'className' => 'colnum'
            ],
            'tidak_ingin_anak' => [
                'title' => 'Tidak Ingin Anak',
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
        return 'rekap-kampung-table_' . date('YmdHis');
    }
}
