<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
     public function __construct()
    {
       $this->middleware('auth:api', ['except' => ['']]);
        //构造函数，过滤login
    }


    public function insert()
    {

         $name=auth()->user();
         $u_id=$name['id'];
         $goodsp_id=request()->post('goodsp_id');
         $num=request()->post('num');
         $details=request()->post('details');
         $arr1=DB::select("select * from cart where g_id='$goodsp_id'");
         if (empty($arr1)) {
          $arr2=DB::insert("insert into  cart (`u_id`,`g_id`,`num`,`details`) values ('$u_id','$goodsp_id','$num','$details')");
         }else{
           $arr=DB::update("update cart set  num='$num', details='$details' where g_id='$goodsp_id'");
         }
         

      return response()->json([
            'code' => 200,
            'status' => 'ok',
            'data' =>'添加成功' ,
          
        ]);
    }


    public function buycart()
    {
       $name=auth()->user();
       $u_id=$name['id'];
       $arr=DB::select("select goodsp.goods_id,goodsp.price ,cart.num,cart.details,goods.product_name,goodsp.id as goodsp_id from cart join goodsp on cart.g_id=goodsp.id join goods on goodsp.goods_id=goods.product_id where u_id='$u_id'");
        return response()->json($arr);
    }
      
     public function greed()
     {
     	  $num=request()->post('num');
     	  $goodsp_id=request()->post('goodsp_id');
          $name=auth()->user();
          $u_id=$name['id'];
          DB::update("update cart set num='$num' where u_id='$u_id' and g_id='$goodsp_id'");
          return response()->json($goodsp_id);
     }

}