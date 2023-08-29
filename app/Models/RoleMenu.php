<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class RoleMenu.
 *
 * @package namespace App\Models;
 */
class RoleMenu extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    protected $table = 'new_role_menus';


    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

}
