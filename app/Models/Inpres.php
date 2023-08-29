<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Inpres.
 *
 * @package namespace App\Models;
 */
class Inpres extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $table = 'new_inpres';


    public function inpres_sasarans()
    {
        return $this->hasMany(InpresSasaran::class);
    }

}
