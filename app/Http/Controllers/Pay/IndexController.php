<?php

namespace App\Http\Controllers\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderModel;
class IndexController extends Controller
{
    public function order($oid){
        //查询订单
        $order_info = OrderModel::where(['order_id'=>$oid])->first();
        if(!$order_info){
            die("订单 ".$oid. "不存在！");
        }
        //检查订单状态 是否已支付 已过期 已删除
        if($order_info->pay_status!=1){
            die("此订单已被支付，无法再次支付");
        }

        //调起支付宝支付
        header('Refresh:2;url=/pay/alipay/test');
        //支付成功 修改支付时间
        OrderModel::where(['order_id'=>$oid])->update(['pay_status'=>2,'order_status'=>3]);
        //增加消费积分 ...

        header('Refresh:2;url=/order/detail');
        echo '支付成功，正在跳转';

    }
}
