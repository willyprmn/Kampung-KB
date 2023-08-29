<?php

namespace App\Repositories\Eloquent;

use DB;
use Log;

use App\Models\Intervensi;
use App\Repositories\Contract\IntervensiRepository;
use App\Repositories\Validator\IntervensiValidator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityCreating;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use Prettus\Repository\Events\RepositoryEntityDeleting;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Repository\Events\RepositoryEntityUpdating;

use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class IntervensiRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class IntervensiRepositoryEloquent extends BaseRepository implements IntervensiRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Intervensi::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return IntervensiValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return mixed
     */
    // public function create(array $attributes)
    // {
    //     if (!is_null($this->validator)) {
    //         // we should pass data that has been casts by the model
    //         // to make sure data type are same because validator may need to use
    //         // this data to compare with data that fetch from database.
    //         if ($this->versionCompare($this->app->version(), "5.2.*", ">")) {
    //             $attributes = $this->model->newInstance()->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();
    //         } else {
    //             $model = $this->model->newInstance()->forceFill($attributes);
    //             $model->makeVisible($this->model->getHidden());
    //             $attributes = $model->toArray();
    //         }

    //         $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
    //     }

    //     event(new RepositoryEntityCreating($this, $attributes));

    //     try {

    //         DB::beginTransaction();

    //         Log::info($attributes);
    //         $model = $this->model->newInstance($attributes);
    //         $model->save();

    //         $model->instansis()->sync($attributes['instansi_id']);
    //         $model->sasarans()->sync($attributes['sasaran_id']);

    //         $this->resetModel();

    //         DB::commit();

    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         Log::error(__METHOD__ . ":" . $e->getMessage());
    //         throw new \Exception($e->getMessage());
    //     }

    //     event(new RepositoryEntityCreated($this, $model));

    //     return $this->parserResult($model);
    // }

}
