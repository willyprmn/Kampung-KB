<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User.
 *
 * @package namespace App\Models;
 */
class User extends Authenticatable implements Transformable
{
    use TransformableTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'phone',
        'password',
        'siga_id',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'is_active'
    ];
    protected $table = 'new_users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getTableName()
    {
        return (new self())->getTable();
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'new_user_roles', 'user_id')
            ->using(UserRole::class)
            ->withTimestamps();
    }


    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }


    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }


    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

}
