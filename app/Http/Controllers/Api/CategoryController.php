<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Type;
use App\Model\Attr;
use DB;
class CategoryController extends Controller
{
//    分类
    public function cate_add()
    {
        return view('Api.category.cate_add');
    }
    public function cate_do_add(Request $request)
    {
        //接值 cate_name
        $cate_name=$request->input('cate_name');
//        dd($cate_name);
        $res=DB::connection('api')->table('category')->insert([
            'cate_name'=>$cate_name
        ]);
//        dd($res);
        if($res){
            echo "<script>alert('添加成功');location.href='/api/cate_list';</script>";
        }else{
            echo "<script>alert('添加失败');location.href='/api/cate_add';</script>";
        }
    }
    public function cate_list()
    {
        $res=Category::get();
        return view('Api.category.cate_list',['res'=>$res]);
    }
    //类型添加
    public function type_add_do()
    {
        $res=Attr::get();
        //dd($res);
        foreach($res as $key=>$val){
            $info = Type::where('type_id',$val['type_id'])->count();
//            $res[$key]['tnum']=$info;
        }
        // $res = json_encode($info);
        // dd($data);
        return view('Api.category.type_add_do');
        // return view('type/addto');
    }
    //类型添加执行
    public function type_add_d(Request $request)
    {
        //接值 type_name
        $type_name=$request->input('type_name');
       // dd($cate_name);
        $res=Type::insert([
            'type_name'=>$type_name
        ]);
//        dd($res);
        if($res){
            echo "<script>alert('添加成功');location.href='/api/type_add';</script>";
        }else{
            echo "<script>alert('添加失败');location.href='/api/type_add_do';</script>";
        }
    }
//类型展示
    public function type_add()
    {
        $res=Type::get();
//        dd($res);
        foreach($res as $key=>$val){
            $info =Attr::where('type_id',$val['type_id'])->count();
            $res[$key]['attr_count']=$info;
        }
//         $res = json_encode($info);
//         dd($res);
        return view('Api.category.type_add',['res'=>$res]);
    }
    //    属性
    public function attr_add()
    {
        $res =Category::get()->toArray();
//         dd($res);
        return view('Api.category.attr_add',['res'=>$res]);
    }
    public function attr_do_add(request $request)
    {
        $data=$request->all();
        $res=DB::connection('api')->table('attribute')->insert([
            'attr_name'=>$data['attr_name'],
            'type_id'=>$data['type_id'],
            'attr_name'=>$data['attr_name'],
        ]);
        if($res){
            echo "<script>alert('添加成功');location.href='/api/attr_list';</script>";
        }else{
            echo "<script>alert('添加失败');location.href='/api/attr_add';</script>";
        }
    }

    public function attr_list(request $request)
    {
        $type_id=$request->all();
       // dd($type_id);        
        $type_id=$type_id['type_id'];
//        dd($type_id);
        $res=Type::join('attribute','attribute.type_id','=','type.type_id')->where('attribute.type_id',$type_id)->get();
        return view('Api.category.attr_list',['res'=>$res]);
    }
    public function del()
    {
        $attr_id = request()->input('attr_id');
//         dd($attr_id);
        $res = Attr::where(['attr_id'=>$attr_id])->delete();
        if($res){
            return redirect();
        }
    }
}
