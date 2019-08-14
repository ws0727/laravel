<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

   public function tree(){
	 $arr=Db::select("select * from goods_category");
	 $ary=$this->show2($arr,0,0);
	 // $json=['code'=>'200','status'=>'ok','data'=>$ary];
	 return response()->json($ary); 

    }

    public function show2($arr,$id,$level)
    {   
        $list = array();
        foreach ($arr as $k => $v) {
            if ($v->pid == $id) {
                $v->level=$level;
                $v->son = $this->show2($arr,$v->id,$level+1);
                $list[]=$v;
            }
        }
        return $list;
    }

    public function tree1()
    { 
    	$arr=Db::select("select goods.product_id,goods.product_name,goods.price,floor.id,floor.name from goods join goods_floor on goods.product_id=goods_floor.g_id join floor on goods_floor.f_id=floor.id");
    	 $data=[];
    	 
    	 foreach ($arr as $key => $value) {
             
    	 	 $data[$value->name][]=[$value->product_name,$value->product_id];
            
    	 	 //楼层为key，商品名称为值
    	 }

    	
        return response()->json($data);
    }

       public function goods()
       { 
         $goods_id=request()->post('goods_id');
         $arr=Db::select("select goods.product_id as g_id,goods.product_name as g_name,attribute.name as attr_name ,attr_details.name as d_name,attr_details.id as d_id from goods join goods_attr on goods.product_id=goods_attr.goods_id join attr_details on goods_attr.attr_details_id=attr_details.id join attribute on goods_attr.attr_id=attribute.id where goods.product_id='$goods_id'");
         $data=[];
             
             foreach ($arr as $key => $value) {
              $data[$value->attr_name][]=[$value->d_name,$value->d_id];
             }
             $attr['name']=$value->g_name;
             $attr['data']=$data;
             return response()->json($attr);
                   
       }
  
          public function product()
          {
            $goods=request()->post();
            $goods_id=$goods['goods_id'];
            $a_id=$goods['id'];
            $a_id=substr($a_id, 1);
            $arr=DB::select("select * from goodsp where goods_id='$goods_id' and goods_attr_id='$a_id'");
           
            return response()->json($arr);

          }

          
    
}
	

    