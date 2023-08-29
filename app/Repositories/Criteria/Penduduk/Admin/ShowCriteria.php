<?php

namespace App\Repositories\Criteria\Penduduk\Admin;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
/**
 * Class ShowCriteria.
 *
 * @package namespace App\Repositories\Criteria\Admin\Penduduk;
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
        return $model->with(['keluargas', 'kampung'])

            ;
    }
}
