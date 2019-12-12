<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class ArrayController extends Controller
{
    public function stu_list(Request $request)
	{
		// $res = Clas::get();
		$res=DB::table('class')->get();
   	    foreach($res as $key=>$val){
        // $info=You::where('class_id',$val['class_id'])->count();
        $info=DB::table('student')->where('class_id',$val->class_id)->count();
        // $res[$key]['attr_count']=$info;
        $res[$key]->attr_count=$info;

        // dd($res);
        }
   	    return view('api.array.stu_list',['res'=>$res]);
	}
	public function class_list()
	{
		    // $sql = You::get();
		    $sql=DB::table('student')->get();
			// $data = Clas::get();
			$data=DB::table('class')->get();
			// dd($data);
			foreach($sql as $key=>$val){
            	$sql=DB::table('student')->where('class_id',$val->class_id)->get();//YOU
        	}
        	foreach($data as $key=>$val){
            	$data=DB::table('student')->where('class_id',$val->class_id)->get();
        	}
        	$stu=[$sql,$data];
        
        	// $data = Clas::get();
        	$data=DB::table('class')->get();
   			return view('api.array.class_list',['data'=>$data,'stu'=>$stu]);
   			// dd($data);
		}
	
}
