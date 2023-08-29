<?php

namespace App\Policies;

use App\Models\Kkbpk;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class KkbpkPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kkbpk  $kkbpk
     * @return mixed
     */
    public function view(User $user, Kkbpk $kkbpk, $kampung)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', Kkbpk::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
            case !empty($user->provinsi_id) && $user->provinsi_id !== $kampung->provinsi_id:
            case !empty($user->kabupaten_id) && $user->kabupaten_id !== $kampung->kabupaten_id:
            case !empty($user->kecamatan_id) && $user->kecamatan_id !== $kampung->kecamatan_id:
            case !empty($user->desa_id) && $user->desa_id !== $kampung->desa_id:
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
    public function create(User $user, $kampung)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', Kkbpk::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
            case !empty($user->provinsi_id) && $user->provinsi_id !== $kampung->provinsi_id:
            case !empty($user->kabupaten_id) && $user->kabupaten_id !== $kampung->kabupaten_id:
            case !empty($user->kecamatan_id) && $user->kecamatan_id !== $kampung->kecamatan_id:
            case !empty($user->desa_id) && $user->desa_id !== $kampung->desa_id:
                return Response::deny('Anda tidak berhak membuat Laporan Perkembangan KKBPK baru.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kkbpk  $kkbpk
     * @return mixed
     */
    public function update(User $user, Kkbpk $kkbpk, $kampung)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', Kkbpk::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
            case !empty($user->provinsi_id) && $user->provinsi_id !== $kampung->provinsi_id:
            case !empty($user->kabupaten_id) && $user->kabupaten_id !== $kampung->kabupaten_id:
            case !empty($user->kecamatan_id) && $user->kecamatan_id !== $kampung->kecamatan_id:
            case !empty($user->desa_id) && $user->desa_id !== $kampung->desa_id:
                return Response::deny('Anda tidak berhak merubah Laporan Perkembangan KKBPK ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kkbpk  $kkbpk
     * @return mixed
     */
    public function delete(User $user, Kkbpk $kkbpk, $kampung)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', Kkbpk::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
            case !empty($user->provinsi_id) && $user->provinsi_id !== $kampung->provinsi_id:
            case !empty($user->kabupaten_id) && $user->kabupaten_id !== $kampung->kabupaten_id:
            case !empty($user->kecamatan_id) && $user->kecamatan_id !== $kampung->kecamatan_id:
            case !empty($user->desa_id) && $user->desa_id !== $kampung->desa_id:
                return Response::deny('Anda tidak berhak menghapus Laporan Perkembangan KKBPK ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kkbpk  $kkbpk
     * @return mixed
     */
    public function restore(User $user, Kkbpk $kkbpk)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kkbpk  $kkbpk
     * @return mixed
     */
    public function forceDelete(User $user, Kkbpk $kkbpk)
    {
        //
    }
}
