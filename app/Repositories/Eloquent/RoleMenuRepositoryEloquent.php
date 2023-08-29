<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\RoleMenuRepository;
use App\Models\RoleMenu;
use App\Repositories\Validator\RoleMenuValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class RoleMenuRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class RoleMenuRepositoryEloquent extends BaseRepository implements RoleMenuRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RoleMenu::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
