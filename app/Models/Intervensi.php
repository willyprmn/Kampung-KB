<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Intervensi.
 *
 * @package namespace App\Models;
 */
class Intervensi extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inpres_kegiatan_id',
        'kampung_kb_id',
        'jenis_post_id',
        'judul',
        'tanggal',
        'tempat',
        'deskripsi',
        'kategori_id',
    ];
    protected $touches = ['kampung'];
    protected $table = 'new_intervensi';
    protected $dates = ['tanggal', 'created_at', 'updated_at'];


    public static function getTableName()
    {
        return (new self())->getTable();
    }


    public function kampung()
    {
        return $this->belongsTo(Kampung::class, 'kampung_kb_id');
    }


    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }


    public function program()
    {
        return $this->belongsTo(Program::class);
    }


    public function instansis()
    {
        return $this->belongsToMany(Instansi::class, 'new_intervensi_instansi', 'intervensi_id')
            ->using(IntervensiInstansi::class)
            ->withPivot(['instansi_lainnya'])
            ->withTimestamps()
            ;
    }

    public function jenis()
    {
        return $this->belongsTo(JenisPost::class, 'jenis_post_id');
    }


    public function sasarans()
    {
        return $this->belongsToMany(Sasaran::class, 'new_intervensi_sasaran', 'intervensi_id')
            ->using(IntervensiSasaran::class)
            ->withPivot(['sasaran_lainnya'])
            ->withTimestamps()
            ;
    }


    public function inpres_kegiatan()
    {
        return $this->belongsTo(InpresKegiatan::class, 'inpres_kegiatan_id');
    }

    public function intervensi_gambars()
    {
        return $this->hasMany(IntervensiGambar::class, 'intervensi_id');
    }


    public function intervensi_gambar()
    {
        return $this->hasOne(IntervensiGambar::class, 'intervensi_id', 'id');
    }

}