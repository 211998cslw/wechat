<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
class WxLyController extends Controller
{
    public function w_login()
    {
        $redirect_uri=env('APP_URL').'code';//接收code 微信客户端帮助用户自动跳转
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env(WECHAT_APPID).'&redirect_uri'='.urlEncode($redirect_uri).'&response_type=code&scope=snsapi_userinfo &state=STATE#wechat_redirect ";
        // dd($url);
        header('location'.$url);

    }
    public function code(request $request)
    {
        $req=request()->all();
        // dd($req);
        $code=$req['code'];
        // dd($code);
        // 获取access_token
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code={$code}&grant_type=authorization_code";
        // dd($url);
        $re=file_get_contents($url);
        // dd($re);
        $result=json_decode($re,true);
        // dd($result);
        $access_token=$result['access_token'];
        // dd($access_token);
        $openid=$result['openid'];
        // dd($openid);
        /* $wechat_user_info = $this->wechat->wechat_user_info($openid);
        dd($wechat_user_info);*/
    }


}
