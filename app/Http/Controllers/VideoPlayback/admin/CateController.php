<?php

namespace App\Http\Controllers\VideoPlayback\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class CateController extends Controller
{
	//分类添加
	public function cate_add()
	{
		// echo 111;die;
		return view('videoplayback.admin.cate.cate_add');
	}

	public function cate_add_do(request $request)
	{
		$data=$request->input('cate_name');
		// dd($data);
		$res=DB::table('cate')->insert([
			'cate_name'=>$data
		]);
		// dd($res);
		return redirect('cate_list');
	}

	public function cate_list(request $request)
	{
		$data=$request->all();
		// dd($data);
		$res=DB::table('cate')->get();
		return view('videoplayback.admin.cate.cate_list',['res'=>$res]);
	}

	public function cate_del($id)
	{
        $res=DB::table('cate')->where('cate_id',$id)->delete();
        // dd($res);
        return redirect('cate_list');
	}

	public function cate_update($id)
	{
		// echo 111;die;
		$res=DB::table('cate')->where('cate_id',$id)->first();
		return view('videoplayback.admin.cate.cate_update',['res'=>$res]);
	}

	public function cate_update_do($id)
	{
		$data=request()->post();
		// dd($data);
		$res=DB::table('cate')->where('cate_id',$id)->update($data);
		// dd($res);
		return redirect('cate_list');
	}
}