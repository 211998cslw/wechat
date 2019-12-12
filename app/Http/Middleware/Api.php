<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
class Api
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
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //根据ip作防刷
        //获取到ip php如何获取客户端ip
        $ip = $_SERVER["REMOTE_ADDR"];
        //记录当IP 1分钟访问了多少接口 缓存里 键名 xx_pass_ip
        $cache_name='pass_name_'.$ip;
        //上次访问了多少次
        $num=Cache::get($cache_name);
        if(!$num){
            $num=0;
        }
        if($num>200){
            // ip记录到文件 服务器端配置屏蔽ip
            echo json_encode([
               'ret'=>201,
               'msg'=>'超过'
            ]);die;
        }
        $num+=1;
        // echo $num;
        Cache::put($cache_name,$num,60);
        return $next($request);
    }
}
