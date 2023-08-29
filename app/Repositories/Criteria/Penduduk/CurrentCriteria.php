<?php

namespace App\Repositories\Criteria\Penduduk;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CurrentCriteria.
 *
 * @package namespace App\Repositories\Criteria\Penduduk;
 */
class CurrentCriteria implements CriteriaInterface
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
        return $model
            ->with(['keluargas'])
            ->where('is_active', '1')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ;
    }
}
