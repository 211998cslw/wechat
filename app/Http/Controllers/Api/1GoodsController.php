<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Support\Facades\Cache;
use DB;
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function weather()
    {
        $city = request ('city');
        if(!isset($city)){
            $city = "北京";
        }
        $cache_key = "weather_data_".$city;
//        dd($cache_key);
        $data = Cache::get($cache_key);
//        dd($data);
        if(empty($data)){
            echo '接口查询的';
            $url = "http://api.k780.com/?app=weather.future&weaid={$city}&ag=today,futureDay,lifeIndex,futureHour&appkey=45879&sign=cff79688d8d8dd9f0d3d25f4a08b5eed&format=json";
            $data = file_get_contents($url);
//            获取当天24点时间
            $date = date("Y-m-d");
            $time24 = strtotime($date)+86400;
//            获取当前时间
            $cache_time = $time24 - time();
            Cache::put($cache_key,$data,$cache_time);
//            dd($res);
        }
        return $data;
    }
    public function weach()
    {
        return view('Api.weather');
    }
    public function index()
    {
        //搜索 带一个搜索参数
        $where =[];
        $goods_name =request("goods_name");
//        dd($goods_name);
        if(isset($goods_name)){
            $where[] =["goods_name","like","%$goods_name%"];
        }
        //查询数据库
        $data =Goods::where($where)->paginate(3);
        return json_encode([
            'ret'=>1,
            'msg'=>'商品查询成功',
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // //dd($_FILES);
        //  $goods_name =$request->input('goods_name');
        //  $goods_price =$request->input('goods_price');
        //  $path =$request->file('goods_img')->store('');
        // //  dd($path);
        //  $goods_img =asset('storage'.'/'.$path);
        // //  dd($goods_img);
        //  // if(empty($test_name) || empty($test_age)){
        //  //     return json_encode(['ret'=>0,'msg'=>"参数不能为空"]);
        //  // }
        //  //文件上传
        //  $goods_img="";
        //  if($request->hasFile('goods_img')){
        //      $goods_img=$request->file('goods_img')->store('');
        //     //  var_dump($goods_img);die;
        //  }
        //  //添加数据入库
        //  $res =Goods::insert([
        //         'goods_name'=>$goods_name,
        //         'goods_price'=>$goods_price,
        //         'goods_img'=>$goods_img
        //  ]);
        // // dd($res);
        $data=$request->all();
        $path = $request->file('goods_img')->store('');
        // dd($path);
        $goods_img=asset('storage'.'/'.$path);
        //dd($goods_pic);
        $res=DB::connection('wechat1')->table('goods')->insert([
            'goods_name'=>$data['goods_name'],
            'goods_price'=>$data['goods_price'],
            'goods_img'=>$goods_img,
        ]);
        dd($res);
        if($res){
            return json_encode(['ret'=>1,'msg'=>"添加成功"]);
        }else{
            return json_encode(['ret'=>0,'msg'=>"异常"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
