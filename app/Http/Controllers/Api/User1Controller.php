<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        /*$user_name=$request->input("name");
//        dd($user_nmae);
        $where=[];
        if (!empty($user_name)){
            $where[]=['test_name','like',"%$user_name%"];
        }elseif (!empty($user_name)){
            $where[]=['user_tel','like',"%$user_name%"];
        }
        $data =DB::connection('wechat1')->table('test')->where($where)->paginate(2)->toArray();
//        dump($data['data']);die;
        return json_encode(['code'=>'200','data'=>$data,'res'=>'1']);*/

        $where =[];
        $name =request("name");
        if(isset($name)){
            $where[] =["test_name","like","%$name%"];
        }
        //查询数据库
        $data =DB::connection('wechat1')->table('test')->where($where)->paginate(3);
        return json_encode([
            'ret'=>1,
            'msg'=>'查询成功',
            'data'=>$data,
        ]);

    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //添加
    public function store(Request $request)
    {
        //接值
        $name=$request->input('test_name');
        dd($name);
        $age=$request->input('test_age');
       if(empty($name)||empty($age)){
           echo '参数不能为空';die;
       }
       //处理文件上传
       $img_path="";
       if($request->hasFile('file')){
            $img_path=$request->file->store('images');
//        var_dump($img_path);die;
       }
        //添加入库
        $data=DB::connection('wechat1')->table('test')->insert([
            'test_name'=>$name,
            'test_age'=>$age,
            'img_path'=>$img_path
        ]);
        if($data){
            return json_encode(['res'=>200,'msg'=>'添加成功']);
        }else{
            return json_encode(['res'=>201,'msg'=>'添加失败']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(request $request,$id)
    {
        $data=DB::connection('wechat1')->table('test')->where(['id'=>$id])->first();
        //状态值 描述
        return json_encode([
            'res'=>1,
            'data'=>$data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //修改
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //修改
    public function update(Request $request,$id)
    {
        $data=$request->all();
        $res=DB::connection('wechat1')->table('test')->where(['id'=>$data['id']])->update([
            'test_name'=>$data['test_name'],
            'test_age'=>$data['test_age']
        ]);
//        dd($res);
        if($res){
            return json_encode(['ret'=>1,'msg'=>'修改成功']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //删除
    public function destroy($id)
    {
        $id = request()->input('id');
//         dd($id);
        $res = DB::connection('wechat1')->table('test')->where(['id'=>$id])->delete();
        if($res){
            return json_encode(['res'=>1,'msg'=>'删除成功']);
        }


    }
}
