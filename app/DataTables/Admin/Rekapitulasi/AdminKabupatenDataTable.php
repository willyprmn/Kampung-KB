<?php

namespace App\DataTables\Admin\Rekapitulasi;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;

class AdminKabupatenDataTable extends CachedDataTable
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
            ->eloquent($query)
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Instansi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $model = User::query()
            ->with([
                'provinsi',
                'kabupaten',
                'kecamatan',
                'roles'
            ])
            ->whereHas('roles', function($role){
                $role->where('new_roles.id', 4);
            })
            ->where('provinsi_id', '!=', null)
            ->where('kabupaten_id', '!=', null)
            ->where('kecamatan_id', '=', null)
            ->where('desa_id', '=', null);

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
            ->setTableId('datatable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Blrtip')
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
                'searchable' => false,
            ],
            'provinsi.name' => [
                'title' => 'Provinsi',
                'render' => 'full.provinsi == null ? "-" : full.provinsi.name',
            ],
            'kabupaten.name' => [
                'title' => 'Kabupaten/Kota',
                'render' => 'full.kabupaten == null ? "-" : full.kabupaten.name',
            ],
            'email'  => [
                'title' => 'Username',
                'render' => 'full.email ?? "-"',
            ],
            'phone'  => [
                'title' => 'Kontak User',
                'render' => 'full?.phone ?? "-"',
            ],
            'is_active' => [
                'title' => 'Status',
                'render' => 'full.is_active === true ? "Aktif" : "Tidak Aktif"',
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
        return 'Rekapitulasi - Admin Kabupaten ' . date('YmdHis');
    }
}
