<?php

namespace App\DataTables\Admin\Kampung;

use App\Models\ProfilKampung;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProfilDataTable extends DataTable
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
            ->addColumn('action', function ($profil) {
                return view('admin.kampung.include.action.profil', [
                    'profil' => $profil,
                    'kampung' => $this->kampung
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ProfilKampung $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ProfilKampung $model)
    {
        return $model
            ->where('kampung_kb_id', $this->kampung->id)
            ->orderBy('created_at', 'DESC')
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
            ->setTableId('admin-kampung-profil-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('admin.kampungs.profil.index', ['kampung' => $this->kampung->id]))
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
                'orderable' => true,
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
        return 'ProfilKampung_' . date('YmdHis');
    }
}
