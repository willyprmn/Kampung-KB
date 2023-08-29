<?php

namespace App\DataTables\Portal\Statistik;

use App\Models\Portal\Statistik\CakupanWilayah;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;
use Marsflow\CachedDataTable\Services\CachedDataTable;

class CakupanWilayahDataTable extends CachedDataTable
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
            ->collection($query)
            ->skipPaging();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Portal\Statistik\CakupanWilayah $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $sql = file_get_contents(base_path('database/sql/statistik/cakupan-wilayah.sql'));
        $data = DB::select($sql);

        return $data;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('cakupan-wilayah-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Brt')
            ->orderBy(0, 'asc')
            ->buttons(
                Button::make('export'),
            )
            ->drawCallback("function() {
                var table = $('#cakupan-wilayah-table').DataTable();
                $('#cakupan-wilayah-table').on( 'draw.dt', function () {
                    var sumTotal = table.column(8).data().sum();
                    var sumRW = table.column(2).data().sum();
                    var sumRWPersen = (sumRW/sumTotal) * 100;
                    var sumDusun = table.column(4).data().sum();
                    var sumDusunPersen = (sumDusun/sumTotal) * 100;
                    var sumDesa = table.column(6).data().sum();
                    var sumDesaPersen = (sumDesa/sumTotal) * 100;
                    $('#cakupan-wilayah-table').append('<tr style=". '"font-weight:bold; "' . " class=". '"even"' . "><td colspan=" . '"2"' . ">Jumlah</td> <td>' + sumRW  + ' </td> <td>' + parseFloat(sumRWPersen).toFixed(2)  + '</td> <td>' + sumDusun  + '</td> <td>' + parseFloat(sumDusunPersen).toFixed(2)  + '</td> <td>' + sumDesa  + '</td> <td>' + parseFloat(sumDesaPersen).toFixed(2)  + '</td> <td>' + sumTotal  + '</td> </tr>');
                } );
            }")
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
            'id' => [
                'title' => 'No',
                'render' => 'meta.row + meta.settings._iDisplayStart + 1'
            ],
            'nama' => ['title' => 'Provinsi', 'width' => '40%'],
            'rw' => ['title' => 'RW'],
            'rw_persen' => ['title' => '%'],
            'dusun' => ['title' => 'Dusun'],
            'dusun_persen' => ['title' => '%'],
            'desa' => ['title' => 'Desa'],
            'desa_persen' => ['title' => '%'],
            'total_kkb' => ['title' => 'Total Kampung KB']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'cakupan-wilayah-table_' . date('YmdHis');
    }
}
