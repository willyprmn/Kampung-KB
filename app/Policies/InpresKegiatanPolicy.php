<?php

namespace App\Policies;

use App\Models\InpresKegiatan;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class InpresKegiatanPolicy
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
                ->where('policy_of', InpresKegiatan::class)
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
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return mixed
     */
    public function view(User $user, InpresKegiatan $inpresKegiatan)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', InpresKegiatan::class)
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
                ->where('policy_of', InpresKegiatan::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak membuat Kegiatan Inpres baru.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return mixed
     */
    public function update(User $user, InpresKegiatan $inpresKegiatan)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', InpresKegiatan::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak merubah Kegiatan Inpres ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return mixed
     */
    public function delete(User $user, InpresKegiatan $inpresKegiatan)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', InpresKegiatan::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak merubah Kegiatan Inpres ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return mixed
     */
    public function restore(User $user, InpresKegiatan $inpresKegiatan)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return mixed
     */
    public function forceDelete(User $user, InpresKegiatan $inpresKegiatan)
    {
        //
    }
}
