<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\PlkbPengarahRepository;
use App\Models\PlkbPengarah;
use App\Repositories\Validator\PlkbPengarahValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class PlkbPengarahRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class PlkbPengarahRepositoryEloquent extends BaseRepository implements PlkbPengarahRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlkbPengarah::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PlkbPengarahValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
