<?php

namespace App\Http\Controllers\aa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Tools;
use DB;
class QiaodaoController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools=$tools;
    }

    //签到自定义菜单列表
    public function qd_list()
    {

        $info = DB::connection('wechat1')->table('menu')->orderBy('name1','asc','name2','asc')->get();
        return view('aa.qiandao.qd_list',['info'=>$info]);
    }
//    创建自定义菜单
    public function qd_add(request $request)
    {
        $req=$request->all();
//        dd($req);
        $button_type=!empty($req['name2'])?2:1;
        $data=DB::connection('wechat1')->table('menu')->insert([
            'name1'=>$req['name1'],
            'name2'=>$req['name2'],
            'type'=>$req['type'],
            'button_type'=>$button_type,
            'event_value'=>$req['event_value']
        ]);
//        dd($data);
        $this->load_menu();
    }
    //    根据数据库表数据刷新菜单
    public function load_menu()
    {
        $data = [];
        $menu_list = DB::connection('wechat1')->table('menu')->select(['name1'])->groupBy('name1')->get();
        foreach($menu_list as $vv){
            $menu_info = DB::connection('wechat1')->table('menu')->where(['name1'=>$vv->name1])->get();
            $menu = [];
            foreach ($menu_info as $v){
                $menu[] = (array)$v;
            }
            $arr = [];
            foreach($menu as $v){
                if($v['button_type'] == 1){ //普通一级菜单
                    if($v['type'] == 1){ //click
                        $arr = [
                            'type'=>'click',
                            'name'=>$v['name1'],
                            'key'=>$v['event_value']
                        ];
                    }elseif($v['type'] == 2){//view
                        $arr = [
                            'type'=>'view',
                            'name'=>$v['name1'],
                            'url'=>$v['event_value']
                        ];
                    }
                }elseif($v['button_type'] == 2){ //带有二级菜单的一级菜单
                    $arr['name'] = $v['name1'];
                    if($v['type'] == 1){ //click
                        $button_arr = [
                            'type'=>'click',
                            'name'=>$v['name2'],
                            'key'=>$v['event_value']
                        ];
                    }elseif($v['type'] == 2){//view
                        $button_arr = [
                            'type'=>'view',
                            'name'=>$v['name2'],
                            'url'=>$v['event_value']
                        ];
                    }
                    $arr['sub_button'][] = $button_arr;
                }
            }
            $data['button'][] = $arr;
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->tools->get_wechat_access_token();
//        dd($url);
        /*$data = [
            'button'=> [
                [
                    'type'=>'click',
                    'name'=>'今日歌曲',
                    'key'=>'V1001_TODAY_MUSIC'
                ],
                [
                    'name'=>'菜单',
                    'sub_button'=>[
                        [
                            'type'=>'view',
                            'name'=>'搜索',
                            'url'=>'http://www.soso.com/'
                        ],
                        [
                            'type'=>'miniprogram',
                            'name'=>'wxa',
                            'url'=>'http://mp.weixin.qq.com',
                            'appid'=>'wx286b93c14bbf93aa',
                            'pagepat'=>'pages/lunar/index'
                        ],
                        [
                            'type'=>'click',
                            'name'=>'赞一下我们',
                            'key'=>'V1001_GOOD'
                        ]
                    ]
                ]
            ]
        ];*/
        $re = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result = json_decode($re,1);
        dd($result);
    }
    //模板消息推送//发送模板消息
    public function qd_push_template_message()
    {
        $openid="o40CXv-PhZugcJC7RyF0r6NDZ84o";
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
//        dd($url);
        $data=[
            'touser'=>$openid,
            'template_id'=>'G8xDiy67-AJpindIlTAMdgnBqUZ7hk-W-6Igho1R73A',
            'url'=>'http://http://csw.17563758514.top',
            'data'=>[
                'keyword1'=>[
                    'value'=>'该签到了',
                    'color'=>''
                ],
            ]
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        dd($re);
        $result=json_decode($re,1);
        dd($result);
    }
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