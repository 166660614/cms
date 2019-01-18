@extends('layouts.bst')
@section('content')
    <h1>购物车列表</h1>
<table class="table table-border" border="1">
    <tr>
        <td>商品名称</td>
        <td>商品数量</td>
        <td>商品价格</td>
        <td>添加时间</td>
        <td>操作</td>
    </tr>
    @foreach($list as $v)
    <tr cart_id="{{$v['cart_id']}}" buy_num={{$v['buy_num']}} goods_price={{$v['goods_price']}}>
        <td>{{$v['goods_name']}}</td>
        <td>{{$v['buy_num']}}</td>
        <td>{{$v['goods_price']}}</td>
        <td>{{date('Y-m-d H:i:s',$v['goods_add_time'])}}</td>
        <td>
            <button type="button" class="delete2 btn btn-danger">删除</button>
            <button type="button" class="order_buy btn btn-success">下单</button>
        </td>
    </tr>
    @endforeach
</table>
   {{-- <button type="button" class="btn btn-success">批量下单</button>--}}
@endsection
@section('footer')
    @parent
    <script src="{{URL::asset('/js/cart/cartdelete.js')}}"></script>
@endsection