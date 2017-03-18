<?php

namespace DropItems\Http\Middleware;

use Closure;

class Sentinel
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
        if (!\Sentinel::check()) {
            return redirect()->action('Sentinel\LoginController@index');
        }
        return $next($request);
    }
}
