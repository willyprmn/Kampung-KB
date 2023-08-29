<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class ProfilProgram.
 *
 * @package namespace App\Models;
 */
class ProfilProgram extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    public $table = 'new_profil_program';

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function profil()
    {
        return $this->belongsTo(ProfilKampung::class);
    }
}
