<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\InpresSasaranRepository;
use App\Models\InpresSasaran;
use App\Repositories\Validator\InpresSasaranValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class InpresSasaranRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class InpresSasaranRepositoryEloquent extends BaseRepository implements InpresSasaranRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InpresSasaran::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
