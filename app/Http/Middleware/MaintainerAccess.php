<?php

namespace App\Http\Middleware;

use Closure;

class MaintainerAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            abort(401);
        }

        if (!($_SERVER['PHP_AUTH_USER'] === config('maintainer.key') && $_SERVER['PHP_AUTH_PW'] === config('maintainer.secret'))) {
            abort(401);
        }

        return $next($request);
    }
}
