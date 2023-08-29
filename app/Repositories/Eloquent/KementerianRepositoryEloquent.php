<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\KementerianRepository;
use App\Models\Kementerian;
use App\Repositories\Validator\KementerianValidator;

/**
 * Class KementerianRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class KementerianRepositoryEloquent extends BaseRepository implements KementerianRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Kementerian::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
