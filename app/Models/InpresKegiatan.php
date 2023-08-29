<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class InpresKegiatan.
 *
 * @package namespace App\Models;
 */
class InpresKegiatan extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'indikator', 'penanggung_jawab_id', 'inpres_program_id'];
    protected $table = 'new_inpres_kegiatans';

    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function instansis()
    {
        return $this->belongsToMany(Instansi::class, InpresInstansi::getTableName(), 'inpres_kegiatan_id')
            ->using(InpresInstansi::class)
            ->withTimestamps()
            ;
    }


    public function keywords()
    {

        return $this->belongsToMany(Keyword::class, InpresKegiatanKeyword::getTableName(), 'inpres_kegiatan_id')
            ->using(InpresKegiatanKeyword::class)
            ->withTimestamps()
            ;
    }

}
