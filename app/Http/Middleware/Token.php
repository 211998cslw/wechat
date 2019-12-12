<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Login;
class Token
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
        // echo 1;die;
        //校验token
        $token = $request->input('token');
        $userData = $this->checkToken($token);
        //把用户信息传到控制器
        $mid_params = ['userData'=>$userData];
        $request->attributes->add($mid_params);//添加参数


        return $next($request);
    }


    public function checkToken($token)
    {
         //校验token令牌 校验用户身份
         //判断不为空
         if(empty($token)){
             //报错
             echo json_encode(['ret'=>'201','msg'=>"请先登录"]);die;
         }
         //校验token是否正确
         $userData = Login::where(['token'=>$token])->first();
         if(empty($userData)){
             //报错
             echo json_encode(['ret'=>'201','msg'=>"请先登录"]);die;
         }
         //校验token有效期
         if(time() > $userData['expire_time']){
             //报错
             echo json_encode(['ret'=>'201','msg'=>"请先登录"]);die;
         }
         //延长token的有效期
         $userData->expire_time = time()+7200;
         $userData->save();


         return $userData;
    }
}
