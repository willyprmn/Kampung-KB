<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\IntervensiGambarRepository;
use App\Models\IntervensiGambar;
use App\Repositories\Validator\IntervensiGambarValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class IntervensiGambarRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class IntervensiGambarRepositoryEloquent extends BaseRepository implements IntervensiGambarRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return IntervensiGambar::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
