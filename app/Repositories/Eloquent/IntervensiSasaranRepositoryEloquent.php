<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\IntervensiSasaranRepository;
use App\Models\IntervensiSasaran;
use App\Repositories\Validator\IntervensiSasaranValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class IntervensiSasaranRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class IntervensiSasaranRepositoryEloquent extends BaseRepository implements IntervensiSasaranRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return IntervensiSasaran::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return IntervensiSasaranValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
