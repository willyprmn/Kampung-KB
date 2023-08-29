<?php

namespace App\Repositories\Criteria\Kampung\Admin;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ShowDetailCriteriaCriteria.
 *
 * @package namespace App\Repositories\Criteria\Kampung;
 */
class ShowCriteria implements CriteriaInterface
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
            ->with([
                'provinsi',
                'kabupaten',
                'kecamatan',
                'kriterias',
            ]);
    }
}
