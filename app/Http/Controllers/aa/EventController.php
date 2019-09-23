<?php

namespace App\Http\Controllers\aa;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    //接收微信发送的消息【用户互动】
    public function event()
    {
       // dd($_POST);//array:1 ["name" => "123"] -----Body    form-data
        $xml_string=file_get_contents('php://input');//php://input是个可以访问请求的原始数据的只读流
//       dd($xml_string);//11222ewddf----Body   raw
        $wechat_log_psth=storage_path('logs/wechat/'.date('Y-m-d').'.log');
        file_put_contents($wechat_log_psth,"<<<<<<<<<<<<<<<\n",FILE_APPEND);
        file_put_contents($wechat_log_psth,$xml_string,FILE_APPEND);
        file_put_contents($wechat_log_psth,"\n<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n\n",FILE_APPEND);
        $xml_obj=simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);//将xml转换成对象
        $xml_arr=(array)$xml_obj;
        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));
        //业务逻辑
        if($xml_arr['MsgType'] == 'event'){
            if($xml_arr['Event'] == 'subscribe'){
                $share_code = explode('_',$xml_arr['EventKey'])[1];
                $user_openid = $xml_arr['FromUserName']; //粉丝openid
                //判断openid是否已经在日志表
                $wechat_openid = DB::connection('wechat1')->table('wechat_openid')->where(['openid'=>$user_openid])->first();
                if(empty($wechat_openid)){
                    DB::connection('wechat1')->table('user')->where(['id'=>$share_code])->increment('share_num',1);
                    DB::connection('wechat1')->table('wechat_openid')->insert([
                        'openid'=>$user_openid,
                        'add_time'=>time()
                    ]);
                }
            }
        }
        $message = '哈喽 欢迎关注！';
        $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
        echo $xml_str;
    }
}
