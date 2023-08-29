<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class ProfilSumberDana.
 *
 * @package namespace App\Models;
 */
class ProfilSumberDana extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $table = 'new_profil_sumber_dana';

    public function sumber()
    {
        return $this->belongsTo(SumberDana::class, 'sumber_dana_id');
    }
}
