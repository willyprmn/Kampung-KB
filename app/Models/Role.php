<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Role.
 *
 * @package namespace App\Models;
 */
class Role extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    protected $table = 'new_roles';


    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'new_role_menus', 'role_id')
            ->using(RoleMenu::class)
            ->withTimestamps()
            ;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'new_user_roles', 'role_id')
            ->using(UserRole::class)
            ->withTimestamps()
            ;
    }


    public function user_roles()
    {
        return $this->hasMany(UserRole::class);
    }


    public function children()
    {
        return $this->belongsToMany(Role::class, 'new_role_levels', 'role_id', 'child_id')
            ->using(RoleLevel::class)
            ->withTimestamps()
            ;
    }

}
