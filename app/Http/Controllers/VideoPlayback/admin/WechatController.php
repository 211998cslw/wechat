<?php

namespace App\Http\Controllers\VideoPlayback\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Tool\wechat;
use App\Tools\Tools;
use Qiniu\Auth;
class WechatController extends Controller
{
	public $wechat;
    public $tools;
    public function __construct(wechat $wechat,Tools $tools)
    {
        $this->wechat = $wechat;
        $this->tools = $tools;
    }

    /*素材*/
	public function access_token()
    {
        return $this->wechat->get_access_token();
    }

    public function upload_video()
    {
        return view('videoplayback.admin/upload_video');
    }
    public function do_upload(Request $request)
    {
        $upload_type = $request['up_type'];
        // dd($upload_type);
        $re = '';
        if($request->hasFile('image')){
            //图片类型
            $re = $this->wechat->upload_source($upload_type,'image');
            // dd($re);
        }elseif($request->hasFile('voice')){
            //音频类型
            //保存文件
            $re = $this->wechat->upload_source($upload_type,'voice');
            // dd($re);
        }elseif($request->hasFile('video')){
            //视频
            //保存文件
            $re = $this->wechat->upload_source($upload_type,'video','视频标题','视频描述');
            // dd($re);
        }elseif($request->hasFile('thumb')){
            //缩略图 和图片一样 所以没处理
            $path = $request->file('thumb')->store('wechat/thumb');
            dd($path);
        }
        echo $re;
        dd();
    }

             /*七牛云*/

     public function qiniu()
    {
        return view('videoplayback.admin.qiniuyun');
    }
    //七牛
    public function qiniu_add()
    {
        include '../qiniu/autoload.php';
        $ak="cZxqtblzVecGXGhN4h5O1JX9MGQHv81sQVEoCWO0";
        $sk="0wdtYmmnUENuBt8QZphlD7--xD_K4BUp-xM5DN12";
        $bucket="cswqiniuyun";
        $obj=new Auth($ak,$sk);
        // dd($obj);
        echo $obj->uploadToken($bucket);
    }

     public function get_access_token()
    {
        return $this->tools->get_wechat_access_token();
    }

    /*授权登录*/
    public function w_login()
    {
        return view('videoplayback.admin.login.w_login');
    }
    public function w_login_do()
    {
        $redirect_uri="http://www.wechat.com/w_code";
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".urlEncode($redirect_uri)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";//用户同意授权，获取code
       // dd($url);
        header('location:'.$url);
    }

    public function w_code(request $request)
    {
        $req = $request->all();
        // dd($req);
        $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('WECHAT_APPSECRET').'&code='.$req['code'].'&grant_type=authorization_code');//通过code换取网页授权access_token
        // dd($result);
        $re = json_decode($result,1);
        $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$re['access_token'].'&openid='.$re['openid'].'&lang=zh_CN');//拉取用户信息
        dd($user_info);
        $wechat_user_info = json_decode($user_info,1);
      // dd($wechat_user_info);
        $openid=$re['openid'];
       dd($openid);
        $wechat_info=DB::table('w_login')->where(['openid'=>$openid])->first();
        //dd($wechat_info);//id  uid  openid
        if(!empty($wechat_info)){
            //存在直接登录
            $request->session()->put('uid',$wechat_info->uid);
            return redirect('get_user_list');
        }else{
            //不存在先注册再登录
            DB::beginTransaction();//打开事物  多表的时候用
            $uid=DB::table('user')->insertGetId([
                'name'=>$wechat_user_info['nickname'],
                'password'=>'',
                'reg_time'=>time()
            ]);
            $res=DB::table('w_login')->insert([
                'openid'=>$openid,
                'uid'=>$uid
            ]);
            //登录操作
            $request->session()->put('uid',$wechat_info['uid']);
            return redirect('get_user_list');
        }
    }

}
