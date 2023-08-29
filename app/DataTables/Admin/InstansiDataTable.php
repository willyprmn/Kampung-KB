<?php

namespace App\DataTables\Admin;

use App\Models\Instansi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;

class InstansiDataTable extends CachedDataTable
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
            ->addColumn('action', function ($instansi) {
                return view('admin.instansi.include.action', compact('instansi'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Instansi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Instansi $model)
    {
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
                    ->setTableId('admin-instansi-table')
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
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            Column::make('id'),
            Column::make('name'),
            Column::make('action'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
        ];

        // return [
        //     'id' => ['title' => 'Id'],
        //     'name' => ['title' => 'Nama'],
        //     'provinsi.name' => [
        //         'title' => 'Provinsi',
        //         'render' => 'full.provinsi == null ? "-" : full.provinsi.name',
        //     ],
        //     'kabupaten.name' => [
        //         'title' => 'Kabupaten/Kota',
        //         'render' => 'full.kabupaten == null ? "-" : full.kabupaten.name',
        //     ],
        //     'kecamatan.name' => [
        //         'title' => 'Kecamatan',
        //         'render' => 'full.kecamatan == null ? "-" : full.kecamatan.name',
        //     ],
        //     'action' => ['title' => 'Profil']
        // ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin/Instansi_' . date('YmdHis');
    }
}
