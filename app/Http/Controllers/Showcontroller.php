<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ShowController extends Controller
{
   
	    public function index()
	    {
		  return view('index');
	    }

	     public function show()
	    {

	    $arr = DB::select("select * from goods");
        $arr1=['code'=>'0','status'=>'ok','data'=>$arr];
        return response()->json($arr);
        // echo json_encode($arr);  
	    }
         


         public function gettree()
	    {

	    $arr = DB::select("select * from goods_category");
		$arr1=$this->show2($arr,0,0);
        $json=['code'=>'200','status'=>'success','data'=>$arr1];
        return response()->json($arr1);
      
	    }
         
          public function show2($arr,$id,$level)
        {
        	$list=array();
        	foreach ($arr as $k => $v) {
        		if ($v->id==$id) {
        			$v->lenven=$level;
        			$v->data=$this->show2($arr,$v->id,$level+1);
        			$list[]=$v;
        			
        		}

        	}
        	return $list;
        }
			

	     public function addaction()
	    {
        $name = Input::get('name');
	    $password = Input::get('password');
		$arr=DB::query("insert into admin(`name`,`password`) values ('$name','$password')");
        $arr1=['code'=>'0','status'=>'ok','data'=>'添加成功'];
        return json_encode($arr1);

	    }


}