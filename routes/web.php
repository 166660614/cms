<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
/*Route::get('/', function () {
    echo date('Y-m-d H:i:s');
    //return view('welcome');
});*/
//用户注册
Route::get('/users/register','Users\UserController@register');
Route::post('/dousersregister','Users\UserController@doregister');
//用户登录
Route::get('/users/login','Users\UserController@login');
Route::post('/douserslogin','Users\UserController@doLogin');
//用户退出
Route::get('/users/loginout','Users\UserController@loginout');
//用户首页
Route::get('/users/center','Users\UserController@center');
//购物车
Route::get('/users/cart','Cart\IndexController@index');
Route::get('/cart/add/{goods_id}','Cart\IndexController@cartadd');
Route::get('/cart/delete/{goods_id}','Cart\IndexController@cartdelete');
Route::post('/cart/adddb','Cart\IndexController@adddb');
Route::post('/cart/delete2','Cart\IndexController@cartdelete2');
Route::post('/buy/cart','Order\OrderController@orderbuy');
//商品详情页
Route::get('/goods/detail/{goods_id}','Goods\DetailController@detailshow');
Route::get('/goods/allshow','Goods\DetailController@goodsshow');
//订单页
Route::get('/order/detail','Order\OrderController@orderdetail');
Route::post('/order/cancel','Order\OrderController@ordercanno');
//支付页
Route::get('/pay/alipay/order/{order_id}','Pay\AlipayController@test');
//Route::get('/pay/order/{oid}','Pay\IndexController@order');
Route::post('/pay/alipay/notify','Pay\AlipayController@notify');//异步通知
Route::get('/pay/alipay/snyc','Pay\AlipayController@snyc');//同步通知
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//微信支付
Route::get('/weixin/pay/unified/{order_id}','Pay\WxPayController@unifiedOrder');     //微信支付下单
Route::post('/weixin/pay/notify','Pay\OrderController@notify');//微信支付异步回调
