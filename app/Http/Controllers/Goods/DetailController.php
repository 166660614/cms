<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/3 0003
 * Time: 17:05
 */
namespace App\Http\Controllers\Goods;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsModel;
class DetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //商品详情页
  public function detailshow($goods_id){
      $goods_detail=GoodsModel::where(['goods_id'=>$goods_id])->first();
      return view('cart.add')->with('goods_detail',$goods_detail);
  }
  //全部商品展示
    public function goodsshow(){
      $goodsData=GoodsModel::paginate(3);
      $goodslist=[
          'goodsData'=>$goodsData,
      ];
      return view('goods.allshow',$goodslist);
    }
}