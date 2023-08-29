<?php

namespace App\Repositories\Criteria\Kkbpk\Admin;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ShowCriteria.
 *
 * @package namespace App\Repositories\Criteria\Kkbpk\Admin;
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
                'programs' => function ($program) {
                    return $program->withPivot(['jumlah']);
                },
                'kontrasepsis' => function ($kontrasepsi) {
                    return $kontrasepsi->withPivot(['jumlah']);
                },
                'non_kontrasepsis' => function ($non_kontrasepsi) {
                    return $non_kontrasepsi->withPivot(['jumlah']);
                }
            ]);
    }
}
