<?php
namespace App\Model;
/**
 * 微信核心类
 */
use Illuminate\Support\Facades\Cache;
use App\model\Curl;

class Wechat 
{	
	const appid = "xxxxx";
	const secret = "xxxx";
	/**
	 * 接入校验
	 * @return [type] [description]
	 */
	public static function valid()
	{	
		//接入 
    	$echostr = request("echostr");
    	//有echostr  并且 接入来源确定是微信
    	if(!empty($echostr) && Self::checkSignature()  ){
    		echo $echostr;die;
    	}
	}
	/**
	 * 接入来源校验
	 * @return [type] [description]
	 */
	public static function checkSignature()
	{
	    // 1）将token、timestamp、nonce三个参数进行字典序排序 
	    // 2）将三个参数字符串拼接成一个字符串进行sha1加密 
	    // 3）开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
	    $signature = $_GET["signature"];
	    $timestamp = $_GET["timestamp"];
	    $nonce = $_GET["nonce"];
	    //1）将token、timestamp、nonce三个参数进行字典序排序
		$tmpArr = array("aaa",$timestamp,$nonce);
		sort($tmpArr, SORT_STRING);
		//2）将三个参数字符串拼接成一个字符串进行sha1加密 
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		//3)开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
		if( $signature == $tmpStr ){
			return true;
		}else{
			return false;
		}
	}


	/**
	 * 获取token接口
	 * @return [type] [description]
	 */
	public static function getToken()
	{	
		//判断缓存里是否有数据   
		$access_token = Cache::get('access_token');
		//缓存里数据 正常返回
		//缓存里没有数据 调用接口
		if(empty($access_token)){ //过期时间
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::appid."&secret=".self::secret;
			//参数 
			//请求方式
			$data = file_get_contents($url);
			$data = json_decode($data,true);
			$access_token = $data['access_token'];
			//存储到文件里
			Cache::put('access_token',$access_token,7200);	
		}
		return $access_token;
	}

	/**
	 * 获取jssdk JsApiTicket
	 * @return [type] [description]
	 */
	public static function getJsApiTicket()
	{
		$ticket = Cache::get('ticket');

		if(empty($jsApiTicket)){
			$access_token = Self::getToken();
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$access_token}&type=jsapi";
			//参数 
			//请求方式
			$data = file_get_contents($url);
			$data = json_decode($data,true);
			$ticket = $data['ticket'];
			//存储到文件里
			Cache::put('ticket',$ticket,7200);	
		}

		return $ticket;
	}

	/**
	 * 通过openid获取用户信息
	 * @return [type] [description]
	 */
	public static function getUserInfo($openid)
	{
		//获取token
		$access_token = Self::getToken();
		//$openid = $xmlObj->FromUserName; //用户的openid
		//调用微信获取用户信息接口 
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
		$userData = file_get_contents($url);
		$userData = json_decode($userData,true);
		return $userData;
	}

 	/**
	 * 回复文本内容
	 * @return [type] [description]
	 */
	public static function responseText($xmlObj,$msg)
	{
		echo "<xml>
		  <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
		  <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
		  <CreateTime>".time()."</CreateTime>
		  <MsgType><![CDATA[text]]></MsgType>
		  <Content><![CDATA[".$msg."]]></Content>
		</xml>";die;
	}

	/**
	 * 回复图片
	 * @return [type] [description]
	 */
	public static function responseImage($xmlObj,$media_id)
	{
		echo "<xml>
          <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
          <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
          <CreateTime>".time()."</CreateTime>
          <MsgType><![CDATA[image]]></MsgType>
          <Image>
            <MediaId><![CDATA[".$media_id."]]></MediaId>
          </Image>
        </xml>";die;
	}


	public static function getWether($content)
	{
		$n = mb_strpos($content,"天气");
		$city = '北京';
		if($n>0){
			$city = mb_substr($content,0,$n);
		}
		$url = "http://api.k780.com/?app=weather.future&weaid={$city}&&appkey=10003&sign=b59bc3ef6191eb9f747dd4e83c99f2a4&format=json";
		//发请求 
		$data = file_get_contents($url);
		//转成数组
		$data = json_decode($data,true);
		//var_dump($data);die;
		if($data['success'] == 1){
			//接口调用成功
			$msg = "";
			foreach ($data['result'] as $key => $value) {
				$msg .= $value['citynm']."-".$value['days']."-".$value['week']."-".$value['temperature']."\r\n";
			}
		}else{
			//报错
			$msg = "暂时获取不到天气数据";
		}
		return $msg;
	}


	/**
	 * 上传素材接口
	 * @return [字符串] [微信素材id]
	 */
	public static function uploadMedia($path,$mediaType)
	{
		//素材路径 必须是绝对路径 
		$mediaPath = public_path()."/".$path;
		//接口地址
		$access_token = Self::getToken();
		
		$url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$mediaType}";
		//echo $url;die;
		//请求参数
		//curl 发送数据 如果是文件类型  必须通过CURLFile类处理  5.6以下 "@".$img
		$postData['media'] = new \CURLFile($mediaPath);
		//发送请求 
		$res = Curl::curlPost($url,$postData);
		//var_dump($res);die;
		if(!$res){
			return false;
		}
		$res = json_decode($res,true);
		if(!isset($res['media_id'])){
			return false;
		}
		return $res['media_id'];
	}


	/**
	 * 创建临时二维码接口
	 * @return [type] [description]
	 */
	public static function createQrcode($status)
	{
		$access_token = Self::getToken();
		//创建参数二维码接口
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$access_token}";
		//请求数据
		$postData = [
			'expire_seconds'=>604800,
			'action_name'=>'QR_SCENE',
			'action_info'=>[
				'scene'=>[
					'scene_id'=>$status
				],
			],
		];
		$postData = json_encode($postData);
		//$postData = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 111}}}';
		//发请求
		//调接口 拿到票据ticket
		$data = Curl::curlPost($url,$postData);
		$data = json_decode($data,true);
		if(isset($data['ticket'])){ //获取成功
			//通过ticket换取二维码
			$url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$data['ticket'];
			//echo $url;die;
			//保存图片到本地  // copy($url,"qrcode/1.jpg"); OR 读写文件
			$img = file_get_contents($url);
			$filename = "qrcode/".md5(time().rand(1000,9999)).".jpg";
			file_put_contents($filename,$img);
			//返回下载成功的二维码路径
			return $filename;
		}
		return false;
		
	}


	/**
     * 根据标签名 创建微信标签
     * @return [type] [description]
     */
    public static function createTag($tag_name)
    {   
        $access_token = Self::getToken();

        $url = "https://api.weixin.qq.com/cgi-bin/tags/create?access_token={$access_token}";
        $post_data = [];
        $post_data['tag']['name'] = $tag_name;
        //转成json
        $post_data = json_encode($post_data,JSON_UNESCAPED_UNICODE);
        
        $res = Curl::curlPost($url,$post_data);
        //var_dump($res);die;
        $res = json_decode($res,true);
        if(isset($res['tag']['id'])){
            return $res['tag']['id'];
        }else{
            return false;
        }
    }


    /**
     * 网页授权获取用户openid
     * @return [type] [description]
     */
    public static function getOpenid()
    {
        //先去session里取openid 
        $openid = session('openid');
        //var_dump($openid);die;
        if(!empty($openid)){
            return $openid;
        }
        //微信授权成功后 跳转咱们配置的地址 （回调地址）带一个code参数
        $code = request()->input('code');
        if(empty($code)){
            //没有授权 跳转到微信服务器进行授权
            $host = $_SERVER['HTTP_HOST'];  //域名
            $uri = $_SERVER['REQUEST_URI']; //路由参数
            $redirect_uri = urlencode("http://".$host.$uri);  // ?code=xx
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".self::appid."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
            header("location:".$url);die;
        }else{
            //通过code换取网页授权access_token
            $url =  "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".self::appid."&secret=".self::secret."&code={$code}&grant_type=authorization_code";
            $data = file_get_contents($url);
            $data = json_decode($data,true);
            $openid = $data['openid'];
            //获取到openid之后  存储到session当中
            session(['openid'=>$openid]);
            return $openid;
            //如果是非静默授权 再通过openid  access_token获取用户信息
        }   
    }

    /**
     * 网页授权获取用户基本信息
     * @return [type] [description]
     */
    public static function getOpenidByUserInfo()
    {
        //先去session里取openid 
        $userInfo = session('userInfo');
        //var_dump($openid);die;
        if(!empty($userInfo)){
            return $userInfo;
        }
        //微信授权成功后 跳转咱们配置的地址 （回调地址）带一个code参数
        $code = request()->input('code');
        if(empty($code)){
            //没有授权 跳转到微信服务器进行授权
            $host = $_SERVER['HTTP_HOST'];  //域名
            $uri = $_SERVER['REQUEST_URI']; //路由参数
            $redirect_uri = urlencode("http://".$host.$uri);  // ?code=xx
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".self::appid."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
            header("location:".$url);die;
        }else{
            //通过code换取网页授权access_token
            $url =  "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".self::appid."&secret=".self::secret."&code={$code}&grant_type=authorization_code";
            $data = file_get_contents($url);
            $data = json_decode($data,true);
            $openid = $data['openid'];
            $access_token = $data['access_token'];
            //获取到openid之后  存储到session当中
            //session(['openid'=>$openid]);
            //return $openid;
            //如果是非静默授权 再通过openid  access_token获取用户信息
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
            $userInfo = file_get_contents($url);
            $userInfo = json_decode($userInfo,true);
            //返回用户信息
            session(['userInfo'=>$userInfo]);
            return $userInfo;
        }   
    }




    public static function sendTplMsg($postData)
    {
    	//调用微信模板消息接口 
		$access_token = Self::getToken();
		//echo $access_token;die;
		$url =  "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$access_token}";
		//转成json
		$postData = json_encode($postData,JSON_UNESCAPED_UNICODE);
		//发送请求
        $res = Curl::curlPost($url,$postData);
        return true;
    } 

    /**
     * 生成js sdk签名包
     * @return [type] [description]
     */
    public static function getJssdkSignPackage()
	{
		//jsapi_ticket
		$jsapiTicket = Self::getJsApiTicket();
		//echo $jsapiTicket;die;
		// 注意 URL 一定要动态获取，不能 hardcode.
	    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	    $timestamp = time();
	    $nonceStr = Self::createNonceStr(); //随即字符串
		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
	    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url"; 
	    //echo $string;die;
	    $signature = sha1($string);
	    $renderData = [
	    	'appId'=>Self::appid,
	    	'timestamp'=>$timestamp,
	    	'nonceStr'=>$nonceStr,
	    	'signature'=>$signature
	    ];

	    return $renderData;
	}


	private static function createNonceStr($length = 16) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $str = "";
	    for ($i = 0; $i < $length; $i++) {
	      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	    }
	    return $str;
	}
}
