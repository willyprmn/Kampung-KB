<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class InpresSasaran.
 *
 * @package namespace App\Models;
 */
class InpresSasaran extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'inpres_id'];
    protected $table = 'new_inpres_sasarans';

    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function inpres_programs()
    {
        return $this->hasMany(InpresProgram::class);
    }
}
