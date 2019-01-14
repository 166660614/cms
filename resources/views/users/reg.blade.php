 @extends('layouts.bst')
 @section('content')
 <form class="form-horizontal" action="/dousersregister" method="post">
     {{csrf_field()}}
     <div class="form-group">
         <label for="exampleInputName2" class="col-sm-2 control-label">用户名</label>
         <div class="col-sm-10">
             <input type="text" class="form-control"  placeholder="请输入用户名" style="width:200px" name="u_name">
         </div>
     </div>
     <div class="form-group">
         <label for="inputEmail3" class="col-sm-2 control-label">邮箱</label>
         <div class="col-sm-10">
             <input type="email" class="form-control" placeholder="请输入邮箱"  style="width:200px" name="u_email">
         </div>
     </div>
     <div class="form-group">
         <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
         <div class="col-sm-10">
             <input type="password" class="form-control" placeholder="请输入密码"  style="width:200px" name="u_pwd">
         </div>
     </div>
     <div class="form-group">
         <label class="col-sm-2 control-label">年龄</label>
         <div class="col-sm-10">
             <select class="form-control" style="width:200px" name="u_age">
                 @for($i=16;$i<=60;$i++)
                 <option>{{$i}}</option>
                 @endfor
             </select>
         </div>
     </div>
     <div class="form-group">
         <div class="col-sm-offset-2 col-sm-10">
             <button type="submit" class="btn btn-default">注册</button>
         </div>
     </div>
 </form>
 @endsection