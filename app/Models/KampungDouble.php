<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KampungDouble extends Model
{
    protected $fillable = [
        'kampung_id',
        'kampung_id_double',
        'merger_proses',
        'merger_kriteria'
    ];
    protected $dates = ['created_at', 'updated_at'];

    public $table = 'new_kampung_double';

}
