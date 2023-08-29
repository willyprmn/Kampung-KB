<?php

namespace App\DataTables\Admin\Kampung;

use App\Models\Kkbpk;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KkbpkDataTable extends DataTable
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
            ->addColumn('action', function ($kkbpk) {
                return view('admin.kampung.include.action.kkbpk', [
                    'kkbpk' => $kkbpk,
                    'kampung' => $this->kampung
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Kkbpk $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Kkbpk $model)
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
            ->setTableId('admin-kampung-kkbpk-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('admin.kampungs.kkbpk.index', ['kampung' => $this->kampung->id]))
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
            'bulan' => ['title' => 'Bulan'],
            'tahun' => ['title' => 'Tahun'],
            'created_at' => [
                'title' => 'Tanggal',
                'render' => 'new Date(full.created_at).toLocaleString(`id-ID`)'
            ],
            'action' => ['title' => 'Action']
        ];
        // return [
        //     'id' => ['title' => 'Id'],
        //     'nama' => ['title' => 'Nama'],
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
        return 'Kkbpk_' . date('YmdHis');
    }
}
