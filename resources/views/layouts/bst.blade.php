<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>BootStrap</title>
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

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
                    <li><a href="/goods/allshow">分类1</a></li>
                    <li><a href="/goods/allshow">分类2</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(!Session::has('user_id'))
                        <a class="btn btn-danger">1</a>
                    @else
                        <a class="btn btn-danger">2</a>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
</div>

@section('footer')
    <script src="{{URL::asset('/js/jquery-1.12.4.min.js')}}"></script>
    <script src="{{URL::asset('/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
@show
</body>
</html>