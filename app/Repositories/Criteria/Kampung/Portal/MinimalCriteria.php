<?php

namespace App\Repositories\Criteria\Kampung\Portal;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class MinimalCriteria.
 *
 * @package namespace App\Repositories\Criteria\Kampung\Portal;
 */
class MinimalCriteria implements CriteriaInterface
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
                "{$table}.path_gambar",
                "{$table}.tanggal_pencanangan"
            ]);
    }
}
