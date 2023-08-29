<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\KkbpkProgramRepository;
use App\Models\KkbpkProgram;
use App\Repositories\Validator\KkbpkProgramValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class KkbpkProgramRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class KkbpkProgramRepositoryEloquent extends BaseRepository implements KkbpkProgramRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return KkbpkProgram::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return KkbpkProgramValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
