<?php

namespace DropItems\Http\Middleware\Sentinel;

use Closure;


/**
 * Class Guest
 * @package DropItems\Http\Middleware\Sentinel
 */

class Guest
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
        // ログインしていなければ通過
        if (!\Sentinel::check()) {
            return $next($request);
        }

        return redirect()->action('HomeController@index');
    }
}
