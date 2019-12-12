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
use App\Model\Cart;
use App\Model\Login;
use Illuminate\Support\Facades\Cache;


class NewsController extends Controller
{
	//商品首页,每日新款发售
    public function news()
    {
        $data=Goods::orderBy('goods_id','desc')->limit(4)->get();
        // dd($data);
        // foreach ($data as $key => $value) {
        // 	$base_path="http://www.wechat.com/storage/goods/UigU97tzkzxCeUkr6X79FucREgZYnovMLJYjRNPV.jpeg";//默认图片
        // }
        return json_encode(['ret'=>1,'data'=>$data]);
    }
    //商品分类
    public function goods_cate()
    {
    	// $id=$request->input('id');
    	// $data=Category::where('id')->get();
    	// echo '<pre>';
     //    var_dump($data);die;
        $data=Category::get();
        //  echo '<pre>';
        // var_dump($data);die;
        return json_encode($data);
    }
    // 商品分类列表
    public function goods_cate_do(request $request)
    {
        // $id=$request->input('id');
      /*  $goods_id=$request->input('goods_id');
       $data=Category::join('goods','category.id','=','goods.id')->where(['goods_id'=>$goods_id])->get()->toArray();*/
       // $data=Goods::join('category','goods.id','=','category.id')->where(['goods_id'=>$goods_id])->first();
       $data=Goods::get();
        return json_encode($data);
    }
    
    //商品详情
    public function goods_details(request $request)
    {
    	$goods_id=$request->input('goods_id');
    	//查询商品表基本信息 goods
    	$goodsData=Goods::where(['goods_id'=>$goods_id])->first();
    	// dd($goodsData);
    	// 查询商品-属性关系表(两表联查)goods_attr
    	$goodsAttrData=GoodsAttr::join('attribute','goodsattr.attr_id','=','attribute.attr_id')->where(['goods_id'=>$goods_id])->get()->toArray();
    	// echo '<pre>';
    	// var_dump($GoodsAttrData);
    	$specData = [];//可先规格数线
        $argsData = [];//普通展示属性
        foreach ($goodsAttrData as $key => $value){
            if($value['attr_status'] == 1){
                //可选规格
                $status = $value ['attr_name'];
                $specData[$status][] = $value;
            
            }else{ 
                $argsData[]  = $value;
            }
        }
        
        return json_encode(['goodsData'=>$goodsData,'specData'=>$specData,'argsData'=>$argsData]);
    }
    //购物车接口
    public function cartAdd(request $request)
    {
        $userData = $request->get('userData');//中间件产生的参数
         // var_dump($userData);die;
         //接值 
        $goods_id =$request->input('goods_id');
        $goods_attr_list = implode(",",$request->input('goods_attr_list'));
        //校验token令牌 校验用户身份
        $token=$request->input('token');
        $id=$userData['id'];
        $buy_number=1;
        //判断库存量
        //   利用goods_id属性id组合查询货品表 库存
        $cargoData=Cargo::where(['goods_id'=>$goods_id,'value_list'=>$goods_attr_list])->first();
        // dd($cargoData);
        $product_num=$cargoData['product_number'];//商品的库存量
        if ($buy_number>=$product_num){
            //没货
            $is_have_num=0;
        }else{
            //有货
            $is_have_num=1;
        }
        // var_dump($cargoData);die;
        //判断加入购物车商品 是否已存在
        $cartData=Cart::where(['goods_id'=>$goods_id,'id'=>$id,'goods_attr_list'=>$goods_attr_list])->first();
        // dd($cartData);
        if(!empty($cartData)){
            //如果存在 修改数据  数量+1
            $cartData->buy_number=$cartData->buy_number+$buy_number;
            $cartData->save();
        }else{
            //如果数据不存在 添加数据
            Cart::create([
                'goods_id'=>$goods_id,
                'goods_attr_list'=>$goods_attr_list,
                'id'=>$id,
                'buy_number'=>$buy_number,
                'is_have_num'=>$is_have_num,
                'sku_id'=>$cargoData['sku_id']
            ]);
        }      
    }

    //购物车列表接口
    public function cartList(request $request)
    {
        //接收中间件传递的参数
        $userData=$request->get('userData');
        // dd($userData);
        $id=$userData['id'];
        // dd($id);
        //查询购物车表数据
        $cartData=Cart::join('goods','cart.goods_id','=','goods.goods_id')->where(['user_id'=>$id])->get()->toArray();
        // dd($cartData);
        //属性值的组合  颜色xx.内存:xxx
        foreach ($cartData as $key => $value) {
            $goods_attr_list=explode(",",$value['goods_attr_list']);
            // dd($goods_attr_list);
            //查询属性值表
            $GoodsAttrData=GoodsAttr::join('attribute','goodsattr.attr_id','=','attribute.attr_id')->whereIn('id',$goods_attr_list)->get()->toArray();
            // dd($GoodsAttrData);
            //组装字符串
            $attr_show_list='';//颜色xx.内存:xxx
            $count_price=$value['goods_price'];//商品真实总价=商品基本价钱+每个属性的价钱
            foreach ($GoodsAttrData as $k => $v) {
                $attr_show_list.$v['attr_name'].":".$v['attr_value'].",";
                //价钱的计算 加上每个属性的价钱
                $count_price+=$v['attr_price'];
            }
            //重新对数组元素赋值
            $cartData[$key]['attr_show_list']=rtrim($attr_show_list,',');
            $cartData[$key]['goods_price']=$count_price;
        }
        return json_encode($cartData);
    }
}

