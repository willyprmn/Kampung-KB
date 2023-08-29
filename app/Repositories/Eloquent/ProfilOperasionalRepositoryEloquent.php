<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ProfilOperasionalRepository;
use App\Models\ProfilOperasional;
use App\Repositories\Validator\ProfilOperasionalValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ProfilOperasionalRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ProfilOperasionalRepositoryEloquent extends BaseRepository implements ProfilOperasionalRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProfilOperasional::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProfilOperasionalValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
