@extends('Index.master')
@section('title')个人中心 @stop

@section('headjs')
<script src="/assets/js/PCASClass.js"></script>
@stop

@section('content')
<style>
    .table-2 .lable {padding:5px;}
    .tyinput{padding:5px;margin:5px;}
    .tyerr{color:red;padding-left:10px;}
    .fileup{position:relative;}
    .table-2 .selbtn{
        background: none no-repeat 0 0 #1db5a9;
        border:none;
        width:100px;
        padding:10px 0;
        position:relative;
        height: auto;

    }
    .table-2 .file{ 
        position:absolute; top:0; left:5px; height:40px; filter:alpha(opacity:0);opacity: 0;width:380px;
        cursor: pointer;
    }
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
            <td style="padding-left:5px;">
                {{$statusEnum[$tinfo->status]}}
            </td>
        </tr>
        @endif

        <tr>
            <td class="lable" style="vertical-align:top;padding-top:12px;">教师资格证</td>
            <td>
                <div class="fileup">
                  <input type='text' name='textfield' id='textfield' class='tyinput' style="width:237px;" />
                  <button type="submit" class='selbtn' style="margin-left:5px;padding:5px 10px;border:none;color:#fff;">选择文件</button>
                  <input type="file" name="avatar" class="file" id="fileField" size="12" onchange="document.getElementById('textfield').value=this.value" />
                  <span class="tyerr"></span>
                </div>
                <div style="color:#8a8a86;padding-left:5px;">校外音乐培训老师，也可使用毕业证书</div>
            </td>
        </tr>

        <tr>
            <td class="lable">地区</td>
            <td>
              <select name="province" class="tyinput"></select>
              <select name="city" class="tyinput"></select>
              <select name="district" class="tyinput"></select>
              <span class="tyerr"></span>
            </td>
        </tr>

        <tr>
            <td class="lable">详细地址</td>
            <td>
                <input class="tyinput" style="width:350px;" type="text" name="address" value="{{$tinfo->address or ''}}"  />
                <span class="tyerr"></span>
            </td>
        </tr>


        <tr>
            <td class="lable">毕业学校及专业</td>
            <td>
                <input class="tyinput" style="width:350px;" type="text" name="professional" value="{{$tinfo->professional or ''}}" />
                <span class="tyerr"></span>
            </td>
        </tr>

        <tr>
            <td class="lable">所在学校</td>
            <td>
                <input class="tyinput" style="width:350px;" type="text" name="school" value="{{$tinfo->school or ''}}"  />
                <span class="tyerr"></span>
            </td>
        </tr>

        <tr>
            <td class="lable">QQ</td>
            <td>
                <input class="tyinput" style="width:350px;" type="text" name="qq" value="{{$tinfo->qq or ''}}"  />
                <span class="tyerr"></span>
            </td>
        </tr>

        
        @if(!empty($uinfo->img))
        <tr>
            <td class="lable"></td>
            <td>
                <img src="{{$uinfo['img']}}" width="200" />
            </td>
        </tr>
        @endif

        <tr>
            <td class="lable">&nbsp;</td>
            <td>
                <button type="submit" style="margin-left:5px;background-color:#1db5a9;padding:5px 10px;border:none;color:#fff;">提交</button>
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

new PCAS("province={{$tinfo->province or ''}},选择省份","city={{$tinfo->city or ''}},选择城市","district={{$tinfo->district or ''}},选择地区");

$('#fdoup').submit(function(){

    $('.tyerr').html('');

    if($('input[name=avatar]').val() == '')
    {
        $('input[name=avatar]').next('.tyerr').html('必须上传教师资格证');
        return false;
    }

    if($('select[name=district]').val() == '')
    {
        $('select[name=district]').next('.tyerr').html('该项必须选择');
        return false;
    }

    if($('input[name=address]').val() == '')
    {
        $('input[name=address]').next('.tyerr').html('该项必须填写');
        return false;
    }

    if($('input[name=professional]').val() == '')
    {
        $('input[name=professional]').next('.tyerr').html('该项必须填写');
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
    
    return true;
});
</script>
@stop


@stop