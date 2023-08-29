<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PendudukKampung.
 *
 * @package namespace App\Models;
 */
class PendudukKampung extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['kampung_kb_id', 'created_at', 'created_by', 'is_active'];
    public $table = 'new_penduduk_kampung';

    protected $touches = ['kampung'];

    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function kampung()
    {
        return $this->belongsTo(Kampung::class, 'kampung_kb_id');
    }

    public function ranges()
    {
        return $this->belongsToMany(Range::class, 'new_penduduk_range', 'penduduk_kampung_id')
            ->withTimestamps();
    }

    public function penduduk_ranges()
    {
        return $this->hasMany(PendudukRange::class);
    }

    public function keluargas()
    {
        return $this->belongsToMany(Keluarga::class, 'new_penduduk_keluarga', 'penduduk_kampung_id')
            ->using(PendudukKeluarga::class)
            ->withPivot(['penduduk_kampung_id', 'keluarga_id', 'jumlah'])
            ->as('pivot')
            ->withTimestamps();
    }


    public function getJumlahJiwaAttribute()
    {
        return $this->ranges->sum('pivot.jumlah');
    }

}