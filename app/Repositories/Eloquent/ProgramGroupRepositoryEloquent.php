<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ProgramGroupRepository;
use App\Models\ProgramGroup;
use App\Repositories\Validator\ProgramGroupValidator;

/**
 * Class ProgramGroupRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ProgramGroupRepositoryEloquent extends BaseRepository implements ProgramGroupRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProgramGroup::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProgramGroupValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
