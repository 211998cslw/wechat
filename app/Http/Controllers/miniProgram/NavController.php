<?php

namespace App\Http\Controllers\miniProgram;
use App\Model\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class NavController extends Controller
{
	/*
	@content 获取电视剧导航列表
	 */
    public function index()
    {
    	$list=Cate::get()->toArray();
    	// dd($list);
    	$result=[
    		'code'=>200,
    		'message'=>'success',
    		'data'=>$list
    	];
    	echo json_encode($result,JSON_UNESCAPED_UNICODE);

    }
}
