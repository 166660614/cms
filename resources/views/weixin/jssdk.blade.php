@extends('layouts.bst')
@section('content')
    <div class="container">
        <h1>jssdk</h1>
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{URL::asset('http://res2.wx.qq.com/open/js/jweixin-1.4.0.js')}}"></script>
    <script>
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId:"{{$appid}}", // 必填，公众号的唯一标识
            timestamp:"{{$timestamp}}" , // 必填，生成签名的时间戳
            nonceStr:"{{$nocestr}}", // 必填，生成签名的随机串
            signature: "{{$sign}}",// 必填，签名
            jsApiList: ['updateAppMessageShareData','chooseImage'] // 必填，需要使用的JS接口列表
        });
    </script>
@endsection