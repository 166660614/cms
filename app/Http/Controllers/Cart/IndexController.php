<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/8 0008
 * Time: 14:12
 */
namespace App\Http\Controllers\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsModel;
use App\Model\CartModel;
class IndexController extends Controller{
    public function index(Request $request){
            $user_id=session()->get('user_id');
            if(!empty($user_id)){
                $cart_detail = CartModel::where(['user_id'=>$user_id])->get()->toArray();
                //print_r($cart_detail);exit;
                if(empty($cart_detail)){
                    echo '购物车是空的';
                    header('refresh:1;url=/users/center');
                }else{
                    foreach ($cart_detail as $k=>$v){
                        $goodsInfo= GoodsModel::where(['goods_id'=>$v['goods_id']])->first();
                        $goodsInfo['buy_num']=$v['buy_num'];
                        $goodsInfo['cart_id']=$v['cart_id'];
                        $list[]=$goodsInfo;
                    }
                        $detail=[
                            'list'=>$list
                        ];
                        return view('cart.cart',$detail);
                }

            }else{
                echo '您还没有登录';
                header('refresh:1;url=/users/login');
            }


    }
    //购物车添加
    public function cartadd($goods_id){
        $res=GoodsModel::where(['goods_id'=>$goods_id])->first();
        if(empty($res)){
            echo "非法操作";exit;
        }
        $cart_goods=session()->get('cart_goods');
        //购物车是否存在
        if(!empty($cart_goods)){
            if(in_array($goods_id,$cart_goods)){
                echo "该商品购物车已存在";
            }
        }
        session()->push('cart_goods',$goods_id);
        //减库存
        $where=['goods_id'=>$goods_id];
        $store=GoodsModel::where($where)->value('goods_store');
        if($store<=0){
            echo "库存不足";
            exit;
        }
        $result=GoodsModel::where(['goods_id'=>$goods_id])->decrement('goods_store');
        if($result){
            echo "添加成功";
        }
        print_r($cart_goods);
    }
    //购物车删除
    public function cartdelete($goods_id){
        $goods=session()->get('cart_goods');
        if(in_array($goods_id,$goods)){
            foreach($goods as $k=>$v){
                if($goods_id==$v){
                    session()->pull('cart_goods.'.$k);
                }
            }
            print_r($goods);
        }else{
            die('该商品不在购物车');
        }
    }

    //添加购物车到数据库
    public function adddb(Request $request){
        $goods_id = $request->input('goods_id');
        $buy_num = $request->input('goods_num');
        $data=[
            'goods_id'=>$goods_id,
            'buy_num'=>$buy_num,
            'cart_add_time'=>time(),
            'user_id'=>session()->get('user_id'),
            'session_token'=>session()->get('u_token'),
        ];
        $res=CartModel::insertGetId($data);
        if(!$res){
            $response=[
                'error'=>5002,
                'msg'=>'添加购物车失败，请重试'
            ];
            return $response;
        }else{
            $response=[
                'error'=>0,
                'msg'=>'添加成功'
            ];
            return $response;
        }
    }
    //购物车删除数据库
    public function cartdelete2(Request $request){
        $cart_id=$request->input('cart_id');
        $user_id=session()->get('user_id');
        $res=CartModel::where(['cart_id'=>$cart_id,'user_id'=>$user_id])->delete();
        if($res){
            $response=[
                'error'=>0,
                'msg'=>'删除成功'
            ];
            return $response;
        }else{
            $response=[
                'error'=>5003,
                'msg'=>'删除失败'
            ];
            return $response;
        }
    }
}