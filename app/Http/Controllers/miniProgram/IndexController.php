<?php

namespace App\Http\Controllers\miniProgram;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Mini\Nav;
use App\Model\Mini\KaoGoods;
class IndexController extends Controller
{
    public function  lists(){
        $data =Nav::get()->toArray();
        $data=[
          'code'=>200,
          'masset'=>'success',
          'data'=>$data
        ];
        echo  json_encode($data,JSON_UNESCAPED_UNICODE);


//        dd($data);
    }
    public function cha(Request $request){
//        dd(1);
//        echo json_encode(1);
        $name=$request->name;
        // dd($name);
        $data=[];
        if(!empty($name)){
            $data =KaoGoods::where('title','like',"%$name%")->select('title')->get()->toArray();
            // dd($data);
        }
        $data=[
            'code'=>200,
            'masset'=>'success',
            'data'=>$data
        ];
        // dd($data);
        echo json_encode($data);
    }
}
