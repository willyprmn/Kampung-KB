<?php

namespace App\Repositories\Criteria\Menu;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

use Auth;

/**
 * Class RoleMenuFilterCriteria.
 *
 * @package namespace App\Repositories\Criteria\Menu;
 */
class RoleMenuFilterCriteria implements CriteriaInterface
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
            ->whereHas('roles.user_roles', function ($user_role) {
                return $user_role->where('user_id', Auth::user()->id);
            });
    }
}
