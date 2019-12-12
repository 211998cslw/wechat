<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Curl;
use App\Model\News;
use App\Model\YK;

class YueKaoController extends Controller
{
    public function yk_add()
    {
        //用来限制页面执行时间
        set_time_limit(100);
        //新闻热点里
        $url = "http://api.avatardata.cn/ActNews/LookUp?key=35b6f55658e44bedb23e29addcaa1e32";
        $data = Curl::get($url);
        $result = \GuzzleHttp\json_decode($data, 1);
//        dd($result);
        $keyAyy = [];
        //循环10个
        for ($i = 0; $i <= 9; $i++) {
            $keyAyy[] = $result['result'][$i];
        }
        //调用接口
        foreach ($keyAyy as $k => $v) {
            $url = "http://api.avatardata.cn/ActNews/Query?key=35b6f55658e44bedb23e29addcaa1e32&keyword=$v";
//         dd($url);
            $data = Curl::get($url);
            $result = \GuzzleHttp\json_decode($data, 1);
//         dd($result);
            if (is_array($result['result'])) {
                foreach ($result['result'] as $key => $value) {
                    $res = News::where(['title' => $value['title']])->first();
                    $data = News::create([
                        'title' => $value['title'],
                        'content' => $value['content'],
                        'img_width' => $value['img_width'],
                        'full_title' => $value['full_title'],
                        'img' => $value['img'],
                        'pdate' => $value['pdate']
                    ]);
//            dd($data);
                }
            }
        }
    }
    public function yk_register()
    {
        return view('Api.yuekao.yk_register');
    }
    public function yk_register_do(request $request)
    {
        $re=$request->all();
        $data=YK::create([
            'name'=>$re['name'],
            'password'=>$re['password']
        ]);
//        dd($data);
        return redirect('yk_login');
    }
    public function yk_login()
    {
        return view('Api.yuekao.yk_login');
    }
    public function yk_login_do(request $request)
    {
        $name=$request->input('name');
        $password=$request->input('password');
//        dd($name);
//        dd($password);
        //查数据库
        $re=YK::where(['name'=>$name,'password'=>$password])->first();
//        dd($re);
        if(!$re){
            echo '用户名或密码错误';die;
        }
        $token=md5('id'.time());
        $re->token=$token;
        $re->expire_time=time()+7200;
        $re->save();
        return json_encode(['res'=>1,'msg'=>'登录成功','token'=>$token]);
    }
    public function yk_list()
    {
        $res=News::paginate(4);
        return view('Api.yuekao.yk_list',['res'=>$res]);
    }


}
