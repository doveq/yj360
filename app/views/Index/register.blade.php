@extends('Index.master')
@section('title')注册账号@stop

@section('content')
    <div class="container">

      <form class="form-signin" role="form" action="doRegister" method="post">
        {{Form::token()}}
        <h2 class="form-signin-heading">注册账号</h2>
        @foreach($errors->all() as $message)
            <p>{{ $message }}</p>
        @endforeach
        <p><input type="text" name="tel" value="" placeholder="手机号" ></p>
        <p><input type="text" name="verify" value="" placeholder="验证码" ></p>
        <p><input type="password" name="password" value="" class="form-control" placeholder="密码" ></p>
        <p><input type="password" name="password_confirmation" value="" class="form-control" placeholder="重复密码" ></p>
        
        <button type="submit">注册</button>
      </form>

    </div> <!-- /container -->
@stop