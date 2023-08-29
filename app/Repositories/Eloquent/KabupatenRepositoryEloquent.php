<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\KabupatenRepository;
use App\Models\Kabupaten;
use App\Repositories\Validator\KabupatenValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class KabupatenRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class KabupatenRepositoryEloquent extends BaseRepository implements KabupatenRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Kabupaten::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
