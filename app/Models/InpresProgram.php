<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class InpresProgram.
 *
 * @package namespace App\Models;
 */
class InpresProgram extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'inpres_sasaran_id'];
    protected $table = 'new_inpres_programs';

    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function inpres_kegiatans()
    {
        return $this->hasMany(InpresKegiatan::class, 'inpres_program_id');
    }

    public function intervensis()
    {
        return $this->hasManyThrough(Intervensi::class, InpresKegiatan::class);
    }
}
