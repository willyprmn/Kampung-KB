<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ProgramRepository;
use App\Models\Program;
use App\Repositories\Validator\ProgramValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ProgramRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ProgramRepositoryEloquent extends BaseRepository implements ProgramRepository, CacheableInterface
{

    use CacheableRepository;

    protected $fieldSearchable = [
        'name',
        'groups.name',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Program::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
