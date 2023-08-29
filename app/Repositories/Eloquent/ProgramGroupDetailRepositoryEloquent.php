<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ProgramGroupDetailRepository;
use App\Models\ProgramGroupDetail;
use App\Repositories\Validator\ProgramGroupDetailValidator;

/**
 * Class ProgramGroupDetailRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ProgramGroupDetailRepositoryEloquent extends BaseRepository implements ProgramGroupDetailRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProgramGroupDetail::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
