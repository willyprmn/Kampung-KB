<?php

namespace App\DataTables\Admin;

use App\Models\ProgramGroup;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProgramGroupDataTable extends DataTable
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
            ->addColumn('action', function ($group) {
                return view('admin.program-group.include.action', compact('group'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin\ProgramGroupDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ProgramGroup $model)
    {
        return $model
            ->with(['programs'])
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
                    ->setTableId('programgroupdatatable-table')
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
            'id' => [
                'title' => 'No',
                'render' => 'meta.row + meta.settings._iDisplayStart + 1'
            ],
            'name' => ['title' => 'Group'],
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
        return 'Admin\ProgramGroup_' . date('YmdHis');
    }
}
