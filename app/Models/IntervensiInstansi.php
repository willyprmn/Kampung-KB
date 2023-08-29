<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class IntervensiInstansi.
 *
 * @package namespace App\Models;
 */
class IntervensiInstansi extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['intervensi_id', 'instansi_lainnya', 'instansi_id'];
    protected $table = 'new_intervensi_instansi';

    public static function getTableName()
    {
        return (new self())->getTable();
    }

}
