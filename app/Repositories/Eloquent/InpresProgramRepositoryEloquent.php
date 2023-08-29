<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\InpresProgramRepository;
use App\Models\InpresProgram;
use App\Repositories\Validator\InpresProgramValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class InpresProgramRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class InpresProgramRepositoryEloquent extends BaseRepository implements InpresProgramRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InpresProgram::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
