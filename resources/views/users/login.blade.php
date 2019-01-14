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
            <button type="submit" class="btn btn-default">登录</button>
        </div>
    </div>
</form>
@endsection