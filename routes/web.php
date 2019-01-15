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
Route::get('/users/center','Users\UserController@center')->middleware('check.login.token');
//购物车
Route::get('/users/cart','Cart\IndexController@index')->middleware('check.login.token');
Route::get('/cart/add/{goods_id}','Cart\IndexController@cartadd');
Route::get('/cart/delete/{goods_id}','Cart\IndexController@cartdelete');
Route::post('/cart/adddb','Cart\IndexController@adddb')->middleware('check.login.token');
Route::post('/cart/delete2','Cart\IndexController@cartdelete2');
Route::post('/buy/cart','Order\OrderController@orderbuy');
//商品详情页
Route::get('/goods/detail/{goods_id}','Goods\DetailController@detailshow')->middleware('check.login.token');
Route::get('/goods/allshow','Goods\DetailController@goodsshow')->middleware('check.login.token');
//订单页
Route::get('/order/detail','Order\OrderController@orderdetail')->middleware('check.login.token');
Route::post('/order/cancel','Order\OrderController@ordercanno')->middleware('check.login.token');
//支付页
Route::get('/pay/alipay/{order_id}','Pay\AlipayController@test')->middleware('check.login.token');
//Route::get('/pay/order/{oid}','Pay\IndexController@order');
Route::post('/pay/alipay/notify','Pay\AlipayController@notify');//异步通知
Route::get('/pay/alipay/snyc','Pay\AlipayController@snyc');//同步通知