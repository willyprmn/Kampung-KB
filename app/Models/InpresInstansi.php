<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class InpresInstansi.
 *
 * @package namespace App\Models;
 */
class InpresInstansi extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    protected $table = 'new_inpres_instansis';

    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
