<?php
namespace App\Http\Tool;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class wechat
{

    public $request;
    public $client;

    public function __construct(Request $request, Client $client)
    {
        $this->request = $request;
        $this->client = $client;
    }
    public function get_access_token()
    {
        $access_token_key='wechat_access_token';
        $redis=new \Redis();
        $redis->connect('127.0.0.1','6379');

        //在方法中判断key
        if($redis->exists($access_token_key))
        {
            //从缓存中拿access_token
            $access_token=$redis->get($access_token_key);
//            echo '这是从缓存中拿到的access_token';
//            dd($access_token);
        }else{
            //如果没有 调用接口拿access_token 并存入redis
            $access_token_info=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."");
            $access_token_info=json_decode($access_token_info,1);
//            dd($access_token_info);
            //数组的操作需要json_decode($data,1)变为关联数组
            $access_token=$access_token_info['access_token'];
            $expires_in=$access_token_info['expires_in'];
            $redis->set($access_token_key,$access_token,$expires_in);
        }
        //最终返回一个access_token
        return $access_token;
    }
    public function upload_source($up_type, $type, $title = '', $desc = '')
    {
        $file = $this->request->file($type);
//        dd($file);//显示上传的文件
        $file_ext = $file->getClientOriginalExtension();  //获取文件扩展名
        //重命名
        $new_file_name = time() . rand(1000, 9999) . '.' . $file_ext;
//        dd($new_file_name);
        //文件保存路径
        //保存文件
        //自己：storeaAs是为了重命名
        $save_file_path = $file->storeAs('wechat/video', $new_file_name); //返回保存成功之后的文件路径
//        dd($save_file_path);
        //根据当前项目的绝对路径 可能是
        $path = 'storage/' . $save_file_path;
//        dd($path);
        //判断临时还-是永久 1为临时 2为永久
        if ($up_type == 1) {
            $url = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $this->get_access_token() . '&type=' . $type;
//            dd($url);
        } elseif ($up_type == 2) {
            $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=' . $this->get_access_token() . '&type=' . $type;
//            dd($url);
        }
        //普通的上传
        $multipart = [
            [
                'name' => 'media',
                'contents' => fopen(realpath($path),'r')
            ],
        ];
        //视频需要另一个post表单 详见文档https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1444738729
        /**
         * 新增永久视频素材需特别注意
         *
         * 在上传视频素材时需要POST另一个表单，id为description，包含素材的描述信息，内容格式为JSON，格式如下：
         *
         * {
         * "title":VIDEO_TITLE,
         * "introduction":INTRODUCTION
         * }
         */
        if ($type == 'video' && $up_type == 2) {
            $multipart[] = [
                'name' => 'description',
                'contents' => json_encode(['title' => $title, 'introduction' => $desc])
            ];
        }
        $response = $this->client->request('POST', $url, [
            'multipart' => $multipart
        ]);
        //返回信息
        $body = $response->getBody();
        unlink($path);
        return $body;
    }
}