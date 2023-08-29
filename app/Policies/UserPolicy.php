<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
                ->where('policy_of', User::class)
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
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', User::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
            case !empty($user->provinsi_id) && $user->provinsi_id !== $model->provinsi_id:
            case !empty($user->kabupaten_id) && $user->kabupaten_id !== $model->kabupaten_id:
            case !empty($user->kecamatan_id) && $user->kecamatan_id !== $model->kecamatan_id:
            case !empty($user->desa_id) && $user->desa_id !== $model->desa_id:
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
                ->where('policy_of', User::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak membuat user baru.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', User::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
            case !empty($user->provinsi_id) && $user->provinsi_id !== $model->provinsi_id:
            case !empty($user->kabupaten_id) && $user->kabupaten_id !== $model->kabupaten_id:
            case !empty($user->kecamatan_id) && $user->kecamatan_id !== $model->kecamatan_id:
            case !empty($user->desa_id) && $user->desa_id !== $model->desa_id:
                return Response::deny('Anda tidak berhak merubah user ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', User::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
            case !empty($user->provinsi_id) && $user->provinsi_id !== $model->provinsi_id:
            case !empty($user->kabupaten_id) && $user->kabupaten_id !== $model->kabupaten_id:
            case !empty($user->kecamatan_id) && $user->kecamatan_id !== $model->kecamatan_id:
            case !empty($user->desa_id) && $user->desa_id !== $model->desa_id:
                return Response::deny('Anda tidak berhak menghapus user ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can reset passwor the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function reset(User $user, User $model)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', User::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak merubah user ini.');
            default:
                return Response::allow();
        }
    }
}
