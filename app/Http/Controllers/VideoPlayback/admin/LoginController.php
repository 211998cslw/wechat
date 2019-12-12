<?php

namespace App\Http\Controllers\VideoPlayback\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class LoginController extends Controller
{
    public function login()
    {
    	return view('videoplayback.admin.login');
    }

    public function do_login(request $request)
    {
        $data=$request->all();
         // dd($data);
        $code = $request->input('code');
       // dd($code);
        $codename = $request->input('codename');
         // dd($codename);
         // 判断验证码是否为空
        if(empty($code)){
            echo "<script>alert('验证码不能为空');location.href='login';</script>";die;
        }
        //判断验证码是否正确
        if($code != $codename)
        {
            echo "<script>alert('验证码不正确');location.href='login';</script>";die;
        }
        $res=DB::table('login')->where('username','=',$data['username'])->first();
        if($res){
            if($res->password == $data['password']){
                session([
                    'id'=>$res->id,
                    'username'=>$res->username,
                ]);
                echo "<script>alert('登录成功')</script>";
                echo "<script>window.location.href='index'</script>";
            }else{
                echo "<script>alert('密码不正确')</script>";
                echo "<script>window.location.href='login'</script>";
            }
        }else{
            echo "<script>alert('账号不存在')</script>";
            echo "<script>window.location.href='login'</script>";
        }  
         
    }
}