<?php

namespace App\Repositories\Criteria\Program;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class IntervensiCriteria.
 *
 * @package namespace App\Repositories\Criteria\Program;
 */
class IntervensiCriteria implements CriteriaInterface
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
            ->whereHas('groups', function ($builder) {
                $builder->where('name', 'Intervensi');
            })
            ;
    }
}
