<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Kecamatan.
 *
 * @package namespace App\Models;
 */
class Kecamatan extends Model implements Transformable
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
    public $table = 'new_kecamatan';

}
