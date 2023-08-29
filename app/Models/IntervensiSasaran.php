<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class IntervensiSasaran.
 *
 * @package namespace App\Models;
 */
class IntervensiSasaran extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['intervensi_id', 'sasaran_id', 'sasaran_lainnya', 'created_at', 'updated_at'];

    protected $table = 'new_intervensi_sasaran';

}
