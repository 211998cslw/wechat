<?php

namespace App\Http\Controllers\aa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Tools\Tools;
class ZhoukaoController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {

        $this->tools = $tools;
    }

// 网页授权登录
    public function zk_login()
    {
        return view('aa.zhoukao.zk_login');
    }
    public function zk_do_login()
    {
        $redirect_uri="http://www.wechat.com/zk_code";
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".urlEncode($redirect_uri)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";//用户同意授权，获取code
    // dd($url);
        header('location:'.$url);
    }
    public function zk_code(request $request)
    {
        $req = $request->all();
        $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('WECHAT_APPSECRET').'&code='.$req['code'].'&grant_type=authorization_code');//通过code换取网页授权access_token
         dd($result);
        $re = json_decode($result,1);
        $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$re['access_token'].'&openid='.$re['openid'].'&lang=zh_CN');//拉取用户信息
        $wechat_user_info = json_decode($user_info,1);
        // dd($wechat_user_info);
        $openid=$re['openid'];
        //dd($openid);
        $wechat_info=DB::table('user_wechat')->where(['openid'=>$openid])->first();
        //dd($wechat_info);//id  uid  openid
        if(!empty($wechat_info)){
            //存在直接登录
            $request->session()->put('uid',$wechat_info->uid);
            return redirect('zk_user_list');
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
            return redirect('zk_user_list');
        }
    }

    public function zk_get_user_info(request $request)
    {
        $openid = DB::connection('wechat1')->table('wechat_openid')->where(['id'=>$request->all()['id']])->value('openid');
//        dd($openid);
        $user_info =$this->wechat_user_info($openid);
        dd($user_info);
    }
    public function wechat_user_info($openid)
    {
        $access_token = $this->tools->get_wechat_access_token();
        $wechat_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
        $user_info = json_decode($wechat_user,1);
        return $user_info;
    }
   //粉丝列表
    public function zk_user_list(Request $request)
    {
        $tag_id = !empty($request->all()['tag_id'])?$request->all()['tag_id']:'';
        $openid_info = DB::connection('wechat1')->table('wechat_openid')->get();
//      dd($openid_info);
        return view('aa.zhoukao.zk_user_list',['openid_info'=>$openid_info,'tag_id'=>$tag_id]);
    }
    public function zk_get_user_list()
    {
        $access_token = $this->tools->get_wechat_access_token();
        //拉取关注用户列表
        $wechat_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}&next_openid=");
//        dd($wechat_user);
        $user_info = json_decode($wechat_user,1);
//        dd($user_info);
        foreach($user_info['data']['openid'] as $v){
            $subscribe = DB::connection('wechat1')->table('wechat_openid')->where(['openid'=>$v])->value('subscribe');
//            dd($subscribe);
            if(empty($subscribe)){
                //获取用户详细信息
                $user = $this->wechat_user_info($v);
                DB::connection('wechat1')->table('wechat_openid')->insert([
                    'openid' => $v,
                    'add_time' => time(),
                    'nickname' =>$user['nickname'],
                    'subscribe' => $user['subscribe']
                ]);
            }else{
                //获取用户详细信息
                $access_token =$this->tools->get_wechat_access_token();
                $openid = $v;
                $wechat_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
                $user = json_decode($wechat_user,1);
                if($subscribe != $user['subscribe']){
                    DB::table('wechat_openid')->where(['openid'=>$v])->update([
                        'subscribe' => $user['subscribe'],
                    ]);
                }
            }
        }
        echo "<script>history.go(-1);</script>";
    }
    //标签添加
    public function zk_tag_add()
    {
     //echo 22;die();
        return view('aa.zhoukao.zk_tag_add');
    }
    public function zk_do_tag_add(request $request)
    {
        $req=$request->all();
        $url="https://api.weixin.qq.com/cgi-bin/tags/create?access_token=".$this->tools->get_wechat_access_token();
//        dd($url);
        $data=[
            'tag'=>[
                'name'=>$req['name']
            ]
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $request=json_decode($re);
//        dd($request);
        return redirect('zk_tag_list');
    }
    //标签列表
    public function zk_tag_list()
    {
        $url="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".$this->tools->get_wechat_access_token();
//        dd($url);
        $re=file_get_contents($url);
//        dd($re);
        $res=json_decode($re,1);
        return view('aa.zhoukao.zk_tag_list',['res'=>$res['tags']]);
    }
    //给用户打标签
    public function zk_add_user_tag(Request $request)
    {
        $openid_info = DB::table('wechat_openid')->whereIn('id',$request->all()['id_list'])->select(['openid'])->get()->toArray();
//         dd($openid_info);
        $openid_list = [];
        foreach($openid_info as $v){
            $openid_list[] = $v->openid;
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$this->tools->get_wechat_access_token();
        // dd($url);
        $data = [
            'openid_list'=>$openid_list,
            'tagid'=>$request->all()['tagid'],
        ];
//         dd($data);
        $re = $this->tools->curl_post($url,json_encode($data));
         dd($re);
        dd(json_decode($re,1));
    }
    /*标签下的粉丝列表*/
    public function zk_tag_user(Request $request)
    {
        $req = $request->all();
//        dd($req);
        $url = 'https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token='.$this->tools->get_wechat_access_token();
//        dd($url);
        $data = [
            'tagid' => $req['id'],
            'next_openid' => ''
        ];
        $re = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($re,1);
        dd($result);
    }
////    给标签下的粉丝推送消息
    public function zk_push_tag_message(request $request)
    {
        return view('aa.zhoukao.zk_push_tag_message',['tagid'=>$request->all()['tagid']]);
    }
    public function zk_do_push_tag_message(Request $request)
{
    $req = $request->all();
//    dd($req);
    $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$this->tools->get_wechat_access_token();
    $data = [
        'filter' => [
            'is_to_all'=>false,
            'tag_id'=>$req['tagid']
        ],
        'text'=>[
            'content'=>$req['message']
        ],
        'msgtype'=>'text'
    ];
    $re = $this->tools->curl_post($url,json_encode($data));
    $result = json_decode($re,1);
    dd($result);
}


}
