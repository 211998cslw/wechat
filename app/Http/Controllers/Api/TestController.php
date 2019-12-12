<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class TestController extends Controller
{
    public function test_list()
    {
        $data=DB::connection('wechat1')->table('test')->get();
        //状态值 描述
        return json_encode([
            'res'=>1,
            'data'=>$data
        ]);
    }
    public function test_do(request $request)
    {
        //接值8
        $name=$request->input('test_name');
        $age=$request->input('test_age');
        $sign=$request->input('sign');
       if(empty($name)||empty($age)){
           echo '参数不能为空';die;
       }
       if(empty($sign)){
        return json_encode(['ret'=>0,'msg'=>'签名不能为空']);
       }
       $mySign=md5('wechat'.$name,$age);//自己生成的签名
       if($mySign!=$sign){
        return json_encode(['ret'=>0,'msg'=>'签名不对']);


       }

        //添加入库
        $data=DB::connection('wechat1')->table('test')->insert([
            'test_name'=>$name,
            'test_age'=>$age
        ]);
       if($data){
           return json_encode(['res'=>200,'msg'=>'添加成功']);
       }else{
           return json_encode(['res'=>201,'msg'=>'添加失败']);
       }
    }

    public function test_update(request $request)
    {
        $id=$request->input('id');
        $data=DB::connection('wechat1')->table('test')->where(['id'=>$id])->first();
        //状态值 描述
        return json_encode([
            'res'=>1,
            'data'=>$data
        ]);
    }

    public function test_do_update(Request $request)
    {
        $data= $request->all();
//         dd($data);
        $res=DB::connection('wechat1')->table('test')->where(['id'=>$data['id']])->update([
            'test_name'=>$data['test_name'],
            'test_age'=>$data['test_age']
        ]);
        if($res){
            return json_encode(['ret'=>1,'msg'=>'修改成功']);
        }
    }
    public function test_delete(request $request)
    {
        $id = request()->input('id');
//         dd($id);
        $apiData = DB::connection('wechat1')->table('test')->where(['id'=>$id])->delete();
        return json_encode(['code'=>200,'msg'=>'删除成功','apiData'=>$apiData]);
    }
}
