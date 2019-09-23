<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Tools\Wechat;
use DB;

class QiandaoController extends Controller
{
    public $wechat;
    public function __construct(Wechat $wechat)
    {
        $this->wechat=$wechat;
    }


    public function qd_list()
    {
        //echo "<pre>";
        $qd_info = DB::table('qiandao')->groupBy('qd_name')->select(['qd_name'])->orderBy('qd_name')->get()->toArray();
        $info = [];
        foreach($qd_info as $k=>$v){
            $sub_qd = DB::table('qiandao')->where(['qd_name'=>$v->qd_name])->orderBy('qd_name')->get()->toArray();
            if(!empty($sub_qd[0]->second_qd_name)){
                $info[] = [
                    'qd_str'=>'|',
                    'qd_name'=>$v->qd_name,
                    'qd_type'=>2,
                    'second_qd_name'=>'',
                    'qd_num'=>0,
                    'event_type'=>'',
                    'qd_tag'=>''
                ];
                foreach($sub_qd as $vo){
                    $vo->qd_str = '|-';
                    $info[] = (array)$vo;
                }
            }else{
                $sub_qd[0]->qd_str = '|';
                $info[] = (array)$sub_qd[0];
            }
        }
        //print_r($info);
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$this->wechat->get_access_token();
        $re = file_get_contents($url);
        //print_r(json_decode($re,1));
        return view('qiandao.qd_list',['info'=>$info]);
    }
    public function do_qd(Request $request)
    {
        $data=$request->all();
//        dd($data);
        $res = DB::table('qiandao')->insert([
            'qd_name' => $data['qd_name'],
            'second_qd_name'=>empty($data['second_qd_name'])?'':$data['second_qd_name'],
            'qd_type'=>$data['qd_type'],
            'event_type'=>$data['event_type'],
            'qd_tag'=>$data['qd_tag']
        ]);
//        dd($res);
        if($res['qd_type'] == 1){ //一级菜单
//            $first_menu_count = DB::connection('mysql_cart')->table('menu')->where(['menu_type'=>1])->count();
        }
        $data=[];
        $this->reload_qd();
    }

    public function reload_qd()
    {
        $menu_info = DB::table('qiandao')->groupBy('qd_name')->select(['qd_name'])->orderBy('qd_name')->get()->toArray();
        foreach($menu_info as $v){
            $menu_list = DB::table('qiandao')->where(['qd_name'=>$v->qd_name])->get()->toArray();
            //echo "<pre>"; print_r($menu_list);
            $sub_button = [];
            foreach($menu_list as $k=>$vo){
                if($vo->qd_type == 1){ //一级菜单
                    if($vo->event_type == 'view'){
                        $data['button'][] = [
                            'type'=>$vo->event_type,
                            'name'=>$vo->qd_name,
                            'url'=>$vo->qd_tag
                        ];
                    }else{
                        $data['button'][] = [
                            'type'=>$vo->event_type,
                            'name'=>$vo->qd_name,
                            'key'=>$vo->qd_tag
                        ];
                    }
                }
                if($vo->qd_type == 2){ //二级菜单
                    //echo "<pre>";print_r($vo);
                    if($vo->event_type == 'view'){
                        $sub_button[] = [
                            'type'=>$vo->event_type,
                            'name'=>$vo->second_qd_name,
                            'url'=>$vo->qd_tag
                        ];
                    }elseif($vo->event_type == 'media_id'){
                    }else{
                        $sub_button[] = [
                            'type'=>$vo->event_type,
                            'name'=>$vo->second_qd_name,
                            'key'=>$vo->qd_tag
                        ];
                    }
                }
            }
            if(!empty($sub_button)){
                $data['button'][] = ['name'=>$v->menu_name,'sub_button'=>$sub_button];
            }
        }
        echo "<pre>";print_r($data);
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->wechat->get_access_token();
        /*$data = [
            'button' => [
                [
                    'type'=>'click',
                    'name'=>'今日歌曲',
                    'key'=>'V1001_TODAY_MUSIC'
                ],
                [
                    'name'=>'菜单',
                    'sub_button' =>[
                        [
                            'type'=>'view',
                            'name'=>'搜索',
                            'url'=>'http://www.soso.com/'
                        ],
                        [
                            "type"=>"click",
                            "name"=>"赞一下我们",
                            "key"=>"V1001_GOOD"
                        ]
                    ]
                ],
                [
                    'type'=>'click',
                    'name'=>'明日歌曲',
                    'key'=>'V1001_TODAY_MUSIC111'
                ]
            ],
        ];*/
        $re = $this->wechat->post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        echo json_encode($data,JSON_UNESCAPED_UNICODE).'<br/>';
        echo "<pre>"; print_r(json_decode($re,1));
    }

    public function display_qd()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$this->wechat->get_access_token();
        $re = file_get_contents($url);
        echo "<pre>";
        print_r(json_decode($re,1));
    }

    public function qd_template()
    {
        $openid_info = DB::table("wechat_openid")->select('openid')->limit(10)->get()->toArray();
        // dd($openid_info);
        foreach($openid_info as $v){
            $this->qd_push_template($v->openid);
        }
    }
//根据openid发送模板消息
    public function qd_push_template()
    {
        // $openid = 'o40CXv1GcaTGu5dGCx-Z_sPRlQ_k';武密
//        $openid = 'o40CXv8ycnbfQvpkRV1CkDcwHe_I';//李伟
          $openid = 'o40CXv-PhZugcJC7RyF0r6NDZ84o';//李伟
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->wechat->get_access_token();
        // dd($url);
        $data = [
            'touser'=>$openid,
            // 'template_id'=>'pePEZV-8vvQnLu0sEPFE5mQJywg3rGvWJ6dH3RlBd1o',//武密
//            'template_id'=>'fvzQDEEqEkBfeapZX_vOGjnnZg9VnCvzPohRflcP174',//李伟
            'template_id'=>'dsCIpCbhpWsSOlToYyglesaxVMQ0tsVfK8AYkg4edIE',
            'url'=>'http://www.baidu.com',
            'data' => [
                'first' => [
                    'value' => '签到名称',
                    'color' => ''
                ],
                'keyword1' => [
                    'value' => '签到内容',
                    'color' => ''
                ],
                'keyword2' => [
                    'value' => '是低价',
                    'color' => ''
                ],
                'remark' => [
                    'value' => '签到备注',
                    'color' => ''
                ]
            ]
        ];
        $re = $this->wechat->post($url,json_encode($data));
        dd($re);
    }

    public function event(Request $request)
    {

        /*   $echostr = $_GET['echostr'];
           echo $echostr;*///第一次访问

        $data = file_get_contents("php://input");
        //解析XML
        file_get_contents("1.txt", $data);
        $xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);        //将 xml字符串 转换成对象
        $xml = (array)$xml; //转化成数组
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
//        dd($log_str);
        file_put_contents(storage_path('logs/wx_event.log'), $log_str, FILE_APPEND);
        if ($xml['MsgType'] == 'event') {
            if ($xml['Event'] == 'subscribe') { //关注
                if (isset($xml['EventKey'])) {
                    //拉新操作
                    $agent_code =explode('_', $xml['EventKey'])[1];
//                    var_dump($agent_code);die;
                    $agent_info = DB::table('user_agent')->where(['uid' => $agent_code, 'openid' => $xml['FromUserName']])->first();

                    dd($data);
                    if (empty($agent_info)) {
                        DB::table('user_agent')->insert([
                            'uid' => $agent_code,
                            'openid' => $xml['FromUserName'],
                            'add_time' => time()
                        ]);
                    }
                }
                $message = '欢迎xx同学，感谢您的关注!';
                $xml_str = '<xml><ToUserName><![CDATA[' . $xml['FromUserName'] . ']]></ToUserName><FromUserName><![CDATA[' . $xml['ToUserName'] . ']]></FromUserName><CreateTime>' . time() . '</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[' . $message . ']]></Content></xml>';
                echo $xml_str;
            }
        } elseif ($xml['MsgType'] == 'text') {
            $message = '欢迎xx同学，感谢您的关注!';
            $xml_str = '<xml><ToUserName><![CDATA[' . $xml['FromUserName'] . ']]></ToUserName><FromUserName><![CDATA[' . $xml['ToUserName'] . ']]></FromUserName><CreateTime>' . time() . '</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[' . $message . ']]></Content></xml>';
            echo $xml_str;
        }
    }

}
