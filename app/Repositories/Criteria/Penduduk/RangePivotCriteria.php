<?php

namespace App\Repositories\Criteria\Penduduk;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Models\Range;
/**
 * Class RangePivotCriteria.
 *
 * @package namespace App\Repositories\Criteria\Penduduk;
 */
class RangePivotCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $range = new Range();
        return $model
            ->with(['ranges' => function ($query) use ($range) {
                return $query->select([
                    "{$range->table}.id",
                    "{$range->table}.name",
                    "{$range->table}.range_start"
                ])
                ->withPivot(['jumlah', 'jenis_kelamin'])
                ->orderBy("{$range->table}.range_start", 'asc')
                ;
            }]);
    }
}
