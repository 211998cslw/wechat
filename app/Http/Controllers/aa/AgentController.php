<?php

namespace App\Http\Controllers\aa;
use App\Tools\Tools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use DB;
use GuzzleHttp\Client;
class AgentController extends Controller
{
    public $tools;
    public $client;
    public function __construct(Tools $tools,Client $client)
    {
        $this->tools=$tools;
        $this->client=$client;
    }
    public function agent_list()
    {
//        echo 111;die;
        $info=DB::connection('wechat1')->table('user')->get();
//       dd($info);
        return view('aa.agent.agent_list',['info'=>$info]);
    }
    //生成专属的二维码
    public function create_qrcode(request $request)
    {
        // dd($request->all());
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'expire_seconds'=> 30 * 24 * 3600,
            'action_name' => 'QR_SCENE',
            'sction_info'=>[
                'scene'=>[
                    'scene_id'=>$request->all()['id']
                ]
            ]
        ];
        $re = $this->tools->curl_post($url,json_encode($data));

        $result = json_decode($re,1);
        // dd($result);
        $qrcode_info = file_get_contents('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($result['ticket']));
        // dd($qrcode_info);
        $path='/wechat/qrcode/'.time().rand(1000,9999).'.jpg';
        Storage::put($path, $qrcode_info);
//    dd($path);
        DB::connection('wechat1')->table('user')->where(['id'=>$request->all()['id']])->update([
            'qrcode_url'=> '/storage'.$path
        ]);
        return redirect('agent_list');
    }
}
