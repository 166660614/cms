<?php

namespace App\Http\Controllers\Order;

use App\Model\OrderModel;
use App\Model\CartModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function orderbuy(Request $request){
        $buy_num=$request->input('buy_num');
        $cart_id=$request->input('cart_id');
        $goods_price=$request->input('goods_price');
        $order_amount=$buy_num*$goods_price;
        $user_id=session()->get('user_id');
        $order_number=OrderModel::generateOrderNum();
        $data=[
            'order_number'=>$order_number,
            'user_id'=>$user_id,
            'order_amount'=>$order_amount,
            'order_add_time'=>time(),
        ];
        $res=OrderModel::insertGetId($data);
        if($res){
            CartModel::where(['user_id'=>$user_id,'cart_id'=>$cart_id])->delete();
            $response=[
                'msg'=>'下单成功',
                'error'=>'0',
            ];
            return $response;
        }else{
            $response=[
                'msg'=>'下单失败',
                'error'=>'301',
            ];
            return $response;
        }
    }
    //订单页
    public function orderdetail(){
        $user_id=session()->get('user_id');
        $orderData=OrderModel::where(['user_id'=>$user_id,'is_delete'=>1])->get();
        $orderlist=[
          'orderData'=>$orderData,
        ];
        return view('order.detail',$orderlist);
    }
    //取消订单
    public function ordercanno(Request $request){
        $order_id=$request->input('order_id');
        $res=OrderModel::where(['order_id'=>$order_id])->update(['is_delete'=>2]);
        if($res){
            $response=[
              'msg'=>"订单已取消",
              'error'=>"0"
            ];
            return $response;
        }else{
            $response=[
                'msg'=>"订单取消失败",
                'error'=>"301"
            ];
            return $response;
        }
    }
}
