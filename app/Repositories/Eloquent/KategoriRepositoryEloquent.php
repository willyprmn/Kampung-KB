<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\KategoriRepository;
use App\Models\Kategori;
use App\Repositories\Validator\KategoriValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class KategoriRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class KategoriRepositoryEloquent extends BaseRepository implements KategoriRepository, CacheableInterface
{

    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Kategori::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
