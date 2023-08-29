<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\InstansiKeywordRepository;
use App\Models\InstansiKeyword;
use App\Repositories\Validator\InstansiKeywordValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class InstansiKeywordRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class InstansiKeywordRepositoryEloquent extends BaseRepository implements InstansiKeywordRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InstansiKeyword::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
