<?php

namespace App\DataTables\Admin\Kampung;

use App\Models\Intervensi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IntervensiDataTable extends DataTable
{

    protected $actions = ['myCustomAction'];
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
            ->addColumn('action', function ($intervensi) {
                return view('admin.kampung.include.action.intervensi', [
                    'intervensi' => $intervensi,
                    'kampung' => $this->kampung
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Intervensi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Intervensi $model)
    {
        return $model
            ->where('kampung_kb_id', $this->kampung->id)
            ->with(['jenis', 'kategori', 'inpres_kegiatan'])
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
            ->setTableId('admin-kampung-intervensi-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('admin.kampungs.intervensi.index', ['kampung' => $this->kampung->id]))
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
            'id' => ['title' => 'ID'],
            'judul' => ['title' => 'Nama Kegiatan'],
            'tanggal' => [
                'title' => 'Tanggal',
                'render' => 'new Date(full.tanggal).toLocaleDateString(`id-ID`)'
            ],
            'jenis.name' => ['title' => 'Jenis'],
            'kategori.name' => ['title' => 'Kategori'],
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


    public function myCustomAction()
    {
        return response()->route('admin.kampungs.intervensi.create', ['kampung' => $this->kampung->id]);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'AdminKampungIntervensi_' . date('YmdHis');
    }
}
