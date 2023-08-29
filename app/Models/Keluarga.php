<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

/**
 * Class Keluarga.
 *
 * @package namespace App\Models;
 */
class Keluarga extends Model implements Transformable
{

    use TransformableTrait;
    use EagerLoadPivotTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    public $table = 'new_keluarga';
}
