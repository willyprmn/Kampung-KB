<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Instansi.
 *
 * @package namespace App\Models;
 */
class Instansi extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'alias'];

    protected $table = 'new_instansi';


    public function keywords()
    {

        return $this->belongsToMany(Keyword::class, InstansiKeyword::getTableName())
            ->using(InstansiKeyword::class)
            ->withTimestamps()
            ;
    }

    public function intervensis()
    {
        return $this->belongsToMany(Intervensi::class, IntervensiInstansi::getTableName())
            ->using(IntervensiInstansi::class)
            ->withTimestamps()
            ;
    }
}
