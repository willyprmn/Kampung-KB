<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Scopes\KampungActiveScope;
/**
 * Class Kampung.
 *
 * @package namespace App\Models;
 */
class Kampung extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'new_kampung_kb';
    public $primaryKey = 'id';
    public $dates = ['tanggal_pencanangan', 'created_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'tanggal_pencanangan',
        'penanggungjawab_id',
        'gambaran_umum',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'path_gambar',
        'path_struktur',
        'contoh_kabupaten_flag',
        'contoh_provinsi_flag',
        'is_active',
    ];


    public static function getTableName()
    {
        return (new self())->getTable();
    }


    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }


    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }


    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }


    public function kriterias()
    {
        return $this->belongsToMany(Kriteria::class, 'new_kampung_kriteria', 'kampung_kb_id');
    }

    public function penduduks()
    {
        return $this->hasMany(PendudukKampung::class, 'kampung_kb_id');
    }


    public function penduduk()
    {
        return $this->hasOne(PendudukKampung::class, 'kampung_kb_id')
            ->where('is_active', '1')
            ->orderBy('id', 'desc')
            ;
    }


    public function profil()
    {
        return $this->hasOne(ProfilKampung::class, 'kampung_kb_id')
            ->where('is_active', true)
            ->orderBy('id', 'desc')
            ;
    }

    public function profils()
    {
        return $this->hasMany(ProfilKampung::class, 'kampung_kb_id');
    }


    public function kkbpks()
    {
        return $this->hasMany(Kkbpk::class, 'kampung_kb_id');
    }


    public function kkbpk()
    {
        return $this->hasOne(Kkbpk::class, 'kampung_kb_id')
            ->where('is_active', '1')
            ->orderBy('id', 'desc')
            ;
    }

    public function intervensis()
    {
        return $this->hasMany(Intervensi::class, 'kampung_kb_id');
    }

    public function scopeActive($query)
    {
        $query->where("{$this->table}.is_active", true);
    }



    protected static function booted()
    {
        static::addGlobalScope(new KampungActiveScope);
    }
}
