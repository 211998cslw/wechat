<?php
namespace App\Http\Controllers;
use App\Http\Tools\Wechat;
use Illuminate\Http\Request;
use DB;
class BiaobaiController extends Controller
{
    public $wechat;
    public function __construct(Wechat $wechat)
    {
        $this->wechat=$wechat;
    }

//    表白列表
    public function biaobai_List()
    {

    }
    //我要表白，表白添加
    public function biaobai(request $request)
    {
        $data=DB::table('wechat_openid')->get();
//        dd($data);
        return view('biaobai.biaobai',['data'=>$data]);
    }
    public function do_biaobai(request $request)
    {
        $data=$request->all();
        $id=$data['id'];
        $arr=DB::table('wechat_openid')->where('id',$id)->first();
//        dd($arr);
        //查询单条id
        $res=DB::table('biaobai')->insertGetId([
            'name'=>$data['name'],
            'status'=>$data['status'],
            'id'=>$data['id']
        ]);
//        dd($res);
//        查询openid
        $openid=$arr->openid;
//        dd($openid);
//        调用Tools\Wechat  根据openid发送模板消息
        $this->push_template($openid,$res);
    }

    public function push_template($openid,$res)
    {
        $info=DB::table('biaobai')->join('wechat_openid','biaobai.id','=','wechat_openid.id')->where('openid',$openid)->where('biaobai.bb_id',$res)->first();
//        dd($info);
        $info=$info->name;
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->get_access_token();
        // dd($url);
        $data = [
            'touser'=>$openid,
            // 'template_id'=>'pePEZV-8vvQnLu0sEPFE5mQJywg3rGvWJ6dH3RlBd1o',//武密
            'template_id'=>'fvzQDEEqEkBfeapZX_vOGjnnZg9VnCvzPohRflcP174',//李伟

            'url'=>'http://www.baidu.com',
            'data' => [ 'value' => '表白备注',
                'color' => ''
            ]
        ]
        ];
        $re = $this->post($url,json_encode($data));
        dd($re);

    }
                'first' => [
                    'value' => '表白信息',
                    'color' => ''
                ],
                'keyword1' => [
                    'value' => '表白内容',
                    'color' => ''
                ],
                'remark' => [


//    我的表白
    public function my_profession()
    {

    }


}
