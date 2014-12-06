@extends('Admin.master')

@section('css')
<style>
	body {
	  padding-top: 40px;
	  padding-bottom: 40px;
	  background-color: #eee;
	}

	.form-signin {
	  max-width: 330px;
	  padding: 15px;
	  margin: 0 auto;
	}
	.form-signin .form-signin-heading,
	.form-signin .checkbox {
	  margin-bottom: 10px;
	}
	.form-signin .checkbox {
	  font-weight: normal;
	}
	.form-signin .form-control {
	  position: relative;
	  height: auto;
	  -webkit-box-sizing: border-box;
	     -moz-box-sizing: border-box;
	          box-sizing: border-box;
	  padding: 10px;
	  font-size: 16px;
	}
	.form-signin .form-control:focus {
	  z-index: 2;
	}
	.form-signin input[type="email"] {
	  margin-bottom: -1px;
	  border-bottom-right-radius: 0;
	  border-bottom-left-radius: 0;
	}
	.form-signin input[type="password"] {
	  margin-bottom: 10px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}
</style>
@stop

@section('nav')
@stop

@section('content')
    <div class="container">

      <form class="form-signin" role="form" action="doLogin" method="post">
        <h2 class="form-signin-heading">音基360</h2>
        @if($message)
        <div class="alert alert-danger" role="alert">{{$message}}</div>
        @endif

        <div class="form-inline">
        	<div class="form-group">
        		<input type="text" name="tel" class="form-control" placeholder="手机号" required autofocus>
        	</div>
        	<button id="mcbtn" class="btn btn-primary" type="button" onclick="mobileCode()">发送密码</button>
        </div>
        
        <div class="form-group">
        	<div id="codeerr" class="text-warning"></div>
        </div>

        <div class="form-group">
        	<input type="password" name ="password" class="form-control" placeholder="验证码" required>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
      </form>

    </div> <!-- /container -->

@stop


@section('js')
<script>
function mobileCode()
{
    $('#codeerr').text("");
    mobile = $("input[name=tel]").val();
    re = /^1\d{10}$/
    
    if (re.test(mobile))
    {
        $("#mcbtn").attr('disabled',"true");
        $("#mcbtn").text('重新获取');

        $.getJSON("/login/ajax", {'act':'admincode','mobile':mobile}, function(data){

             if(data.state == 1)
             {
                t = 120;
                $('#codeerr').text(t + " 秒后可重新获取短信");
                res = setInterval(function(){
                    $('#codeerr').text(t + " 秒后可重新获取短信");
                    if(t <= 0)
                    {
                        $('#mcbtn').removeAttr("disabled");
                        $('#codeerr').text("");
                        clearInterval(res);
                    }

                    t -= 1;
                }, 1000);
             }
             else if(data.state == -70)
             {
             	$('#mcbtn').removeAttr("disabled");
                $('#codeerr').text("该手机号不允许登录");
             }
             else
             {
                $('#mcbtn').removeAttr("disabled");
                $('#codeerr').text("发送验证短信失败，请重试");
                //alert("发送验证短信失败，请重试");
             }
        });
    }
    else
    {
        $('#codeerr').text("手机号错误");
    }
    
    return false;
}
</script>
@stop