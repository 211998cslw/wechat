<?php

namespace App\Http\Controllers\aa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Test;
use DB;
use App\Tools\Tools;
class LoginController extends Controller
{

    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    public function q_login()
    {
        Test::index();
    }
    /**
     * 8月份B卷6题
     */
    public function push()
    {
        $user_url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=';
        $openid_info = file_get_contents($user_url);
        $user_result = json_decode($openid_info,1);
        foreach($user_result['data']['openid'] as $v){
            $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
            $data = [
                'touser'=>$v,
                'template_id'=>'nerZF2Gc3MINo98KddsgD0A0sgjD55gAyHrWjk5LLdY',
                'data'=>[
                ]
            ];
            $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        }
    }


    public function do_login()
    {
        return view('aa.login.do_login');
    }
    public function login()
    {
        $redirect_uri="http://www.wechat.com/code";
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".urlEncode($redirect_uri)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";//用户同意授权，获取code
//        dd($url);
        header('location:'.$url);
    }

    public function code(request $request)
    {
        $req = $request->all();
        $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('WECHAT_APPSECRET').'&code='.$req['code'].'&grant_type=authorization_code');//通过code换取网页授权access_token
        $re = json_decode($result,1);
        $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$re['access_token'].'&openid='.$re['openid'].'&lang=zh_CN');//拉取用户信息
        $wechat_user_info = json_decode($user_info,1);
//       dd($wechat_user_info);
        $openid=$re['openid'];
//        dd($openid);
        $wechat_info=DB::table('user_wechat')->where(['openid'=>$openid])->first();
        //dd($wechat_info);//id  uid  openid
        if(!empty($wechat_info)){
            //存在直接登录
            $request->session()->put('uid',$wechat_info->uid);
            return redirect('get_user_list');
        }else{
            //不存在先注册再登录
            DB::connection('wechat1')->beginTransaction();//打开事物  多表的时候用
            $uid=DB::connection('wechat1')->table('user')->insertGetId([
                'name'=>$wechat_user_info['nickname'],
                'password'=>'',
                'reg_time'=>time()
            ]);
            $res=DB::connection('wechat1')->table('user_wechat')->insert([
                'openid'=>$openid,
                'uid'=>$uid
            ]);
            //登录操作
            $request->session()->put('uid',$wechat_info['uid']);
            return redirect('get_user_list');
        }
    }

    public function send(){
        $openid="o40CXv-PhZugcJC7RyF0r6NDZ84o";
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
//        dd($url);
        $data=[
            'touser'=>$openid,
            'template_id'=>'nerZF2Gc3MINo98KddsgD0A0sgjD55gAyHrWjk5LLdY',
            'url'=>'http://www.wechat.com',
            'data'=>[
                'keyword1'=>[
                    'value'=>'第一节课',
                    'color'=>''
                ],
                'keyword2'=>[
                    'value'=>'第二节课',
                    'color'=>''
                ],
                'keyword3'=>[
                    'value'=>'第三节课',
                    'color'=>''
                ],
                'keyword4'=>[
                    'value'=>'第四节课',
                    'color'=>''
                ]
            ]
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
//        dd($re);
        $result=json_decode($re,1);
        dd($result);
    }


}
