<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\InpresInstansiRepository;
use App\Models\InpresInstansi;
use App\Repositories\Validator\InpresInstansiValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class InpresInstansiRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class InpresInstansiRepositoryEloquent extends BaseRepository implements InpresInstansiRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InpresInstansi::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
