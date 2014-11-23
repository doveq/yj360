@extends('Index.master')
@section('title')账号登录@stop

@section('content')
    <div class="container wrap">
        <div class="loginbox">
          <form role="form" action="doLogin" method="post">

            <div class="login-con">
                @if($message)
                <div class="alert alert-danger">{{$message}}</div>
                @endif
                <div class="row"><img src="/assets/img/regtit.jpg" /></div>
                <div class="row"><input type="text" class="text" name="name" value="" placeholder="手机号" ></div>
                <div class="row"><input type="password"  class="text" name="password" value="" class="form-control" placeholder="密码"> </div>
                <div class="row">
                    <input type="checkbox" name="" id="checkbox-1" class="labelinput" /> <label for="checkbox-1">记住密码</label>
                    <a href="/forgot" class="forget">忘记密码</a>
                </div>
                <br>
                <div class="row"><button type="submit" class="loginbntn"></button></div>
                <div class="row"><a href="register"><img src="/assets/img/loginbntn2.jpg" /></a></div>
            </div>
          </form>
        </div>
    </div> <!-- /container -->
@stop