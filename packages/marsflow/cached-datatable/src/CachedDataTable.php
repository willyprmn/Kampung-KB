<?php

namespace Marsflow\CachedDataTable;

use Marsflow\CachedDataTable\CachedDataTableAbstract;
use Marsflow\CachedDataTable\CachedEloquentDataTable;
use Marsflow\CachedDataTable\CachedQueryDataTable;
use Yajra\DataTables\DataTables;

class CachedDataTable extends DataTables
{

    /**
     * DataTables using Query.
     *
     * @param \Illuminate\Database\Query\Builder|mixed $builder
     * @return DataTableAbstract|QueryDataTable
     */
    public function query($builder)
    {
        return CachedQueryDataTable::create($builder);
    }

    /**
     * DataTables using Eloquent Builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder|mixed $builder
     * @return DataTableAbstract|EloquentDataTable
     */
    public function eloquent($builder)
    {
        return CachedEloquentDataTable::create($builder);
    }

}