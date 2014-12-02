@extends('Index.master')
@section('title')个人中心 @stop

@section('content')
<style>
    .table-2 .lable {padding:5px;}
    .tyinput{padding:5px;margin:5px;}
</style>
<div class="container-column wrap">
    <div class="row">
    @include('Index.profile.nav')
  <div class="wrap-right">
      <form role="form" action="doUp" method="post" enctype="multipart/form-data" >
      <table class="table-2" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th colspan="2">升级音乐教师</th>
        </tr>

        <tr>
            <td class="lable">毕业学校及专业</td>
            <td>
                <input class="tyinput" type="text"  name="professional" value="" />
            </td>
        </tr>

        <tr>
            <td class="lable">所在省份</td>
            <td>
                <input class="tyinput" type="text" name="address" value=""  />
            </td>
        </tr>

        <tr>
            <td class="lable">所在学校</td>
            <td>
                <input class="tyinput" type="text" name="school" value=""  />
            </td>
        </tr>

        <tr>
            <td class="lable">QQ</td>
            <td>
                <input class="tyinput" type="text" name="qq" value="{{$qq or ''}}"  />
            </td>
        </tr>

        <tr>
            <td class="lable">教师资格证</td>
            <td>
                <div class="fileup">
                  <input type='text' name='textfield' id='textfield' class='tyinput' style="width:182px;" />
                  <input type='button' class='selbtn' value='' />
                  <input type="file" name="avatar" class="file" id="fileField" size="28" onchange="document.getElementById('textfield').value=this.value" />
                </div>
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
</div>
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function () {
});
</script>
@stop


