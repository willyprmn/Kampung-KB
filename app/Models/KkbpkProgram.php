<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class KkbpkProgram.
 *
 * @package namespace App\Models;
 */
class KkbpkProgram extends Pivot implements Transformable
{
    use TransformableTrait;

    protected $table = 'new_kkbpk_program';
    /**
     * The attributes that are mass assignable.
     * componentShouldUpdate()
     *
     * @var array
     */
    protected $fillable = ['kkbpk_kampung_id', 'program_id', 'jumlah'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

}
