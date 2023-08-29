<?php

namespace App\DataTables\Portal\Statistik;

use App\Models\Kampung;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;
use Marsflow\CachedDataTable\Services\CachedDataTable;

class CapaianRoadmapDataTable extends CachedDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->collection($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Portal\CapaianRoadmap $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Kampung $model)
    {
        $sql = file_get_contents(base_path('database/sql/statistik/roadmap.sql'));
        $data = DB::select($sql);

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
                    ->setTableId('capaianroadmap-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('export'),
                    )
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
            // 'id' => ['title' => 'Id'],
            'nama' => ['title' => 'Provinsi'],
            'rw' => ['title' => 'RW'],
            'rw_persen' => ['title' => '%'],
            'dusun' => ['title' => 'Dusun'],
            'dusun_persen' => ['title' => '%'],
            'desa' => ['title' => 'Desa'],
            'desa_persen' => ['title' => '%']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'capaianroadmap-table_' . date('YmdHis');
    }
}
