<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Archive.
 *
 * @package namespace App\Models;
 */
class Archive extends Model implements Transformable
{


    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'ext', 'path'];
    protected $table = 'new_archives';


    public function attachable()
    {
        return $this->morphTo();
    }
}
