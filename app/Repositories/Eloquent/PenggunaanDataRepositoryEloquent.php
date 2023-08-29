<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\PenggunaanDataRepository;
use App\Models\PenggunaanData;
use App\Repositories\Validator\PenggunaanDataValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class PenggunaanDataRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class PenggunaanDataRepositoryEloquent extends BaseRepository implements PenggunaanDataRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PenggunaanData::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PenggunaanDataValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
