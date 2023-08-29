<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Program.
 *
 * @package namespace App\Models;
 */
class Program extends Model implements Transformable
{
    use TransformableTrait;

    public $table = 'new_program';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'deskripsi'];
    protected $date = ['created_at', 'updated_at'];


    /**
     * Scope a query to only poktan program
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeKkbpk($query)
    {
        return $query->whereHas('groups', function ($group) {
            return $group->where(ProgramGroup::getTableName() . '.id', 2);
        });
    }


    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function groups()
    {
        return $this->belongsToMany(ProgramGroup::class, 'new_program_group_details', 'program_id');
    }

    public function profils()
    {
        return $this->belongsToMany(ProfilKampung::class, 'new_profil_program', 'program_id', 'profil_id')
            ->using(ProfilProgram::class);
    }


    public function profil_programs()
    {
        return $this->hasMany(ProfilProgram::class, 'program_id');
    }

}
