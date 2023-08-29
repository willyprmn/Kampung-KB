<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Kategori.
 *
 * @package namespace App\Models;
 */
class Kategori extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'new_kategori';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}