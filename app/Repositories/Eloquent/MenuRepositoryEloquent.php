<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\MenuRepository;
use App\Models\Menu;
use Prettus\Repository\Contracts\CacheableInterface;
use App\Repositories\Validator\MenuValidator;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class MenuRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class MenuRepositoryEloquent extends BaseRepository implements MenuRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Menu::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
