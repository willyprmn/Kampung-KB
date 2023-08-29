<?php

namespace App\DataTables\Admin\Rekapitulasi;

use App\Models\Kampung;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;

class PengisiKontenDataTable extends CachedDataTable
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
            ->active()
            ->with([
                'profil',
                'profil.user',
                'provinsi',
                'kabupaten',
                'kecamatan',
                'desa',
            ])
            ->whereHas('profil')
            ;
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
            ->parameters([
                'dom'          => 'Blfrtip',
                'buttons'      => ['excel'],
            ])
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
            'nama' => [
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
            'kecamatan.name' => [
                'title' => 'Kecamatan',
                'render' => 'full.kecamatan == null ? "-" : full.kecamatan.name',
            ],
            'desa.name' => [
                'title' => 'Desa',
                'render' => 'full.desa == null ? "-" : full.desa.name',
            ],
            'nama' => ['title' => 'Kampung KB'],
            'profil.plkb_nama' => [
                'title' => 'Nama PKB/PLKB/Pendamping',
                'render' => 'full.profil !== null ? full.profil.plkb_nama : "-"',
            ],
            'profil.plkb_kontak' => [
                'title' => 'Kontak Pendamping',
                'render' => 'full.profil == null ? "-" : full.profil.plkb_kontak',
            ],
            'profil.user.email'  => [
                'title' => 'Username',
                'render' => 'full.profil.user == null ? "-" : full.profil.user.email',
            ],
            'profil.user.phone'  => [
                'title' => 'Kontak User',
                'render' => 'full.profil.user == null ? "-" : full.profil.user.phone',
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
        return 'Rekapitulasi - Pengisi Konten ' . date('YmdHis');
    }
}
