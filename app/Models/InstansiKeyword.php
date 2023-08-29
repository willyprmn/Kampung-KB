<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class InstansiKeyword.
 *
 * @package namespace App\Models;
 */
class InstansiKeyword extends Pivot implements Transformable
{
    use TransformableTrait;

    protected $table = 'new_instansi_keywords';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];


    public static function getTableName()
    {
        return (new self())->getTable();
    }

}
