<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class KkbpkKontrasepsi.
 *
 * @package namespace App\Models;
 */
class KkbpkKontrasepsi extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'new_kkbpk_kontrasepsi';
    /**
     * The attributes that are mass assignable.
     * componentShouldUpdate()
     *
     * @var array
     */
    protected $fillable = ['kkbpk_kampung_id', 'kontrasepsi_id', 'jumlah'];

    public function kontrasepsi()
    {
        return $this->belongsTo(Kontrasepsi::class);
    }
}
