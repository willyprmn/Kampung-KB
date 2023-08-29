<?php

namespace App\Http\Middleware;

use Closure;

class ActiveOnly
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

        if (!$request->expectsJson() && $request->user()->is_active !== true) {
            abort(403, 'User sudah tidak aktif. Silahkan hubungi Adminisstrator');
        }

        return $next($request);
    }
}
