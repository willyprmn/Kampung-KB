<?php

namespace App\DataTables\Admin\Kampung;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;
use Marsflow\CachedDataTable\Services\CachedDataTable;

class ProgressStatisticDataTable extends DataTable
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
     * @param \App\Models\Admin\Kampung\ProgressStatistic $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $sql = file_get_contents(base_path('database/sql/admin/progress-statistic.sql'));
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
                    ->setTableId('datatable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('rt')
                    ->orderBy(1)
                    ->drawCallback("function() {
                        var table = $('#datatable').DataTable();
                        $('#datatable').on( 'draw.dt', function () {
                            var sumTarget = table.column(2).data().sum();
                            var sumCapaian = table.column(3).data().sum();
                            if ($('#total').length) {
                                $('#total').remove();
                            }
                            $('#datatable').append('<tr id=" . '"total"' . "name=" . '"total"' . " style=". '"font-weight:bold; "' . " class=". '"even"' . ">" . 
                                "<td colspan=" . '"2"' . ">Jumlah</td> ". 
                                "<td>' + sumTarget  + ' </td>". 
                                "<td>' + sumCapaian  + '</td> </tr>');
                        } );
                    }");
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
                'orderable' => false
            ],
            'provinsi' => ['title' => 'Provinsi',],
            'target_kkb' => ['title' => 'Target KKB'],
            'capaian_kkb' => ['title' => 'Capaian KKB'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin\Kampung\ProgressStatistic_' . date('YmdHis');
    }
}
