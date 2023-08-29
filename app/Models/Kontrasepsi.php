<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Kontrasepsi.
 *
 * @package namespace App\Models;
 */
class Kontrasepsi extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'new_kontrasepsi';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
