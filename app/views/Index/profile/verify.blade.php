@extends('Index.master')
@section('title')个人中心 @stop

@section('content')
<style>
    .table-2 .lable {padding:5px;}
    .tyinput{padding:5px;margin:5px;}
    .vtit{
        text-align: center;
        padding:10px;
        border-bottom: 1px solid #ddd;
    }
    .vtit h2{color:#377BED;font-size:26px;padding:10px;}
    .vtit p{color:red;}
    .regtable{
        padding-left:50px;
    }
</style>
<div class="container-column wrap">
    <div class="row">
    @include('Index.profile.nav')
  <div class="wrap-right">

      <div class="vtit">
          <h2>欢迎登陆音基360</h2>
          <p>温馨提示：您的账号处于未验证状态，15天后将无法使用，请尽快验证！</p>
      </div>

    <form id="regform" role="form" action="/profile/doVerify" method="post" >
      {{Form::token()}}
   
      <table class="regtable">
          
          <tr>
            <td class="lable" style="padding-right:15px;"><span class="must">*</span>手机号</td>
            <td colspan="2">
                {{$uinfo['tel']}}<span style="color:red;padding-left:20px;">请确保此号码手机在身边</span>
                <input type="hidden" class="text" name="tel" value="{{$uinfo['tel']}}" />
            </td>
            <td class="reg-err" id="tel-err"></td>
          </tr>

          <tr>
            <td class="lable" style="padding-right:15px;"><span class="must">*</span>验证码</td>
            <td><input type="text" class="text" name="code" value="" placeholder="验证码" style="width:150px;padding:5px;" ></td>
            <td>
                <button id="mcbtn" class="mcbtn-1" onclick="return mobileCode();" autocomplete="off" >点击免费获取验证码</button>
                <div id="reg-mcjs"></div>
            </td>
            <td class="reg-err" id="code-err">{{Input::old('codeErr')}}</td>
          </tr>
          <tr id="codebox" style="display:none;">
            <td class="lable" style="padding-right:15px;"><span class="must">&nbsp;</td>
            <td colspan="2" id="codeerr" class="reg-err"></td>
            <td class="reg-err" ></td>
          </tr>

          <tr>
            <td class="lable" style="padding-right:15px;"><span class="must">*</span>系统默认密码</td>
            <td colspan="2">123456</td>
            <td></td>
          </tr>

          <tr>
            <td class="lable" style="padding-right:15px;"><span class="must">*</span>新密码</td>
            <td colspan="2"><input type="password" class="text" name="password" value="" placeholder="密码"  style="padding:5px;"></td>
            <td class="reg-err" id="password-err">{{$errors->first('password')}}</td>
          </tr>

          <tr>
            <td class="lable" style="padding-right:15px;"><span class="must">*</span>重复新密码</td>
            <td colspan="2"><input type="password" class="text" name="password_confirmation" value="" placeholder="密码"  style="padding:5px;"></td>
            <td class="reg-err"></td>
          </tr>

          <tr>
            <td class="lable">&nbsp;</td>
            <td>
              <button type="submit" class="ggbtn">立即验证 并 重置密码</button>
            </td>
            <td class="reg-err"></td>
          </tr>

      </table>

    </form>

  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>
@stop

@section('js')
<script>

function mobileCode()
{
    $('#tel-err').text("");
    mobile = $("input[name=tel]").val();
    re = /^1\d{10}$/
    
    if (re.test(mobile))
    {
        $("#mcbtn").attr('disabled',"true");
        $("#mcbtn").text('重新获取');
        $("#mcbtn").removeClass('mcbtn-1').addClass('mcbtn-2');

        $.getJSON("/login/ajax", {'act':'code','mobile':mobile}, function(data){

            $('#codebox').show();
             if(data.state == 1)
             {
                t = 120;
                $('#codeerr').text(t + " 秒后可重新获取短信");
                res  = setInterval(function(){
                    $('#codeerr').text(t + " 秒后可重新获取短信");
                    
                    if(t <= 0)
                    {
                        $('#codebox').hide();
                        $('#mcbtn').removeAttr("disabled");
                        $("#mcbtn").removeClass('mcbtn-2').addClass('mcbtn-1');
                        clearInterval(res);
                    }

                    t -= 1;
                }, 1000);
             }
             else
             {
                $('#mcbtn').removeattr("disabled");
                $("#mcbtn").removeClass('mcbtn-2').addClass('mcbtn-1');

                $('#codeerr').text("发送验证短信失败，请重试");
                //alert("发送验证短信失败，请重试");
             }
        });
    }
    else
    {
        $('#tel-err').text("手机号错误");
    }
    
    return false;
}

$("#regform").submit(function(){
    isok = 1;

    $(".reg-err").text("");

    mobile = $("input[name=tel]").val();
    re = /^1\d{10}$/

    if( !re.test(mobile) )
    {
        $("#tel-err").text("手机号错误");
        isok = 0;
    }

    if( $("input[name=code]").val() == '' )
    {
        $("#code-err").text("必须填写验证码");
        isok = 0;
    }

    if( $("input[name=password]").val() == '' )
    {
        $("#password-err").text("必须填写密码");
        isok = 0;
    }

    if($("input[name=password]").val() !== $("input[name=password_confirmation]").val() )
    {
        $("#password-err").text("二次密码不匹配");
        isok = 0;
    }
    

    if(isok == 1)
      return true;
    else
      return false;

});
</script>
@stop
