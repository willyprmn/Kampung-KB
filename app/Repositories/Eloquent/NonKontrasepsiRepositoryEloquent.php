<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\NonKontrasepsiRepository;
use App\Models\NonKontrasepsi;
use App\Repositories\Validator\NonKontrasepsiValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class NonKontrasepsiRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class NonKontrasepsiRepositoryEloquent extends BaseRepository implements NonKontrasepsiRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NonKontrasepsi::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return NonKontrasepsiValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
