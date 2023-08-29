<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ProgramGroupDetail.
 *
 * @package namespace App\Models;
 */
class ProgramGroupDetail extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'new_program_group_details';
    protected $fillable = ['program_group_id', 'program_id'];
    protected $date = ['created_at', 'updated_at'];

}
