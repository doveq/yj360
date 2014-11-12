@extends('Index.master')
@section('title')忘记密码@stop

@section('content')
<div class="container wrap regbox">

    <form id="regform" role="form" action="#" method="post" enctype="multipart/form-data" >
      {{Form::token()}}
      <h2 class="form-signin-heading">密码找回</h2>
   
      <table class="regtable">
          
          <tr>
            <td class="lable"><span class="must">*</span>手机号</td>
            <td><input type="text" class="text" name="tel" value="{{Input::old('tel')}}" placeholder="手机号" ></td>
            <td class="reg-err" id="tel-err">{{$errors->first('tel')}}</td>
          </tr>

          <tr>
            <td class="lable">&nbsp;</td>
            <td>
              <button type="submit" class="ggbtn">发送密码到手机</button>
            </td>
            <td class="reg-err"></td>
          </tr>

      </table>

    </form>

</div> <!-- /container -->
@stop

@section('js')
<script>

function mobileCode()
{
    mobile = $("input[name=tel]").val();
    re = /^1\d{10}$/

    if (re.test(mobile))
    {
        $.getJSON("/login/ajax", {'act':'forgot','mobile':mobile}, function(data){
             if(data.state == 1)
             {
                  //$("#tel-err").text("新密码发送成功.");
                  alert("新密码发送成功");
             }
             else
             {
                if(data.info)
                  alert(data.info);
                else
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
    else
    {
        mobileCode();
    }
    
    return false;

});
</script>
@stop