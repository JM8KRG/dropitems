<?php

namespace DropItems\Http\Middleware\Sentinel;

use Closure;

/**
 * Class Auth
 * @package DropItems\Http\Middleware\Sentinel
 */

class Auth
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
        // ログインしていれば通過
        if (\Sentinel::check()) {
            return $next($request);
        }

        return redirect()->action('Sentinel\LoginController@index');
    }
}
