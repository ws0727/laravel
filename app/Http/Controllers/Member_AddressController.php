<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Member_AddressController extends Controller
{
     public function __construct()
    {
       $this->middleware('auth:api', ['except' => ['']]);
      
    }

    public function member_address(Request $request)
    {
     $request=$request->input();
     $p_id=$request['p_id'];
     $arr=DB::select("select * from area where parent_id='$p_id'");
     return response()->json($arr);
    }

    public function address(Request $request)
    {
      $request=$request->input();
      $name=$request['name'];
      $address=$request['address'];
      $phone=$request['phone'];
      $yx=$request['yx'];
      $phone_d=$request['phone_d'];
      $code=$request['code'];
       $name1=auth()->user();
       $u_id=$name1['id'];
      DB::insert ("insert into address (`address`,`phone`,`email`,`code`,`name`,`phone_d`,`u_id` ) values ('$address','$phone','$yx',' $code','$name',' $phone_d','$u_id')");
       return response()->json([
            'code' => 200,
            'status' => 'ok',
            'data' =>'添加成功' ,
          
        ]);

    }

    public function show()
    {
    	$arr=DB::select("select * from address");
    	 return response()->json($arr);
    }


}

