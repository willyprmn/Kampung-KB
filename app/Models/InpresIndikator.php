<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class InpresIndikator.
 *
 * @package namespace App\Models;
 */
class InpresIndikator extends Model implements Transformable
{
    use TransformableTrait;
    
    protected $table = 'new_inpres_indikators';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
