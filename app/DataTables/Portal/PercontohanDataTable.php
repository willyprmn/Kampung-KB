<?php

namespace App\DataTables\Portal;

use App\Models\Kampung;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Marsflow\CachedDataTable\Services\CachedDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class PercontohanDataTable extends CachedDataTable
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
            ->addColumn('action', function ($kampung) {
                return view('portal.kampung.include.action', compact('kampung'));
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

        $search = "";
        if(request()->has('cari')){
            $search = request('cari');
        }

        if(request()->has('search') && request()->search["value"] != null){
            $search = request()->search["value"];
        }

        $data['search']['value'] = $search;
        request()->merge($data);

        $model = $model
            ->select([
                "{$table}.id",
                "{$table}.nama",
                'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'desa_id', 'cakupan_wilayah'])
            ->where('contoh_provinsi_flag', true)
            ->orWhere('contoh_kabupaten_flag', true)
            ->with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])
            ->active()
            ->newQuery();

        switch (true) {
            case request()->has('desa_id') && !empty(request()->get('desa_id')):
                $model = $model->where('desa_id', request()->get('desa_id'));
                break;
            case request()->has('kecamatan_id') && !empty(request()->get('kecamatan_id')):
                $model = $model->where('kecamatan_id', request()->get('kecamatan_id'));
                break;
            case request()->has('kabupaten_id') && !empty(request()->get('kabupaten_id')):
                $model = $model->where('kabupaten_id', request()->get('kabupaten_id'));
                break;
            case request()->has('provinsi_id') && !empty(request()->get('provinsi_id')):
                $model = $model->where('provinsi_id', request()->get('provinsi_id'));
                break;
        }

        switch(true){
            case request()->has('percontohan_type') && !empty(request()->get('percontohan_type')):
                $model = $model->where(request()->get('percontohan_type'), true);
                break;
        }

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
            ->orderBy(1);
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

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Kampung_' . date('YmdHis');
    }
}
