@extends('Index.master')
@section('title')账号登录@stop

@section('content')
    <div class="container">

      <form class="form-signin" role="form" action="doLogin" method="post">
        @if($message)
        <div class="alert alert-danger" role="alert">{{$message}}</div>
        @endif
        <h2 class="form-signin-heading">账号登录</h2>
        <p><input type="text" name="name" value="" placeholder="用户名" ></p>
        <p><input type="password" name="password" value="" class="form-control" placeholder="密码" ></p>
        
        <button type="submit">登录</button>
      </form>

    </div> <!-- /container -->
@stop