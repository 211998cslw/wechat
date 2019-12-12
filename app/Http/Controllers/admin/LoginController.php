<?php

namespace App\Http\Controllers\admin;
use App\model\wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Tools;
use DB;
use Illuminate\Support\Facades\Cache;
class LoginController extends Controller
{
    public $tools;
    public $wechat;
    public function __construct(Tools $tools,wechat $wechat)
    {
        $this->tools=$tools;
    }

    //后台登录
    public function h_login()
    {
        return view('login.h_login');
    }
    public function h_do_login(request $request)
    {
        $name = $request ->input('name');
//        dd($name);
        $password = $request ->input('password');
//        dd($password);
        $code = $request ->input('code');
//        dd($code);
        $value = Cache::get('code'.$name);
//         dd($value);/
        // $red = session('code');
        // dd($red);
        if(empty($code)){
            echo "<script>alert('验证码不为空');location.href='h_login';</script>";die;
        }
        if($value != $code){
            echo "<script>alert('验证码不正确');location.href='h_login';</script>";die;
        }
        //验证用户名和密码是否正确
        $bandData = DB::table('h_login')->where(['name'=>$name,'password'=>$password])->first();
        if (!$bandData) {
            //报错
            echo "<script>alert('用户名密码错误');location.href='/h_login';</script>";
        }else{
            //登陆成功
            echo "<script>alert('登陆成功');location.href='index';</script>";
        }
    }
    //发送验证码
    public function send(request $request)
    {
        $req=$request->all();
//        dd($req);
        //接收用户名 密码
        $name=$request->input('name');
//       dd($name);
        $password=$request->input('password');
        //发送验证码 4位 6位
        $code=rand(1000,9999);
//        拼接
        $rd = "code".$name;
        // 存入缓存 Cache::put('key', 'value', $seconds);
        $data = Cache::put($rd,$code,60);
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
//        dd($url);
        //参数
        $data=[
            'touser'=>'o40CXv-PhZugcJC7RyF0r6NDZ84o',
            'template_id'=>'GK9OHQHohHpZMwhAnmf9JS1xLkU5zyYysiO7HVeEztQ',
            'data'=>[
                'code'=>[
                    'value'=>$code,
                    'color'=>''
                ],
                'name'=>[
                    'value'=>$name,
                    'color'=>''
                ],
                'time'=>[
                    'value'=>time(),
                    'color'=>''
                ],

            ]
        ];
//        dd($data);
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=json_decode($re,1);
        dd($result);
    }

    public function bdzh()
    {
        return view('login.bdzh');
    }
        public function do_bdzh(request $request)
    {
        $name = request('name');
//        dd($name);
        $password = request('password');
//        dd($password);

        $adminInfo = DB::table('h_login')->where(['name'=>$name,'password'=>$password])->first();
//        dd($adminInfo);
        if(!$adminInfo){
            echo '用户名或密码错误';die;
        }
        $openid = wechat::getOpenid();
//        var_dump($openid);
        DB::table('h_login')->where(['name'=>$name,'password'=>$password])->update([
            'openid'=>$openid
        ]);
        $adminInfo->openid = $openid;
        echo "<script>alert('绑定账号成功');location.href='h_login';</script>";
    }
}
