<?php

namespace App\Repositories\Criteria\Profil\Admin;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ShowCriteria.
 *
 * @package namespace App\Repositories\Criteria\Admin\Profil;
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

        return $model->with([
            'profil_programs',
            'profil_sumber_danas',
            'operasionals.pivot.frekuensi',
            'kampung:id,nama',
            'penggunaan_datas',
            'profil_regulasis',
            'archive'
        ]);
    }
}
