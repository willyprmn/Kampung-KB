<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\InpresIndikatorRepository;
use App\Models\InpresIndikator;
use App\Repositories\Validator\InpresIndikatorValidator;

/**
 * Class InpresIndikatorRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class InpresIndikatorRepositoryEloquent extends BaseRepository implements InpresIndikatorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InpresIndikator::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
