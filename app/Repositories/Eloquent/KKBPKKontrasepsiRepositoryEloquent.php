<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\KkbpkKontrasepsiRepository;
use App\Models\KkbpkKontrasepsi;
use App\Repositories\Validator\KkbpkKontrasepsiValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class KkbpkKontrasepsiRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class KkbpkKontrasepsiRepositoryEloquent extends BaseRepository implements KkbpkKontrasepsiRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return KkbpkKontrasepsi::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return KkbpkKontrasepsiValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
