<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Repositories\Contract\UserRepository;

class MenuPolicy
{

    protected $userRepository;

    use HandlesAuthorization;


    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {

        dd('a');

        // dd('test');

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function view(User $user, Menu $menu)
    {

        dd('b');
        // dd($user->toArray());
        // dd($menu->toArray());
        // $user = $this->userRepository
        //     ->whereHas('roles', function ($role) use ($menu) {
        //         $role->whereHas('menus', function ($query) use ($menu) {
        //             return $query->where("{$menu->getTable()}.id", $menu->id);
        //         });
        //     })->first();

        // dd($user->toArray());

        return true;
        // return true; $this->userRepository
        // ->whereHas('roles', function ($role) use ($menu) {
        //     $role->whereHas('menus', function ($query) use ($menu) {
        //         return $query->where("{$menu->getTable()}.id", $menu->id);
        //     });
        // })->first();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {

        dd('c');
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function update(User $user, Menu $menu)
    {

        dd('d');
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function delete(User $user, Menu $menu)
    {
        dd('e');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function restore(User $user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function forceDelete(User $user, Menu $menu)
    {
        dd('f');
    }
}
