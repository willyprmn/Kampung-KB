<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\IntervensiGambarTypeRepository;
use App\Models\IntervensiGambarType;
use App\Repositories\Validator\IntervensiGambarTypeValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class IntervensiGambarTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class IntervensiGambarTypeRepositoryEloquent extends BaseRepository implements IntervensiGambarTypeRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return IntervensiGambarType::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
