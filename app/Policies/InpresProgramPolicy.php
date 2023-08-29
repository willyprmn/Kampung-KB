<?php

namespace App\Policies;

use App\Models\InpresProgram;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class InpresProgramPolicy
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
                ->where('policy_of', InpresProgram::class)
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
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return mixed
     */
    public function view(User $user, InpresProgram $inpresProgram)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', InpresProgram::class)
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
                ->where('policy_of', InpresProgram::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak membuat Program Inpres baru.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return mixed
     */
    public function update(User $user, InpresProgram $inpresProgram)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', InpresProgram::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak merubah Program Inpres ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return mixed
     */
    public function delete(User $user, InpresProgram $inpresProgram)
    {
        switch (true) {
            case session()
                ->get('permissions')
                ->where('policy_of', InpresProgram::class)
                ->where('name', __FUNCTION__)
                ->isEmpty():
                return Response::deny('Anda tidak berhak merubah Program Inpres ini.');
            default:
                return Response::allow();
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return mixed
     */
    public function restore(User $user, InpresProgram $inpresProgram)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return mixed
     */
    public function forceDelete(User $user, InpresProgram $inpresProgram)
    {
        //
    }
}
