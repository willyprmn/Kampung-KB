<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class KkbpkNonKontrasepsi.
 *
 * @package namespace App\Models;
 */
class KkbpkNonKontrasepsi extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['kkbpk_kampung_id', 'non_kontrasepsi_id', 'jumlah'];

    protected $table = 'new_kkbpk_non_kontrasepsi';

    public function non_kontrasepsi()
    {
        return $this->belongsTo(NonKontrasepsi::class);
    }

}
