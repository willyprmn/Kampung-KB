<?php

namespace Marsflow\CachedDataTable\Services;

use Yajra\DataTables\Services\DataTable;

class CachedDataTable extends DataTable
{

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        $query = null;
        if (method_exists($this, 'query')) {
            $query = app()->call([$this, 'query']);
            $query = $this->applyScopes($query);
        }

        /** @var \Yajra\DataTables\DataTableAbstract $dataTable */
        $dataTable = app()->call([$this, 'dataTable'], compact('query'));

        if ($callback = $this->beforeCallback) {
            $callback($dataTable);
        }

        if ($callback = $this->responseCallback) {
            $data = new Collection($dataTable->toArray());

            return new JsonResponse($callback($data));
        }

        return $dataTable->toJson();
    }
}