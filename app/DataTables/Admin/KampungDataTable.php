<?php

namespace App\DataTables\Admin;

use Auth;

use App\DataTables\Traits\RegionalFilterAuth;
use App\Models\Kampung;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Marsflow\CachedDataTable\Services\CachedDataTable;

class KampungDataTable extends CachedDataTable
{

    use RegionalFilterAuth;

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($kampung) {
                return view('admin.kampung.include.action', compact('kampung'));
            })
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Kampung $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Kampung $model)
    {
        $table = Kampung::getTableName();

        $model = $model
            ->select([
                "{$table}.id",
                "{$table}.nama",
                "{$table}.provinsi_id",
                "{$table}.kabupaten_id",
                "{$table}.kecamatan_id",
                "{$table}.desa_id",
            ])
            ->with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])
            ->active()
            // ->orderBy("{$table}.nama", 'ASC')
            ;

        $model = $this->filterByRegion($model);

        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('admin-kampung-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom('Bfrtip')
            ->orderBy(1)
            // ->buttons(
            //     Button::make('create'),
            //     Button::make('export'),
            //     Button::make('print'),
            //     Button::make('reset'),
            //     Button::make('reload')
            // )
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
            'id' => ['title' => 'Id'],
            'nama' => ['title' => 'Nama'],
            'provinsi.name' => [
                'title' => 'Provinsi',
                'render' => 'full.provinsi == null ? "-" : full.provinsi.name',
            ],
            'kabupaten.name' => [
                'title' => 'Kabupaten/Kota',
                'render' => 'full.kabupaten == null ? "-" : full.kabupaten.name',
            ],
            'kecamatan.name' => [
                'title' => 'Kecamatan',
                'render' => 'full.kecamatan == null ? "-" : full.kecamatan.name',
            ],
            'desa.name' => [
                'title' => 'Desa',
                'render' => 'full.desa == null ? "-" : full.desa.name',
            ],
            'action' => ['title' => 'Profil']
        ];
    }
}
