<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\KkbpkNonKontrasepsiRepository;
use App\Models\KkbpkNonKontrasepsi;
use App\Repositories\Validator\KkbpkNonKontrasepsiValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
/**
 * Class KkbpkNonKontrasepsiRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class KkbpkNonKontrasepsiRepositoryEloquent extends BaseRepository implements KkbpkNonKontrasepsiRepository, CacheableInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return KkbpkNonKontrasepsi::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return KkbpkNonKontrasepsiValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
