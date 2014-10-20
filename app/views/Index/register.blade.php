@extends('Index.master')
@section('title')注册账号@stop

@section('content')
<div class="container wrap regbox">

    <form id="regform" role="form" action="doRegister" method="post">
      {{Form::token()}}
      <h2 class="form-signin-heading">注册账号</h2>
   
      <table class="regtable">
          
          <tr>
            <td class="lable"><span class="must">*</span>手机号</td>
            <td><input type="text" class="text" name="tel" value="{{Input::old('tel')}}" placeholder="手机号" ></td>
            <td class="reg-err" id="tel-err">{{$errors->first('tel')}}</td>
          </tr>

          <tr>
            <td class="lable">&nbsp;</td>
            <td>
                <a href="javascript:;" id="mcbtn" onclick="mobileCode();" ><img src="/assets/img/regmsg.jpg" /></a>
                <div id="reg-mcjs"></div>
            </td>
            <td class="reg-err"></td>
          </tr>

          <tr>
            <td class="lable"><span class="must">*</span>验证码</td>
            <td><input type="text" class="text" name="code" value="" placeholder="验证码" ></td>
            <td class="reg-err" id="code-err">{{Input::old('codeErr')}}</td>
          </tr>

          <tr>
            <td class="lable"><span class="must">*</span>密  码</td>
            <td><input type="password" class="text" name="password" value="" placeholder="密码" ></td>
            <td class="reg-err" id="password-err">{{$errors->first('password')}}</td>
          </tr>

          <tr>
            <td class="lable"><span class="must">*</span>重复密码</td>
            <td><input type="password" class="text" name="password_confirmation" value="" placeholder="密码" ></td>
            <td class="reg-err"></td>
          </tr>

          <tr>
            <td class="lable"><span class="must">*</span>真实名</td>
            <td><input type="text" class="text" name="name" value="{{Input::old('name')}}" placeholder="真实名" ></td>
            <td class="reg-err" id="name-err">{{$errors->first('name')}}</td>
          </tr>

          <tr>
            <td class="lable">&nbsp;</td>
            <td>
                <input type="checkbox" class="labelinput" name="teacher" value="1" id="checkbox-1" onchange="showTeacher();" /> <label for="checkbox-1">教师资格认证</label>
            </td>
            <td class="reg-err"></td>
          </tr>

          <tr id="reg-jsz" style="display:none;">
            <td class="lable"><span class="must">*</span>教师资格证书</td>
            <td>
                <div class="fileup">
                <input type='text' name='textfield' id='textfield' class='text' style="width:210px;" />
                <input type='button' class='selbtn' value='' />
                <input type="file" name="teacher_img" class="file" id="fileField" size="28" onchange="document.getElementById('textfield').value=this.value" />  
                </div>
            </td>
            <td class="reg-err"></td>
          </tr>

          <tr>
            <td class="lable">&nbsp;</td>
            <td>
              <button type="submit" class="regbnt"></button>
            </td>
            <td class="reg-err"></td>
          </tr>

      </table>

    </form>

</div> <!-- /container -->
@stop

@section('js')
<script>
function showTeacher()
{
    if( $("input[name=teacher]").is(':checked') )
      $("#reg-jsz").show();
    else
      $("#reg-jsz").hide();
}

function mobileCode()
{
    mobile = $("input[name=tel]").val();
    re = /^1\d{10}$/

    if (re.test(mobile))
    {
        $.getJSON("/login/ajax", {'act':'code','mobile':mobile}, function(data){
             if(data.state == 1)
             {
                $('#mcbtn').hide();
                $('#reg-mcjs').show();

                t = 180;
                $('#reg-mcjs').text(t + " 秒后可重新获取短信");
                res  = setInterval(function(){
                    $('#reg-mcjs').text(t + " 秒后可重新获取短信");
                    
                    if(t <= 0)
                    {
                        $('#mcbtn').show();
                        $('#reg-mcjs').hide();
                        clearInterval(res);
                    }

                    t -= 1;
                }, 1000);
             }
             else
             {
                alert("发送验证短信失败，请重试");
             }
        });
    }
    
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
    else if($("input[name=password]").val() !== $("input[name=password_confirmation]").val() )
    {
        $("#password-err").text("二次密码不匹配");
        isok = 0;
    }

    if( $("input[name=name]").val() == '' )
    {
        $("#name-err").text("必须填写真实姓名");
        isok = 0;
    }

    if(isok == 1)
      return true;
    else
      return false;

});
</script>
@stop