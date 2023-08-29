<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Keyword.
 *
 * @package namespace App\Models;
 */
class Keyword extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'new_keywords';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public static function getTableName()
    {
        return (new self())->getTable();
    }

}
