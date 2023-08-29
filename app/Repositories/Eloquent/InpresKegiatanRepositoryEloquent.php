<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\InpresKegiatanRepository;
use App\Models\InpresKegiatan;
use App\Repositories\Validator\InpresKegiatanValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class InpresKegiatanRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class InpresKegiatanRepositoryEloquent extends BaseRepository implements InpresKegiatanRepository, CacheableInterface
{

    use CacheableRepository;

    protected $fieldSearchable = [
        'name',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InpresKegiatan::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
