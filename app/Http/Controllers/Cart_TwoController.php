<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cart_TwoController extends Controller
{
     public function __construct()
    {
       $this->middleware('auth:api', ['except' => ['']]);
        //构造函数，过滤login
    }

    public function cart_two(Request $request)
    {
     $request=$request->input();
     $name=auth()->user();
     $u_id=$name['id'];
     $h_id=$request['h_id'];
     $data=[];
     foreach ($h_id as $key => $value) {
     	foreach ($value as $key => $value1) {
     	$data[]=DB::select("select goods.product_name as g_name,cart.details,cart.num,goodsp.price from cart join goodsp on cart.g_id=goodsp.id join goods on goodsp.goods_id=goods.product_id where cart.u_id='$u_id 'and cart.g_id='$value1'");
          
     	}
     	
     }

    return response()->json($data);
     
    }

    public function cart_two1()
    {
     $name=auth()->user();
     $u_id=$name['id'];
     $arr=DB::select("select * from address where u_id='$u_id'");
     return response()->json($arr);
    }

   public function add(Request $request)
   {
   	  $request=$request->input();
     $name=auth()->user();
     $u_id=$name['id'];
     $h_id=$request['h_id'];
     $data=[];
     $Ymd= date("Ymd");
     $srand=rand(1000,9999);
     $time=$Ymd.$srand;
     $times=date('Y-m-d h:i:s', time());
      foreach ($h_id as $key => $value) {
     	foreach ($value as $key1 => $value1) {
     	$data[]=DB::select("select goods.product_name as gname,cart.details,cart.num,goodsp.price,address.address from address join cart on address.u_id=cart.u_id join goodsp on cart.g_id=goodsp.id join goods on goodsp.goods_id=goods.product_id where cart.u_id='$u_id 'and cart.g_id='$value1'");
     	}
		     	 foreach ($data as $key3 => $value3) {
		     		foreach ($data[$key3] as $key4 => $value4) {
		     			  $gname=$value4->gname;
		     			  $details=$value4->details;
		     			  $num=$value4->num;
		     			  $price=$value4->price;
		     			  $address=$value4->address;
		     			  $status=1;
		     			  $total=$num*$price;
		        
         DB::insert("insert into order_x (`h_goods`,`h_id`,`h_type`,`num`,`price`,`order_id`) values ('$gname','$value1','$details','$num','$total','$time')");
		     		}
		     	}
		      }
         DB::insert("insert into order_z (`time`,`status`,`u_id`,`address`,`order_id`) values ('$time','$status','$u_id','$address','$time')");
		   return response()->json(['code' => 200,'status' => 'ok','data' =>'添加成功']);
		   }	 

	}
