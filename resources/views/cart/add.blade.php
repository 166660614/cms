@extends('layouts.bst')
@section('content')
    <div class="container">
        <h1>{{$goods_detail->goods_name}}</h1>
        价格：<span id="goods_price"> {{$goods_detail->goods_price}}</span>
        <form class="form-inline">
            <div class="form-group">
                <label class="sr-only" for="goods_num">Amount (in dollars)</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="goods_num" value="1">
                </div>
            </div>
            <input type="hidden" value="{{$goods_detail->goods_id}}" id="goods_id">
            <button type="submit" class="btn btn-primary" id="add_cart_btn">加入购物车</button>
        </form>
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{URL::asset('/js/goods/goods.js')}}"></script>
@endsection