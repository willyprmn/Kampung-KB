<?php

namespace App\DataTables\Admin\Kampung;

use App\Models\PendudukKampung;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PendudukDataTable extends DataTable
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
            ->addColumn('action', function ($penduduk) {
                return view('admin.kampung.include.action.penduduk', [
                    'penduduk' => $penduduk,
                    'kampung' => $this->kampung
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin/Kampung/Penduduk $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PendudukKampung $model)
    {
        return $model
            ->where('kampung_kb_id', $this->kampung->id)
            ->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {

        return $this->builder()
            ->setTableId('admin-kampung-penduduk-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('admin.kampungs.penduduk.index', ['kampung' => $this->kampung->id]))
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
            'id' => ['title' => 'ID'],
            // 'bulan' => ['title' => 'Bulan'],
            // 'tahun' => ['title' => 'Tahun'],
            'created_at' => [
                'title' => 'Tanggal',
                'render' => 'new Date(full.created_at).toLocaleString(`id-ID`)'
            ],
            'action' => ['title' => 'Action']

        ];

        // return [
        //     Column::computed('action')
        //           ->exportable(false)
        //           ->printable(false)
        //           ->width(60)
        //           ->addClass('text-center'),
        //     Column::make('id'),
        //     // Column::make('add your columns'),
        //     Column::make('created_at'),
        //     Column::make('updated_at'),
        // ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'AdminKampungPenduduk_' . date('YmdHis');
    }
}
