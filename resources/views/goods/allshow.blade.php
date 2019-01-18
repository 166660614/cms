@extends('layouts.bst')
@section('content')
    <h1>全部商品</h1>
    <table class="table table-border" border="1">
        <tr>
            <td>商品名称</td>
            <td>商品价格</td>
            <td>添加时间</td>
            <td>操作</td>
        </tr>
        @foreach($goodsData as $v)
        <tr>
           <td>{{$v['goods_name']}}</td>
            <td>{{$v['goods_price']}}</td>
            <td>{{date('Y-m-d H:i:s',$v['goods_add_time'])}}</td>
            <td>
                <a href="/goods/detail/{{$v['goods_id']}}" class="btn btn-primary">商品详情</a>
            </td>
        </tr>
         @endforeach
    </table>
    {{$goodsData->links()}}
@endsection
@section('footer')
    @parent
    <script src="{{URL::asset('/js/goods/goods.js')}}"></script>
@endsection