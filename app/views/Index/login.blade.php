@extends('Index.master')
@section('title')账号登录@stop

@section('headjs')
<script src="/assets/layer/layer.min.js"></script>
@stop


@section('content')
    <div class="container wrap">
        <div class="loginbox">
          <form role="form" id="dologin" action="doLogin" method="post">

            <div class="login-con">
                @if($message)
                <div class="alert alert-danger">{{$message}}</div>
                @endif
                <div class="row"><img src="/assets/img/regtit.jpg" /></div>
                <div class="row"><input type="text" class="text" id="login-input-name" name="name" value="" placeholder="手机号" ></div>
                <div class="row"><input type="password" id="login-input-passwd" class="text" name="password" value="" class="form-control" placeholder="密码"> </div>
                <div class="row">
                    <input type="checkbox" name="remember" id="checkbox-1" class="labelinput" /> <label for="checkbox-1">记住密码</label>
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


@section('js')
<script>
$("#dologin").submit(function(){
    isok = 1;

    $(".reg-err").text("");

    mobile = $("#login-input-name").val();
    re = /^1\d{10}$/

    if( !re.test(mobile) )
    {
        $("#tel-err").text("");

        layer.tips('填写手机号登录', $('#login-input-name'), {
            time: 5,
            style: ['background-color:#F26C4F; color:#fff', '#F26C4F'],
            maxWidth:240
        });

        isok = 0;
    }

    if( $("#login-input-passwd").val() == '' )
    {
        layer.tips('必须填写密码', $('#login-input-passwd'), {
            time: 5,
            guide: 2,
            style: ['background-color:#F26C4F; color:#fff', '#F26C4F'],
            maxWidth:240
        });

        isok = 0;
    }

    if(isok == 1)
      return true;
    else
      return false;

});
</script>
@stop
