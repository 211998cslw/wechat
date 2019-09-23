<?php

namespace App\Http\Controllers\aa;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Tools\Tools;
class WechatController extends Controller
{
    public $tools;
    public $client;
    public function __construct(Tools $tools,Client $client)
    {
        $this->tools = $tools;
        $this->client=$client;
    }
    public function get_access_token()
    {
        return $this->get_wechat_access_token();
    }
    /**
     * 调用频次清0
     */
    public function  clear_api(){
        $url = 'https://api.weixin.qq.com/cgi-bin/clear_quota?access_token='.$this->tools->get_wechat_access_token();
        $data = ['appid'=>env('WECHAT_APPID')];
        $this->tools->curl_post($url,json_encode($data));
    }

////    //用户粉丝列表
//    public function get_user_list(request $request)
//    {
//        //echo 11;die;
//        $req=$request->all();
//        $openid_info=DB::connection('wechat1')->table('wechat_openid')->get();
////         dd($req);
////        $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token() . '&next_openid=');
//////         dd($result);
////        $re = json_decode($result, 1);
//////         dd($re);
////        $last_info = [];
////        foreach ($re['data']['openid'] as $k => $v) {
////            $user_info = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $this->tools->get_wechat_access_token(). '&openid=' . $v .'&lang=zh_CN');
////            $user = json_decode($user_info, 1);
////            $last_info[$k]['nickname'] = $user['nickname'];
////            $last_info[$k]['openid'] = $v;
////        }
////         dd($last_info);
////        dd($re['data']['openid']);
//        return view('aa.Wechat.get_user_list',['info'=>$openid_info,'tagid'=>isset($req['tagid'])?$req['tagid']:'']);
//    }
//
////    获取用户基本信息
//    public function get_user_info(request $request)
//    {
////        echo 111;die;
//        //获取access_token
//        $openid = request()->openid;
////        dd($openid);
//        $access_token = $this->tools->get_wechat_access_token();
//        $result = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=". $access_token."&openid=".$openid."&lang=zh_CN");
////        dd($result);
//        $re = json_decode($result);
////        dd($re);
//        return view('aa.Wechat.get_user_info', ['re' => $re]);
//    }

    public function get_user_info(request $request)
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
    public function user_list(Request $request)
    {
        dd(1);
        $tag_id = !empty($request->all()['tag_id'])?$request->all()['tag_id']:'';
        $openid_info = DB::connection('wechat1')->table('wechat_openid')->get();
//      dd($openid_info);
        return view('aa.Wechat.user_list',['openid_info'=>$openid_info,'tag_id'=>$tag_id]);
    }
    public function get_user_list()
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

    public function post_test()
    {
        $curl=curl_init('http://wechat.18022480300.com/api/post_test');
        curl_setopt($curl,CURLOPT_POST,true); //发送post
        $form_data=[
            'name'=>222,
            'sex'=>2
        ];
        curl_setopt($curl,CURLOPT_POSTFIELDS,$form_data);
        $data=curl_exec($curl);
        $errno=curl_errno($curl);//错误码
        $err_msg=curl_errno($curl);//错误信息
        var_dump($data);
        curl_close($curl);

    }
    //上传
    public function upload()
    {
        return view('aa.Wechat.upload',[]);
    }
    public function do_upload(Request $request,Client $client)
    {
        $type = $request->all()['type'];
//        dd($type);
        $source_type = '';
        switch ($type){
            case 1: $source_type = 'image'; break;
            case 2: $source_type = 'voice'; break;
            case 3: $source_type = 'video'; break;
            case 4: $source_type = 'thumb'; break;
            default;
        }
        $name = 'file_name';
        if(!empty($request->hasFile($name)) && request()->file($name)->isValid()){
            //大小 资源类型限制
            $ext = $request->file($name)->getClientOriginalExtension();  //文件类型
            $size = $request->file($name)->getClientSize() / 1024 / 1024;
            if($source_type == 'image'){
                if(!in_array($ext,['jpg','png','jpeg','gif'])){
                    dd('图片类型不支持');
                }
                if($size > 2){
                    dd('太大');
                }
            }elseif($source_type == 'voice'){}
            $file_name = time().rand(1000,9999).'.'.$ext;
            //dd($file_name);//"15679997746309.jpg"
            $path = request()->file($name)->storeAs('/wechat/'.$source_type,$file_name);
//            dd($path);//"wechat/image/15679998053668.jpg"
            $storage_path = '/storage/'.$path;
            //dd($storage_path);//"/storage/wechat/image/15679998482238.jpg"
            $path = realpath('./storage/'.$path);
            // dd($path);
            $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->tools->get_wechat_access_token().'&type='.$source_type;
//            dd($url);
//           $result = $this->guzzle_upload($url,$path,$client);
            if($source_type=='video'){
                /*$title='标题';//视频标题
                $desc='描述';//视频描述*/
                $result = $this->curl_upload($url,$path);
            }else{
                $result = $this->curl_upload($url,$path);
            }
            $re = json_decode($result,1);
            // dd($re);
            //插入数据库
            DB::connection('wechat1')->table('wechat_source')->insert([
                'media_id'=>$re['media_id'],
                'type' => $type,
                'path' => $storage_path,
                'add_time'=>time()
            ]);
            echo 'ok';
        }
    }
    //微信素材管理页面
    public function wechat_source(Request $request,Client $client)
    {
        $req = $request->all();
        empty($req['source_type'])?$source_type = 'image':$source_type=$req['source_type'];
        if(!in_array($source_type,['image','voice','video','thumb'])){
            dd('类型错误');
        }
       if(!empty($req['page']) && $req['page'] <= 0 ){
            dd('页码错误');
        }
        empty($req['page'])?$page = 1:$page=$req['page'];
        if($page <= 0 ){
            dd('页码错误');
        }
        $pre_page = $page - 1;
        $pre_page <= 0 && $pre_page = 1;
        $next_page = $page + 1;
        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$this->tools->get_wechat_access_token();
//        dd($url);
        $data = [
            'type' =>$source_type,
            'offset' => $page == 1 ? 0 : ($page - 1) * 20,
            'count' => 20
        ];
//        dd($data);
        //guzzle使用方法
//        $r = $client->request('POST', $url, [
//            'body' => json_encode($data)
//        ]);
//        dd($r);
//        $re = $r->getBody();
        $re=$this->tools->redis->get('source_info');
//        dd($re);
        $re = $this->tools->curl_post($url,json_encode($data));
//        dd($re);
        $info = json_decode($re,1);
//        dd($info);
        $media_id_list = [];
        $source_arr=['image'=>1,'voice'=>2,'video'=>3,'thumb'=>4];
        foreach($info['item'] as $v){
//            同步数据库
            $media_info = DB::connection('wechat1')->table('wechat_source')->where(['media_id'=>$v['media_id']])->select(['id'])->first();
            if(empty($media_info)){
                DB::connection('wechat1')->table('wechat_source')->insert([
                    'media_id'=>$v['media_id'],
                    'type' => $source_arr[$source_type],
                    'add_time'=>$v['update_time'],
                    'file_name'=>$v['name'],
                ]);
            }
            $media_id_list[] = $v['media_id'];
        }
        $source_info = DB::table('wechat_source')->whereIn('media_id',$media_id_list)->get();
        //dd($source_info);
        foreach($source_info as $k=>$v){
            $is_download = 0;  //是否需要下载文件 0 否 1 是
            if(empty($v->path)){
                $is_download = 1;
            }elseif (!empty($v->path) && !file_exists('.'.$v->path)){
                $is_download = 1;
            }
            $source_info[$k]->is_download = $is_download;
        }
        return view('aa.Wechat.source',['info'=>$source_info,'pre_page'=>$pre_page,'next_page'=>$next_page,'source_type'=>$source_type]);
    }
   /* public function guzzle_upload($url,$path,$client){
//        dd($path);
        $result = $client->request('POST',$url,[
            'multipart' => [
                [
                    'name'     => 'media',
                    'contents' => fopen($path, 'r')
                ]
            ]
        ]);
        return $result->getBody();
    }*/
    /**
     *curl上传微信素材
     * @param $url
     * @param $path
     * @return bool|string
     */
    public function curl_upload($url,$path)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,true);  //发送post
        $form_data = [
            'media' => new \CURLFile($path)
        ];
        curl_setopt($curl,CURLOPT_POSTFIELDS,$form_data);
        $data = curl_exec($curl);
        //$errno = curl_errno($curl);  //错误码
        //$err_msg = curl_error($curl); //错误信息
        curl_close($curl);
        return $data;
    }
    //下载资源
    public function download_source(Request $request)
    {
        $req = $request->all();
        $source_info = DB::connection('wechat1')->table('wechat_source')->where(['id'=>$req['id']])->first();
        $source_arr = [1=>'image',2=>'voice',3=>'video',4=>'thumb'];
        $source_type = $source_arr[$source_info->type]; //image,voice,video,thumb
        //素材列表
        //$media_id = 'dcgUiQ4LgcdYRovlZqP88RB3GUc9kszTy771IOSadSM'; //音频
        //$media_id = 'dcgUiQ4LgcdYRovlZqP88dUuf1H6G4Z84rdYXuCmj6s'; //视频
        $media_id = $source_info->media_id;
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$this->get_wechat_access_token();
        $re = $this->curl_post($url,json_encode(['media_id'=>$media_id]));
        if($source_type != 'video'){
            Storage::put('wechat/'.$source_type.'/'.$source_info->file_name, $re);
            DB::connection('wechat1')->table('wechat_source')->where(['id'=>$req['id']])->update([
                'path'=>'/storage/wechat/'.$source_type.'/'.$source_info->file_name,
            ]);
            dd('ok');
        }
        $result = json_decode($re,1);
        //设置超时参数
        $opts=array(
            "http"=>array(
                "method"=>"GET",
                "timeout"=>3  //单位秒
            ),
        );
        //创建数据流上下文
        $context = stream_context_create($opts);
        //$url请求的地址，例如：
        $read = file_get_contents($result['down_url'],false, $context);
        Storage::put('wechat/video/'.$source_info['file_name'], $read);
        DB::connection('wechat1')->table('wechat_source')->where(['id'=>$req['id']])->update([
            'path'=>'/storage/wechat/'.$source_type.'/'.$source_info->file_name,
        ]);
        dd('ok');
        //Storage::put('file.mp3', $re);
    }
    //模板消息推送//发送模板消息
    public function push_template_message()
    {
        $openid="o40CXv-PhZugcJC7RyF0r6NDZ84o";
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
//        dd($url);
        $data=[
            'touser'=>$openid,
            'template_id'=>'AOMWRqxC4k0vMqbYxvSyzQ3JqsQ8tOdPzcjTTC0yoaE',
            'url'=>'http://www.wechat.com',
            'data'=>[
                'first'=>[
                    'value'=>'商品名称',
                    'color'=>''
                ],
                'keyword1'=>[
                    'value'=>'低价',
                    'color'=>''
                ],
                'keyword2'=>[
                    'value'=>'是低价',
                    'color'=>''
                ],
                'remark' => [
                    'value' => '备注',
                    'color' => ''
                ]
            ]
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        dd($re);
        $result=json_decode($re,1);
        dd($result);
    }
    //jssdk
    public function location()
    {
        $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//        dd($url);
        $jsapi_ticket=$this->tools->get_wechat_jsapi_ticket();
        $timestamp=time();
        $nonceStr=rand(1000,9999).'ssdf';
        $sign_str = 'jsapi_ticket='.$jsapi_ticket.'&noncestr='.$nonceStr.'&timestamp='.$timestamp.'&url='.$url;
//        echo $sign_str;
        $signature = sha1($sign_str);
        return view('aa.wechat.location',['nonceStr'=>$nonceStr,'timestamp'=>$timestamp,'signature'=>$signature]);
    }
}
