<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ProfilRepository;
use App\Models\ProfilKampung;
use App\Repositories\Validator\ProfilValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
/**
 * Class ProfilRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ProfilRepositoryEloquent extends BaseRepository implements ProfilRepository, CacheableInterface
{

    use CacheableRepository;

    protected $fieldSearchable = [
        'kampung_kb_id',
        'is_active',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProfilKampung::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
