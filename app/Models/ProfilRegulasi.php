<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class ProfilRegulasi.
 *
 * @package namespace App\Models;
 */
class ProfilRegulasi extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    public $table = 'new_profil_regulasi';

}
