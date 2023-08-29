<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Kkbpk.
 *
 * @package namespace App\Models;
 */
class Kkbpk extends Model implements Transformable
{
    use TransformableTrait;

    public $table = 'new_kkbpk_kampung';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kampung_kb_id',
        'pengguna_bpjs',
        'is_active',
        'bulan',
        'tahun',
        'created_at',
        'updated_at'
    ];

    protected $touches = ['kampung'];

    public static function getTableName()
    {
        return (new self())->getTable();
    }


    public function kampung()
    {
        return $this->belongsTo(Kampung::class, 'kampung_kb_id');
    }


    public function kkbpk_kontrasepsis()
    {
        return $this->hasMany(KkbpkKontrasepsi::class, 'kkbpk_kampung_id');
    }

    public function kontrasepsis()
    {
        return $this->belongsToMany(Kontrasepsi::class, 'new_kkbpk_kontrasepsi', 'kkbpk_kampung_id')
            ->withTimestamps();
    }

    public function kkbpk_programs()
    {
        return $this->hasMany(KkbpkProgram::class, 'kkbpk_kampung_id');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'new_kkbpk_program', 'kkbpk_kampung_id')
            ->using(KkbpkProgram::class)
            ->withTimestamps();
    }


    public function kkbpk_non_kontrasepsis()
    {
        return $this->hasMany(KkbpkNonKontrasepsi::class, 'kkbpk_kampung_id');
    }


    public function non_kontrasepsis()
    {
        return $this->belongsToMany(NonKontrasepsi::class, 'new_kkbpk_non_kontrasepsi', 'kkbpk_kampung_id')
            ->withTimestamps();
    }
}
