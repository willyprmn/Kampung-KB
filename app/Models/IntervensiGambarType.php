<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class IntervensiGambarType.
 *
 * @package namespace App\Models;
 */
class IntervensiGambarType extends Model implements Transformable
{
    use TransformableTrait;

    public $table = 'new_intervensi_gambar_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
