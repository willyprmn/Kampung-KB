<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ProgramGroup.
 *
 * @package namespace App\Models;
 */
class ProgramGroup extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    public $table = 'new_program_group';

    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'new_program_group_details', 'program_group_id')
            ->withTimestamps();
    }

}
