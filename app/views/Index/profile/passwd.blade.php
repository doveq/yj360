@extends('Index.master')
@section('title')个人中心 @stop

@section('content')
<div class="container-column wrap">
  @include('Index.profile.nav')

  <div class="wrap-right">
      <form role="form" action="doPasswd" method="post" id="form" >
      <table class="table-2" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th colspan="2">密码管理</th>
        </tr>

        <tr>
            <td class="lable">原始新密码</td>
            <td>
                <input class="tyinput" type="password" name="password" value=""  />
            </td>
        </tr>

        <tr>
            <td class="lable">设置新密码</td>
            <td>
                <input class="tyinput" type="password" name="new_password" value=""  />
            </td>
        </tr>

        <tr>
            <td class="lable">重复密码</td>
            <td>
                <input class="tyinput" type="password" name="password_confirmation" value=""  />
            </td>
        </tr>
        

        <tr>
            <td class="lable">&nbsp;</td>
            <td>
                <button type="submit" class="pfbnt"></button>
            </td>
        </tr>
      </table>
      </form>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function () {
    $("#form").submit(function(){
        if($("input[name=password]").val() == "")
        {
            alert("原始密码必须填写");
            return false;
        }

        if($("input[name=new_password]").val() == "")
        {
            alert("新密码必须填写");
            return false;
        }

        if($("input[name=new_password]").val().length < 6)
        {
            alert("新密码不能小于6位");
            return false;
        }

        if($("input[name=new_password]").val() !== $("input[name=password_confirmation]").val())
        {
            alert("重复密码错误");
            return false;
        }

        return true;
    });
});
</script>
@stop


