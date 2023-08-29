<?php

namespace App\DataTables\Admin;

use App\DataTables\Traits\RegionalFilterAuth;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;

class UserDataTable extends CachedDataTable
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
            ->addColumn('roles', function ($user) {
                return view('admin.user.include.roles', compact('user'));
            })
            ->addColumn('action', function ($user) {
                return view('admin.user.include.action', compact('user'));
            })
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin/User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {

        $table = $model->getTable();
        $model = $model
            ->select([
                "{$table}.id",
                "{$table}.email",
                "{$table}.phone",
                "{$table}.provinsi_id",
                "{$table}.kabupaten_id",
                "{$table}.kecamatan_id",
                "{$table}.desa_id",
                "{$table}.is_active",
            ])
            ->with(['provinsi', 'kabupaten', 'kecamatan', 'desa', 'roles'])
            ->newQuery();

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
                    ->setTableId('admin-user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    // ->dom('Bfrtip')
                    ->orderBy(1)
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
            'email' => ['title' => 'Email/Username'],
            'phone' => [
                'title' => 'No. Telp',
                'render' => 'full.phone ?? "-"',
            ],
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
            'roles' => [
                'title' => 'Role',
                'orderable' => false,
            ],
            'is_active' => [
                'title' => 'Status',
                'render' => 'full.is_active === true ? "Aktif" : "Tidak Aktif"',
            ],
            'action' => [
                'title' => 'Action',
                'orderable' => false,
            ]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin/User_' . date('YmdHis');
    }
}
