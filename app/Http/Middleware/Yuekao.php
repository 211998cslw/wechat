<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Cache;
use Closure;

class Yuekao
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
        $ip=$_SERVER['REMOTE_ADDR'];//浏览网页的用户ip
        $cache_name='pass_time_'.$ip;
        $num=Cache::get($cache_name);//取
        if(!$num){
            $num=0;
        }
        if($num>50){
            echo "<script>alert('超过访问次数');</script>";
        }
        $num+=1;
        Cache::put($cache_name,$num,86400);//存
        return $next($request);
    }
}
