<?php

namespace App\Policies;

use App\Models\ProfilKampung;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilPolicy
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
     * @param  \App\Models\ProfilKampung  $profilKampung
     * @return mixed
     */
    public function view(User $user, ProfilKampung $profilKampung, $kampung)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', ProfilKampung::class)
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
                ->where('policy_of', ProfilKampung::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
            case !empty($user->provinsi_id) && $user->provinsi_id !== $kampung->provinsi_id:
            case !empty($user->kabupaten_id) && $user->kabupaten_id !== $kampung->kabupaten_id:
            case !empty($user->kecamatan_id) && $user->kecamatan_id !== $kampung->kecamatan_id:
            case !empty($user->desa_id) && $user->desa_id !== $kampung->desa_id:
                return Response::deny('Anda tidak berhak membuat Laporan Profil Perkembangan baru.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProfilKampung  $profilKampung
     * @return mixed
     */
    public function update(User $user, ProfilKampung $profilKampung)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', ProfilKampung::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak merubah Laporan Profil Perkembangan ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProfilKampung  $profilKampung
     * @return mixed
     */
    public function delete(User $user, ProfilKampung $profilKampung)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', ProfilKampung::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak menghapus Laporan Profil Perkembangan ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProfilKampung  $profilKampung
     * @return mixed
     */
    public function restore(User $user, ProfilKampung $profilKampung)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProfilKampung  $profilKampung
     * @return mixed
     */
    public function forceDelete(User $user, ProfilKampung $profilKampung)
    {
        //
    }
}
