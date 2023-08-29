<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class IntervensiGambar.
 *
 * @package namespace App\Models;
 */
class IntervensiGambar extends Model implements Transformable
{
    use TransformableTrait;

    protected $appends = ['url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['intervensi_id', 'caption', 'path', 'intervensi_gambar_type_id', 'created_at', 'updated_at'];
    protected $table = 'new_intervensi_gambar';


    public static function getTableName()
    {
        return (new self())->getTable();
    }


    public function getUrlAttribute()
    {

        if (!Storage::exists($this->path)) return null;
        return config('app.url') . Storage::url($this->path);
    }

}
