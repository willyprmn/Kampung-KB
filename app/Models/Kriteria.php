<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Kriteria.
 *
 * @package namespace App\Models;
 */
class Kriteria extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'new_kriteria';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
