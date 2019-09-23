<?php

namespace App\Http\Middleware;

use Closure;

class zhoukao
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
        if(!$request->session()->exists('name')){
            return redirect('zk_login');
        }
        return $next($request);

    }
}
