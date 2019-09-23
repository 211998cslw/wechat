<!-- <a href="{{url('wechat/get_user_list')}}">刷新粉丝列表</a>
<a href="{{url('wechat/get_user_list')}}">公众号标签列表</a>

	<h1>粉丝列表</h1>
	<form action="{{url('wechat/add_user_tag')}}" value="{{$tag_id}}"></form>
	<table border="1">
		<tr>
			<td>选择</td>
			<td>id</td>
			<td>openid</td>
			<td>时间</td>
			<td>是否关注</td>
			<td>昵称</td>
			<td>性别</td>
			<td>城市</td>
			<td>头像</td>
			<td>操作</td>
		</tr> 
		@foreach($res as $v)
		<tr>
			<td>
				<input type="checkbox" name="id_list[]" value="{{$v->id}}">
			</td>
			<td>{{$v->id}}</td>
			<td>{{$v->openid}}</td>
			<td>{{date('Y-m-d',$v->add_time)}}</td>
			<td>{{$v->subscribe}}</td>
			<td>{{$v->nickname}}</td>
			<td>{{$v->sex}}</td>
			<td>{{$v->city}}</td>
			<td><img src="{{$v->headimgurl}}"></td>
			<td>
			     <a href="{{url('wechat/get_user_info')}}?id={{$v->id}}">详情</a> | -->
                <!-- <a href="{{url('wechat/get_user_tag')}}?openid={{$v->openid}}">获取标签</a>
			</td>
		</tr> -->
		<!-- @endforeach
	</table>
	 -->










<?php
/*namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Tools\Wechat;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
class WechatController extends Controller
{*/
    // public $request;
    // public $wechat;
    // public function __construct(Request $request,Wechat $wechat)
    // {
    //     $this->request = $request;
    //     $this->wechat = $wechat;
    // }
	// 获取用户信息
  /*  public function wechat_add($access_token,$dares)
    {
    	// $access_token=$this->get_access_token();
    	// $openid='o40CXv8ycnbfQvpkRV1CkDcwHe_I';
    	$wechat_user=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$dares."&lang=zh_CN");
    	$user_info=json_decode($wechat_user,1);
    	// dd($user_info);
        return $user_info;
    }*/
    // 获取用户列表
  /*  public function wechat_index()
    {
    	$access_token=$this->get_access_token();
    	// dd($access_token);
    	//拉取关注用户列表（粉丝）
    	$wechat_user=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}&next_openid=");
    	// dd($wechat_user);
    	$user_info=json_decode($wechat_user,1);
    	// dd($user_info);
        $dares=$user_info['next_openid'];
        // dd($dares);
        $data=$this->wechat_add($access_token,$dares);
        // dd($data);
        $data=DB::table('wechat_openid')->insert([
            "openid"=>$data['openid'],
            "nickname"=>$data['nickname'],
            "sex"=>$data['sex'],
            "headimgurl"=>$data['headimgurl'],
            "subscribe"=>$data['subscribe'],
            "city"=>$data['city'],
            'add_time'=>time()
        ]);
        // dd($data);
    }*/
    // 获取粉丝列表
  /*  public function wechat_to_index(request $request)
    {
        $res=DB::table('wechat_openid')->get();
        // dd($res);
        return view('fensi.wechat_to_index',['res'=>$res]);
    }*/
    // 获取assess_token
  /*  public function get_access_token()
    {
    	// 获取access_token
    	$redis=new \Redis();
    	$redis->connect('127.0.0.1','6379');
    	$access_token_key='wechat_assess_token';
    	if($redis->exists($access_token_key)){
    	// 去缓存拿
    		$access_token=$redis->get($access_token_key);
    	}else{
    		//去微信接口拿
    		$access_re=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx6d64b94e58a1816f&secret=73bc62f7a787c6c3b1da9040aef318fd");
	    	// dd($access_re);
	    	$access_result=json_decode($access_re,1);
	    	$access_token=$access_result['access_token'];
	    	$expire_time=$access_result['expires_in'];
	    	// 加入缓存
    		$redis->set($access_token_key,$access_token,$expire_time);

    	}
    	
    	return $access_token;
    }*/



   /* public function login()
    {
       $redirect_uri="http://www.wechat.com/code";

       $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".urlEncode($redirect_uri)."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
       // dd($url);
       header('Location:'.$url);

    }*/

  /*  public function code(request $request)
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
    // }

    // 模板列表
   /* public function template_list()
    {
        $url='https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token='.$this->get_access_token();
        $re=file_get_contents($url);
        dd(json_decode($re,1));
    }*/

    // 删除模板
   /* public function del_template()
    {
        $url="https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token=".$this->get_access_token();
        $data=[
            'template_id'=>'7rBYc-BSDT3VncKcCalJOuOJyq0HQRa05YOgj6a-S_Q'
        ];
       $re=$this->wechat->post($url,json_encode($data));
       dd($re);
    }*/


    /**
     * 推送模板消息
     */
   /* public function push_template()
    {
        $openid_info = DB::table("wechat_openid")->select('openid')->limit(10)->get()->toArray();
        // dd($openid_info);
        foreach($openid_info as $v){
            $this->wechat->push_template($v->openid);
        }
    }*/
    /**
     * 我的素材
     */
     /*public function upload_source()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$this->get_access_token();
        // dd($url);
        $data = ['type'=>'image','offset'=>0,'count'=>20];
        // dd($data);
        $re = $this->wechat->post($url,json_encode($data));
        // dd($re);
        echo '<pre>';
        print_r(json_decode($re,1));
        return view('Wechat.uploadSource');
    }*/
  /*  public function get_voice_source()
    {
        $media_id = 'UKml31rzRRlr8lYfWgAno9mGe-meph0BKmVtZugAHQTqZIxOhUoBvCnqfJMRMKTG';
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->get_access_token().'&media_id='.$media_id;
        //echo $url;echo '</br>';
        //保存图片
        $client = new Client();
        $response = $client->get($url);
        //$h = $response->getHeaders();
        //echo '<pre>';print_r($h);echo '</pre>';die;
        //获取文件名
        $file_info = $response->getHeader('Content-disposition');
        $file_name = substr(rtrim($file_info[0],'"'),-20);
        //$wx_image_path = 'wx/images/'.$file_name;
        //保存图片
        $path = 'wechat/voice/'.$file_name;
        $re = Storage::put($path, $response->getBody());
        echo env('APP_URL').'/storage/'.$path;
        dd($re);
    }*/
   /* public function get_video_source(){
        $media_id = 'f9-GxYnNAinpu3qY4oFadJaodRVvB6JybJOhdjdbh7Z0CR0bm8nO4uh8bqSaiS_d'; //视频
        $url = 'http://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->get_access_token().'&media_id='.$media_id;
        $client = new Client();
        $response = $client->get($url);
        $video_url = json_decode($response->getBody(),1)['video_url'];
        $file_name = explode('/',parse_url($video_url)['path'])[2];
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
        $read = file_get_contents($video_url,false, $context);
        $re = file_put_contents('./storage/wechat/video/'.$file_name,$read);
        var_dump($re);
        die();
    }*/
   /* public function get_source()
    {
        $media_id = 'pREe_hxV86zjyFsmSlMNnewpYTFf5x6NuckIDkOTLgcF58FhejU-DNDucyme6x_n'; //图片
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->get_access_token().'&media_id='.$media_id;
        //echo $url;echo '</br>';
        //保存图片
        $client = new Client();
        $response = $client->get($url);
        //$h = $response->getHeaders();
        //echo '<pre>';print_r($h);echo '</pre>';die;
        //获取文件名
        $file_info = $response->getHeader('Content-disposition');
        $file_name = substr(rtrim($file_info[0],'"'),-20);
        //$wx_image_path = 'wx/images/'.$file_name;
        //保存图片
        $path = 'wechat/image/'.$file_name;
        $re = Storage::disk('local')->put($path, $response->getBody());
        echo env('APP_URL').'/storage/'.$path;
        dd($re);
        //return $file_name;
    }*/
  /*  *
     * 上传资源
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    /*public function do_upload(Request $request)
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
        }elseif($request->hasFile('video')){
            //视频
            //保存文件
            $re = $this->wechat->upload_source($upload_type,'video','视频标题','视频描述');
        }elseif($request->hasFile('thumb')){
            //缩略图
            $path = $request->file('thumb')->store('wechat/thumb');
        }
        echo $re;
        dd();
    }
*/

    // 添加用户标签
  /*  public function add_tag()
    {
    	return view('Wechat.add_tag');
    }*/
    /**
     * 添加标签
     */
   /* public function do_add_tag(request $request)
    {
    	$url="https://api.weixin.qq.com/cgi-bin/tags/create?access_token=".$this->get_access_token();
    	// dd($url);
    	// $name=$_POST['name'];
    	// echo $name;die;
    	$data = [
            'tag' => ['name'=>$request->all()['name']]
        ];
    	// dd($data);
    	$re=$this->wechat->post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
    	dd(json_decode($re,1));

    }
*/
    /*标签列表*/
  /*  public function tag_list(){
        $tag_info = $this->wechat->wechat_tag_list();
        return view('Wechat/tag_list',['info'=>$tag_info['tags']]);
    }*/
    /*标签下的粉丝列表*/
  /*  public function tag_user(Request $request)
    {
        $re = $this->wechat->tag_user($request->all()['id']);
        dd($re);
    }*/

    /**
     * 批量给用户打标签
     */
   /* public function add_user_tag(Request $request)
    {
        $openid_info = DB::table('wechat_openid')->whereIn('id',$request->all()['id_list'])->select(['openid'])->get()->toArray();
        // dd($openid_info);
        $openid_list = [];
        foreach($openid_info as $v){
            $openid_list[] = $v->openid;
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$this->get_access_token();
        $data = [
            'openid_list'=>$openid_list,
            'tagid'=>$request->all()['tagid'],
        ];
        $re = $this->wechat->post($url,json_encode($data));
        dd(json_decode($re,1));
    }
*/







	/*微信*/
/*Route::get('wechat_add','WechatController@wechat_add');// 获取用户信息
Route::get('wechat_index','WechatController@wechat_index'); // 获取用户列表
Route::get('wechat_to_index','WechatController@wechat_to_index');;//粉丝列表
Route::get('code','WechatController@code');
*/







// }