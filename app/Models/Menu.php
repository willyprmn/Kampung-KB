<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Menu.
 *
 * @package namespace App\Models;
 */
class Menu extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    protected $table = 'new_menus';


    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'new_role_menus', 'menu_id')
            ->using(RoleMenu::class)
            ->withTimestamps()
            ;
    }

    public function role_menus()
    {
        return $this->hasMany(RoleMenu::class);
    }


    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

}
