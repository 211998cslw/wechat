<?php

namespace App\Http\Controllers\aa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Tools;
class TagController extends Controller
{
    public $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    //标签管理列表
    public function tag_list()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/get?access_token=" . $this->tools->get_wechat_access_token();
//        dd($url);
        $re = file_get_contents($url);
//        dd($result);
        $result = json_decode($re, 1);
//        dd($result);
        return view('aa.tag.tag_list', ['info' => $result['tags']]);
    }
    //添加标签
    public function add_tag()
    {
        return view('aa.tag.add_tag');
    }
    //添加执行标签
    public function add_do_tag(request $request)
    {
        $req = $request->all();
//        dd($req);
        $data = [
            'tag' => [
                'name' => $req['name']
            ]
        ];
//        dd($data);
        $url = "https://api.weixin.qq.com/cgi-bin/tags/create?access_token=" . $this->tools->get_wechat_access_token();
//        dd($url);
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=json_decode($re,1);
//        dd($result);
        return redirect('tag_list');
    }
    // 删除标签
    public function tag_del(request $request)
    {
        $req=$request->all();
        $url="https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=".$this->tools->get_wechat_access_token();
//        dd($url);
        $data=[
            'tag'=>[
                'id'=>$req['id']
            ]
        ];
//        dd($data);
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
//        dd($re);
        $result=json_decode($re,1);
        dd($result);
    }
    // 修改标签
    public function tag_update(request $request)
    {

        return view('aa.tag.tag_update',['tag_id'=>$request->all()['tag_id'],'tag_name'=>$request->all()['tag_name']]);
    }
    // 修改执行标签
    public function do_update_tag(request $request)
    {
        $req=$request->all();
        $url="https://api.weixin.qq.com/cgi-bin/tags/update?access_token=".$this->tools->get_wechat_access_token();
        $data=[
            'tag'=>[
                'name'=>$req['name'],
                'id'=>$req['tag_id']
            ]
        ];
//        dd($data);
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=json_decode($re,1);
        dd($result);
    }
    //推送标签群发消息
    public function push_tag_message(Request $request)
    {
//        echo 11;die;
        return view('aa.tag.push_tag_message',['tagid'=>$request->all()['tagid']]);
    }
    //推送执行标签群发消息
    public function do_push_tag_message(Request $request)
    {
        $req = $request->all();
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

    public function user_tag_list(Request $request)
    {
        $req = $request->all();
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'openid'=>$req['openid']
        ];
        $re = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($re,1);
        $tag = file_get_contents('https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->tools->get_wechat_access_token());
        $tag_result = json_decode($tag,1);
        $tag_arr = [];
        foreach($tag_result['tags'] as $v){
            $tag_arr[$v['id']] = $v['name'];
        }
        foreach($result['tagid_list'] as $v){
            echo $tag_arr[$v]."<br/>";
        }
    }

    public function tag_openid(Request $request)
    {
        $req = $request->all();
//        dd($req);
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$this->tools->get_wechat_access_token();
//        dd($url);
        $data = [
            'openid_list'=>$req['openid_list'],
            'tagid'=>$req['tagid']
        ];
//        dd($data);
        $re = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($re,1);
        dd($result);
    }
    //标签下粉丝列表
    public function tag_openid_list(Request $request)
    {
        $req = $request->all();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'tagid' => $req['tagid'],
            'next_openid' => ''
        ];
        $re = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($re,1);
        dd($result);
    }


}
