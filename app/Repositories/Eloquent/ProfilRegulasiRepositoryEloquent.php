<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ProfilRegulasiRepository;
use App\Models\ProfilRegulasi;
use App\Repositories\Validator\ProfilRegulasiValidator;

/**
 * Class ProfilRegulasiRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ProfilRegulasiRepositoryEloquent extends BaseRepository implements ProfilRegulasiRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProfilRegulasi::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
