<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ConfigurationStatistic.
 *
 * @package namespace App\Models;
 */
class ConfigurationStatistic extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'title', 'description', 'tooltip'];
    protected $table = 'new_configuration_statistics';

}
