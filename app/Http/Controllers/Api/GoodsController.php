<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods;
use App\Model\Type;
use App\Model\Category;
use App\Model\Attr;
use App\Model\GoodsAttr;
use App\Model\Cargo;
use DB;
class GoodsController extends Controller
{
    public function store(Request $request)
    {
        $data=$request->all();
//        dd($data);
        $path = $request->file('goods_img')->store('goods');
//         dd($path);
        $goods_img=asset('storage'.'/'.$path);
       // dd($goods_img);
        $res=DB::connection('wechat1')->table('goods')->insert([
            'goods_name'=>$data['goods_name'],
            'goods_price'=>$data['goods_price'],
            'goods_img'=>$goods_img,
        ]);
//        dd($res);
        if($res){
            return json_encode(['ret'=>1,'msg'=>"添加成功"]);
        }else{
            return json_encode(['ret'=>0,'msg'=>"异常"]);
        }
    }
    public function goods_add(request $request)
    {
        //查询分类数据
        $cateData=Category::get()->toArray();
//        dd($cateData);
        //查询类型
        $typeData=Type::get()->toArray();
//        dd($typeData);
        return view('Api.goods.goods_add',['cateData'=>$cateData],['typeData'=>$typeData]);
    }
    public function goods_list()
    {
        $res=DB::table('goods')->paginate(2);
        return view('Api.goods.goods_list',['res'=>$res]);
    }
//根据类型 查出该类型所对应的属性
    public function getAttr(Request $request)
    {
        $type_id=$request->input('type_id');
//        dd($type_id);
        //查属性表
        $attrData=Attr::where(['type_id'=>$type_id])->get()->toArray();
        return json_encode($attrData);
    }

    public function add_do(request $request)
    {
        $postData=$request->input();
//        dd($postData);
        $path = $request->file('goods_img')->store('goods');
       // dd($path);
        $goods_img=asset('storage'.'/'.$path);
//        dd($goods_img);
        //1.商品基本信息入库
        $goods=Goods::create([
            'goods_name'=>$postData['goods_name'],
            'id'=>$postData['id'],
            'goods_price'=>$postData['goods_price'],
            'goods_img'=>$goods_img,
            'goods_desc'=>$postData['goods_desc']
        ]);
//        echo "<pre>";
//       dump($goods);die;
        //获取商品主键id
//        dd($goods);
        $goods_id=$goods->id;
//        dd($goods_id);
//        2.商品属性信息入库=》商品-属性关系表
        $insertData=[];//定义要添加入库的数据
        foreach ($postData['attr_value_list'] as $key =>$value){
            $insertData[]=[
                'goods_id'=>$goods_id,
                'attr_id'=>$postData['attr_id_list'][$key],
                'attr_value'=>$value,//属性的值
                'attr_price'=>$postData['attr_price_list'][$key]
            ];
//            dd($insertData);
        }
        //批量入库
        $res=GoodsAttr::insert($insertData);
//        dd($res);
        return redirect('cargo_add/'.$goods_id);
    }
    public function cargo_add(request $request,$goods_id)
    {
        //根据商品id查询商品基本信息
//        $goods_id=$request->input('goods_id');
////        dd($goods_id);
        $goodsData=Goods::where(['goods_id'=>$goods_id])->first();
//        dd($goodsData);
//        根据商品id 查商品属性关系表(属性值)
        $goodsAttrData=GoodsAttr::join("attribute","goodsattr.attr_id","=","attribute.attr_id")->where(['goods_id'=>$goods_id])->get()->toArray();
//        dd($goodsAttrData);
        //处理数据
        $newArr=[];
        foreach ($goodsAttrData as $key=>$value){
            $status=$value['attr_name'];
            $newArr[$status][]=$value;
        }
//                echo "<pre>";
//        var_dump($goodsAttrData);
        return view('Api.goods.cargo_add',[
            'attrData'=>$newArr,
            'goods_id'=>$goods_id
        ]);
    }
    public function cargo_do_add(request $request)
    {
        $postData=$request->input();
//        dd($postData);
//        echo "<pre>";
//        var_dump(count($postData['attr']));die;
        //属性值组合处理数据
//        dd(count($postData['product_number']));
        $size = count($postData['goods_attr']) / count($postData['product_number']);
//        dd($size);
//        $size=count($postData['goods_attr']) / count($postData['product_number']);
////        dd($size);
        $goodsAttr=array_chunk($postData['goods_attr'],$size);
//        dd($goodsAttr);
        //echo "<pre>";
//        var_dump($postData);
//        var_dump($goodsAttr[0][0]);die;
        foreach ($goodsAttr as  $key=>$value) {
            Cargo::create([
                'goods_id' =>$postData['goods_id'],
                'value_list' =>implode(",", $value),
                'product_number' => $postData['product_number'][$key],
            ]);
        }
    }
}

































