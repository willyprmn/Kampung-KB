<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\SigaRegionalRepository;
use App\Models\SigaRegional;
use App\Repositories\Validator\SigaRegionalValidator;

/**
 * Class SigaRegionalRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class SigaRegionalRepositoryEloquent extends BaseRepository implements SigaRegionalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SigaRegional::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
