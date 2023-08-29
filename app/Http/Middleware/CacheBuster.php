<?php

namespace App\Http\Middleware;

use Cache;
use Closure;

class CacheBuster
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

        if (request()->has('flush')) {
            Cache::flush();
        }

        return $next($request);
    }
}
