<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PendudukKeluarga extends Pivot
{
    public $table = 'new_penduduk_keluarga';

    public function penduduk_kampung()
    {
        return $this->belongsTo(PendudukKampung::class, 'penduduk_kampung_id');
    }

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }
}
