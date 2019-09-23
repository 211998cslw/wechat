<?php

namespace App\Http\Controllers;
use App\Http\Tools\Wechat;
use DB;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    public $request;
    public $wechat;
    public function __construct(Request $request,Wechat $wechat)
    {
        $this->request = $request;
        $this->wechat = $wechat;

    }

    public function wechat_user_info($openid)
    {
        $access_token = $this->wechat->get_access_token();
        $wechat_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
        $user_info = json_decode($wechat_user,1);
        return $user_info;
    }
    public function login()
    {
        $redirect_uri = 'http://www.wechat.com/code';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect ';
//        dd($url);
        header('Location:'.$url);
    }
    /**
     * 通过code获得access_token
     * @param Request $request
     */
    //微信授权注册登陆
    public function code(Request $request)
    {
        // $code = $request->code;
         echo '1222';die;
        // dd();
        $data = $request->all();
         dd($data);
        $code = $data['code'];
//        dd($code);
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx6d64b94e58a1816f&secret=73bc62f7a787c6c3b1da9040aef318fd&code=".$code."&grant_type=authorization_code";
//        dd($url);
        $res = file_get_contents($url);
//         dd($res);
        $result = json_decode($res,1);
//         dd($result);
        $access_token = $result['access_token'];
        $openid = $result['openid'];
        // dd($openid);
        $wechat_user_info = $this->wechat_user_info($openid);
//         dd($wechat_user_info);
        //查看user_openid表 看是否有数据 openid = $openid
        $user_openid = DB::table("user_openid")->where(['openid'=>$openid])->first();
        // dd($user_openid);
        if(!empty($user_openid)){
            //有数据 在网站有用户 user表有数据[登陆]
            $user_info = DB::table("user")->where(['id'=>$user_openid->uid])->first();
//             dd($user_info);
            $request->session()->put(['username'=>$user_info->name]);
//             dd($data);
            return redirect("http://www.wechat.com/wechat/user_list");
//             header('Refresh:3;url=www.wechat.com/wechat/user_list');
        }else{
            //没有数据 注册信息
            // DB::connection("mysql_cart")->beginTransaction();
            $user_result =DB::table('user')->insertGetId([
                'password' => '',
                'name' => $wechat_user_info['nickname'],
                'reg_time' => time()
            ]);
//            dd($user_result);
            $openid_result = DB::table('user_openid')->insert([
                'uid'=>$user_result,
                'openid' =>$openid,
            ]);
            dd($openid_result);
            // dd($openid_result);
            // DB::commit();
            //登陆操作
            $user_info = DB::table("user_openid")->where(['id'=>$user_openid->uid])->first();
            $request->session()->put('username',$user_info['name']);
            return redirect("http://www.wechat.com/wechat/user_list");
        }
    }
}
