<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ProfilPenggunaanDataRepository;
use App\Models\ProfilPenggunaanData;
use App\Repositories\Validator\ProfilPenggunaanDataValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ProfilPenggunaanDataRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ProfilPenggunaanDataRepositoryEloquent extends BaseRepository implements ProfilPenggunaanDataRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProfilPenggunaanData::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProfilPenggunaanDataValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
