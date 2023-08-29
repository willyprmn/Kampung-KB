<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ConfigurationStatisticRepository;
use App\Models\ConfigurationStatistic;
use App\Repositories\Validator\ConfigurationStatisticValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ConfigurationStatisticRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ConfigurationStatisticRepositoryEloquent extends BaseRepository implements ConfigurationStatisticRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ConfigurationStatistic::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
