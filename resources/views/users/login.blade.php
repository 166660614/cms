@extends('layouts.bst')
@section('content')
<form class="form-horizontal" action="/douserslogin" method="post">
    {{csrf_field()}}
    <div class="form-group">
        <label for="exampleInputName2" class="col-sm-2 control-label">用户名</label>
        <div class="col-sm-10">
            <input type="text" class="form-control"  placeholder="请输入用户名" style="width:200px" name="u_name">
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" placeholder="请输入密码"  style="width:200px" name="u_pwd">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">登录</button>
            <a class="btn btn-info" href="https://open.weixin.qq.com/connect/qrconnect?appid=wxe24f70961302b5a5&amp;redirect_uri=http%3a%2f%2fmall.77sc.com.cn%2fweixin.php%3fr1%3dhttp%3a%2f%2fwww.52self.cn%2fweixin%2flogin&amp;response_type=code&amp;scope=snsapi_login&amp;state=STATE#wechat_redirect">微信登录</a>
        </div>
    </div>
</form>
@endsection