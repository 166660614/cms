@extends('layouts.bst')
@section('content')
    <h1>订单列表</h1>
    <table class="table table-border" border="1">
        <tr>
            <td>订单号</td>
            <td>订单总价</td>
            <td>添加时间</td>
            <td>订单状态</td>
        </tr>
        @foreach($orderData as $v)
        <tr order_id="{{$v['order_id']}}">
            <td>{{$v['order_number']}}</td>
            <td>{{$v['order_amount']}}</td>
            <td>{{date('Y-m-d H:i:s',$v['order_add_time'])}}</td>
            <td>
                @if($v['order_status']==1)
                <a class="btn btn-success" href="/pay/alipay/order/{{$v['order_id']}}">支付宝支付</a>
                    <a class="btn btn-success" href="/weixin/pay/unified/{{$v['order_id']}}">微信支付</a>
                <a href="" class="orderno btn btn-danger">取消订单</a>
                @elseif($v['order_status']==3)
                <a class="btn btn-success" style="cursor:default" >已支付</a>
                <a href="" class="btn btn-danger">立即退款</a>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
    {{$orderData->links()}}
@endsection
@section('footer')
    @parent
    <script src="{{URL::asset('/js/order/order.js')}}"></script>
@endsection