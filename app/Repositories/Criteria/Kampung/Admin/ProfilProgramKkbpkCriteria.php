<?php

namespace App\Repositories\Criteria\Kampung\Admin;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProfilProgramKkbpkCriteria.
 *
 * @package namespace App\Repositories\Criteria\Kampung\Admin;
 */
class ProfilProgramKkbpkCriteria implements CriteriaInterface
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
        return $model->with(['profil.programs' => function ($program) {
            return $program->kkbpk();
        }]);
    }
}
