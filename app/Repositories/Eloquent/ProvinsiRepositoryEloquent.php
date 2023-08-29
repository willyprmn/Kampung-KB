<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ProvinsiRepository;
use App\Models\Provinsi;
use App\Repositories\Validator\ProvinsiValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ProvinsiRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ProvinsiRepositoryEloquent extends BaseRepository implements ProvinsiRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Provinsi::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
