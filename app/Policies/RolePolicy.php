<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', Role::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak mengakses halaman ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', Role::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak mengakses halaman ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', Role::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak membuat role baru.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', Role::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak merubah role ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', Role::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak menghapus role ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function restore(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function forceDelete(User $user, Role $role)
    {
        //
    }
}
