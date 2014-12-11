@extends('Index.master')
@section('title')个人中心 @stop

@section('content')
<style>
    .table-2 .lable {padding:5px;}
    .tyinput{padding:5px;margin:5px;}
    .tyerr{color:red;padding-left:10px;}
</style>
<div class="container-column wrap">
    <div class="row">
    @include('Index.profile.nav')
  <div class="wrap-right">
      <form role="form" id="fdoup" action="doUp" method="post" enctype="multipart/form-data" >
      <table class="table-2" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th colspan="2">升级音乐教师</th>
        </tr>

        @if(!empty($tinfo))
        <tr>
            <td class="lable">状态</td>
            <td>
                {{$statusEnum[$tinfo->status]}}
            </td>
        </tr>
        @endif

        <tr>
            <td class="lable">毕业学校及专业</td>
            <td>
                <input class="tyinput" type="text" name="professional" value="{{$tinfo->professional or ''}}" />
                <span class="tyerr"></span>
            </td>
        </tr>

        <tr>
            <td class="lable">所在省份</td>
            <td>
                <input class="tyinput" type="text" name="address" value="{{$tinfo->address or ''}}"  />
                <span class="tyerr"></span>
            </td>
        </tr>

        <tr>
            <td class="lable">所在学校</td>
            <td>
                <input class="tyinput" type="text" name="school" value="{{$tinfo->school or ''}}"  />
                <span class="tyerr"></span>
            </td>
        </tr>

        <tr>
            <td class="lable">QQ</td>
            <td>
                <input class="tyinput" type="text" name="qq" value="{{$tinfo->qq or ''}}"  />
                <span class="tyerr"></span>
            </td>
        </tr>

        <tr>
            <td class="lable">教师资格证</td>
            <td>
                <div class="fileup">
                  <input type='text' name='textfield' id='textfield' class='tyinput' style="width:182px;" />
                  <input type='button' class='selbtn' value='' />
                  <input type="file" name="avatar" class="file" id="fileField" size="12" onchange="document.getElementById('textfield').value=this.value" />
                  <span class="tyerr"></span>
                </div>
            </td>
        </tr>

        @if(!empty($tinfo->img))
        <tr>
            <td class="lable"></td>
            <td>
                <img src="{{$tinfo->img}}" width="200" />
            </td>
        </tr>
        @endif

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
$('#fdoup').submit(function(){

    if($('input[name=professional]').val() == '')
    {
        $('input[name=professional]').next('.tyerr').html('该项必须填写');
        return false;
    }
    if($('input[name=address]').val() == '')
    {
        $('input[name=address]').next('.tyerr').html('该项必须填写');
        return false;
    }
    if($('input[name=school]').val() == '')
    {
        $('input[name=school]').next('.tyerr').html('该项必须填写');
        return false;
    }
    if($('input[name=qq]').val() == '')
    {
        $('input[name=qq]').next('.tyerr').html('该项必须填写');
        return false;
    }
    if($('input[name=avatar]').val() == '')
    {
        $('input[name=avatar]').next('.tyerr').html('必须上传教师资格证');
        return false;
    }
    return true;
});
</script>
@stop


