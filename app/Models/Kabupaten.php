<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Kabupaten.
 *
 * @package namespace App\Models;
 */
class Kabupaten extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    public $incrementing = false;
    public $keyType = 'string';
    public $table = 'new_kabupaten';

}