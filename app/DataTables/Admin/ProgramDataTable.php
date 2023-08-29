<?php

namespace App\DataTables\Admin;

use App\Models\Program;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Marsflow\CachedDataTable\Services\CachedDataTable;

class ProgramDataTable extends CachedDataTable
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
            ->addColumn('action', function ($program) {
                return view('admin.program.include.action', compact('program'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin\IntervensiProgramDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Program $model)
    {
        return $model->orderBy('name')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('intervensiprogramdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    // ->dom('Bfrtip')
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
            'id' => [
                'title' => 'No',
                'render' => 'meta.row + meta.settings._iDisplayStart + 1'
            ],
            'name' => ['title' => 'Nama'],
            'deskripsi' => ['title' => 'Deskripsi'],
            'action' => ['title' => 'Action']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'IntervensiProgram_' . date('YmdHis');
    }
}
