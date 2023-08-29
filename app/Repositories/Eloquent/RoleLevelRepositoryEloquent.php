<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\RoleLevelRepository;
use App\Models\RoleLevel;
use App\Repositories\Validator\RoleLevelValidator;

/**
 * Class RoleLevelRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class RoleLevelRepositoryEloquent extends BaseRepository implements RoleLevelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RoleLevel::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
