<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\InpresKegiatanKeywordRepository;
use App\Models\InpresKegiatanKeyword;
use App\Repositories\Validator\InpresKegiatanKeywordValidator;

/**
 * Class InpresKegiatanKeywordRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class InpresKegiatanKeywordRepositoryEloquent extends BaseRepository implements InpresKegiatanKeywordRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InpresKegiatanKeyword::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
