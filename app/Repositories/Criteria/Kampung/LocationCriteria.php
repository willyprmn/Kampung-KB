<?php

namespace App\Repositories\Criteria\Kampung;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LocationCriteria.
 *
 * @package namespace App\Repositories\Criteria\Kampung;
 */
class LocationCriteria implements CriteriaInterface
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
        $table = \App\Models\Kampung::getTableName();
        return $model
            ->select([
                "{$table}.id",
                "{$table}.nama",
                "{$table}.latitude",
                "{$table}.longitude",
            ])
            ->where(["{$table}.is_active" => true])
        ;
    }
}
