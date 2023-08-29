<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class JenisPost.
 *
 * @package namespace App\Models;
 */
class JenisPost extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'new_jenis_post';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];


    public function intervensi_gambar_types()
    {
        return $this->hasMany(IntervensiGambarType::class, 'jenis_post_id');
    }

}
