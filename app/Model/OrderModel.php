<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    public $timestamps=false;
    protected  $table='l_order';
    //自动生成订单号
    public static function generateOrderNum(){
        return date('ymdhi').rand(11111,99999).rand(2222,9999);
    }
}
