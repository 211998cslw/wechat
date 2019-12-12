<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Login;
class UserController extends Controller
{
	//用户登录接口
    public function login(request $request)
    {
    	//用户名和密码
    	$name=$request->input('name');
    	$password=$request->input('password');
    	//查询数据库
    	$userData =Login::where(['name'=>$name,'password'=>$password])->first();
    	if(!$userData){
			echo '用户名密码错误';die;
    	}
        // 生成token令牌
        $token=md5('id'.time());//生成一个不重复的token令牌
        // dd($token);
        //修改数据库
	    $userData->token=$token;
	    $userData->expire_time=time()+7200;
	    $userData->save();
        //返回给客户端
        return json_encode(['ret'=>1,'msg'=>'登录成功','token'=>$token]);
    }
    // 查询用户信息
    public function getUser(request $request)
    {
    	//校验token令牌 校验用户身份
    	$token=$request->input('token');
    	//验证token为空 请登录
    	if(empty($token)){
    		//报错
    		return json_encode(['ret'=>201,'msg'=>'请先登录']);
    	}
    	//校验token是否正确 跟数据库的token作比较
    	$userData=Login::where(['token'=>$token])->first();
    	if(empty($userData)){
    		return json_encode(['ret'=>201,'msg'=>'请先登录']);
    	}
    	//校验token有效期
    	if(time()>$userData['expire_time']){
    		return json_encode(['ret'=>201,'msg'=>'请先登录']);
    	}
    	//延长token的有效期
    	$userData->expire_time=time()+7200;
    	$userData->save();
    	$data = ['xxx'=>'xxxx'];
        return json_encode(['ret'=>1,'msg'=>'查询成功','token'=>$data]);
    }
}

