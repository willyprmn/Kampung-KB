<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;


/**
 * Class ProfilPenggunaanData.
 *
 * @package namespace App\Models;
 */
class ProfilPenggunaanData extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $table = 'new_profil_penggunaan_data';

    public function data()
    {
        return $this->belongsTo(PenggunaanData::class, 'penggunaan_data_id');
    }
}
