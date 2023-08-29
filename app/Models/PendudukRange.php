<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PendudukRange extends Pivot implements Transformable
{

    use TransformableTrait;

    protected $table = 'new_penduduk_range';

    public function penduduk_kampung()
    {
        return $this->belongsTo(PendudukKampung::class, 'penduduk_kampung_id');
    }

    public function range()
    {
        return $this->belongsTo(Range::class);
    }
}
