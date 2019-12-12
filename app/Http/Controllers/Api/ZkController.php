<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Curl;
use App\Model\News;
use App\Model\Login;

class ZkController extends Controller
{
    public function zk_add()
    {
        set_time_limit(100);
        //搜索关键字从新闻热点里
        $url="http://api.avatardata.cn/ActNews/LookUp?key=ea86d869a49c40d6888709ab0bc0ab2d";
        $hostData=Curl::get($url);
        $hostData=\GuzzleHttp\json_decode($hostData,true);
        $keyWordArr=[];//热点
        //循环取10个热点
        for($i=0;$i<=9;$i++){
            $keyWordArr[]=$hostData['result'][$i];
        }
        //接口调用
//        $keyArr=['奥巴马','NBA','特朗普','国安'];
        //通过关键字 循环执行调用接口
        foreach($keyWordArr as $k=>$v){
            //循环数组
            $url='http://api.avatardata.cn/ActNews/Query?key=ea86d869a49c40d6888709ab0bc0ab2d&keyword='.$v;
            // dd($result);
            $data=Curl::get($url);
            $re=json_decode($data,1);
//        dd($re);
            //存储到数据库
            //如果返回的数据不为空 入库
            if(!empty($re['result'])){
                foreach ($re['result'] as $key=>$value){
                    //重复的新闻就不要入库 通过新闻标题 查询数据库
                    $newData=News::where(['title'=>$value['title']])->first();
                    if(!$newData){
                        News::create([
                            'title'=>$value['title'],
                            'content'=>$value['content'],
                            'img_width'=>$value['img_width'],
                            'full_title'=>$value['full_title'],
                            'img'=>$value['img'],
                            'pdate'=>$value['pdate']
                        ]);
                    }
                }
            }
        }
    }
    public function zk_register()
    {
        return view('Api.register.zk_register');
    }
    public function zk_register_do(request $request)
    {
        $re=$request->all();
        $data=Login::create([
            'name'=>$re['name'],
            'password'=>$re['password']
        ]);
//        dd($data);
//        if($data){
//            return json_encode(['ret'=>1,'msg'=>"注册成功"]);
//        }else{
//            return json_encode(['ret'=>0,'msg'=>"异常"]);
//        }
        return redirect('zk_login');
    }
    public function zk1_login(){
        return view('Api.register.zk1_login');
    }
    public function zk_login_do(request $request)
    {
        //用户名和密码
        $name=$request->input('name');
        $password=$request->input('password');
        //查询数据库
        $userData =Login::where(['name'=>$name,'password'=>$password])->first();
        if(!$userData){
            echo '用户名密码错误';die;
        }
        // 生成token令牌
        $token=md5('id'.time());//生成一个不重复的token令牌
        // dd($token);
        //修改数据库
        $userData->token=$token;
        $userData->expire_time=time()+7200;
        $userData->save();
        //返回给客户端
        return json_encode(['ret'=>1,'msg'=>'登录成功','token'=>$token]);
    }
    public function zk_list(request $request)
    {
        // $data=$request->all();
        $res=News::get();
        // var_dump($res);die;
        return json_encode(['code'=>1,'msg'=>$res]);
    }
}
