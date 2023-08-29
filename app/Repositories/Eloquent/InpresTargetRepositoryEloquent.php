<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\InpresTargetRepository;
use App\Models\InpresTarget;
use App\Repositories\Validator\InpresTargetValidator;

/**
 * Class InpresTargetRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class InpresTargetRepositoryEloquent extends BaseRepository implements InpresTargetRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InpresTarget::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
