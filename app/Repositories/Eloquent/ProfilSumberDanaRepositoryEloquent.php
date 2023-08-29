<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ProfilSumberDanaRepository;
use App\Models\ProfilSumberDana;
use App\Repositories\Validator\ProfilSumberDanaValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ProfilSumberDanaRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ProfilSumberDanaRepositoryEloquent extends BaseRepository implements ProfilSumberDanaRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProfilSumberDana::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProfilSumberDanaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
