@extends('Index.master')
@section('title')个人中心 @stop

@section('content')
<div class="container-column wrap">
  @include('Index.profile.nav')

  <div class="wrap-right">
      <form role="form" action="doProfile" method="post" enctype="multipart/form-data" >
      <table class="table-2" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th colspan="2">个人资料</th>
        </tr>

        <tr>
            <td class="lable">手机号</td>
            <td>
                <input class="tyinput" type="text" name="tel" value="{{$tel}}" disabled />
            </td>
        </tr>

        <tr>
            <td class="lable">姓名</td>
            <td>
                <input class="tyinput" type="text" name="name" value="{{$name}}" />
            </td>
        </tr>

        <tr>
            <td class="lable">认证信息</td>
            <td>
                <input class="tyinput" type="text"  name="name" value="{{$type_str}}" disabled />
            </td>
        </tr>

        <tr>
            <td class="lable">所在学校</td>
            <td>
                <input class="tyinput" type="text" name="company" value="{{$company or ''}}"  />
            </td>
        </tr>

        <tr>
            <td class="lable">QQ</td>
            <td>
                <input class="tyinput" type="text" name="qq" value="{{$qq or ''}}"  />
            </td>
        </tr>

        <tr>
            <td class="lable">邮箱</td>
            <td>
                <input class="tyinput" type="text" name="email" value="{{$email or ''}}"  />
            </td>
        </tr>

        <tr>
            <td class="lable">跟换头像</td>
            <td>
                <div class="fileup">
                  <input type='text' name='textfield' id='textfield' class='tyinput' style="width:180px;" />
                  <input type='button' class='selbtn' value='' />
                  <input type="file" name="avatar" class="file" id="fileField" size="28" onchange="document.getElementById('textfield').value=this.value" />  
                </div>
            </td>
        </tr>

        <tr>
            <td class="lable">简介</td>
            <td>
                <textarea class="tyinput" name="intro">{{$intro or ''}}</textarea>
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
});
</script>
@stop


