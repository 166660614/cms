@extends('layouts.bst')
@section('content')
    <div class="container">
        @if(Session::has('user_id'))
        <h1 style="color: red">用户中心</h1>
        @else
         <h1 style="color: red">游客中心</h1>
        @endif
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{URL::asset('/js/goods/goods.js')}}"></script>
@endsection