<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>BootStrap</title>

    <link rel="stylesheet" href="{{URL::asset('/css/bootstrap.min.css')}}">
</head>
<body>

<div class="container">
    <!-- Static navbar -->
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/users/center">首页</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/goods/allshow">全部商品</a></li>
                    <li><a href="#">分类1</a></li>
                    <li><a href="#">分类2</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(Session::has('user_id'))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">欢迎{{Session::get('name')}}<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/order/detail">我的订单</a></li>
                            <li><a href="/users/cart">我的购物车</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(Session::has('user_id'))
                    <li><a href="/users/loginout">退出</a></li>
                    @else
                    <li><a href="/users/login">登录</a></li>
                    <li><a href="/users/register">注册</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>
    @yield('content')
</div>

@section('footer')
    <script src="{{URL::asset('/js/jquery-1.12.4.min.js')}}"></script>
    <script src="{{URL::asset('/js/bootstrap.min.js')}}"></script>
@show
</body>
</html>