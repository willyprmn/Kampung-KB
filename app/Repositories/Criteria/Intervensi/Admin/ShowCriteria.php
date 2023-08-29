<?php

namespace App\Repositories\Criteria\Intervensi\Admin;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ShowCriteria.
 *
 * @package namespace App\Repositories\Criteria\Intervensi\Admin;
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
                'sasarans' => function ($sasaran) {
                    return $sasaran->withPivot('sasaran_lainnya');
                },
                'instansis' => function ($instansi) {
                    return $instansi->withPivot('instansi_lainnya');
                },
                'intervensi_gambars'
            ]);
    }
}
