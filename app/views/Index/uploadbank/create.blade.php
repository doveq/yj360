@extends('Index.master')
@section('title')我的班级 @stop

@section('content')
<div class="container-column wrap">
  <div class="wrap-left">
      <div class="sort">
          <div class="sort-tit">全部分类</div>
          <div class="sort-bb"></div>
          <ul class="sort-list">
            @foreach($columns as $k => $column)
            <li><a href="/column?id={{$column->id}}">{{$column->name}}</a><div class="sort-sj"></div></li>
            @endforeach
          </ul>
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj sort-wbj-act"><a href="/classes?column_id={{$query['column_id']}}">我的班级</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item sort-sd"><a href="#">产品商店</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>

      </div>
  </div>

  <div class="wrap-right">
      <div class="tabtool">
        <a href="/uploadbank/create?column_id={{$query['column_id']}}"><img src="/assets/img/uploadbankbtn.png" /></a>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        <div style="margin:10px;">你已经上传了{{$lists->count()}}个题库</div>
        {{ HTML::ul($errors->all()) }}
        {{ Form::open(array('url' => '/uploadbank?column_id='.$query['column_id'], 'method' => 'post', 'files' => true)) }}
          <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #f1f1f1; width:100%;">
            <tr><td style="background-color:#00bbac;padding:10px; color:#ffffff" colspan="2">上传题库</td></tr>
            <tr>
              <td style="width:20%;text-align:right;">{{ Form::label('inputName', '题库名称', array('class' => 'tylabel')) }}</td>
              <td>{{ Form::text('name', '', array('class' => 'tyinput', 'id' => 'inputName', 'style' => 'width:200px'))}}</td>
            </tr>
            <tr>
              <td style="width:20%;text-align:right;">{{ Form::label('inputDesc', '题库描述', array('class' => 'tylabel')) }}</td>
              <td>{{ Form::textarea('desc', '', array('class' => 'tyinput', 'id' => 'inputDesc', 'rows' => '3','style' => 'width:200px'))}}</td>
            </tr>
            <tr>
              <td style="width:20%;text-align:right;">{{ Form::label('inputFile', '选择文件', array('class' => 'tylabel')) }}</td>
              <td>
                {{ Form::file('filename', array('id' => 'inputFile', 'style' => 'margin:10px;padding:10px')) }}
                <div style="color:gray;font-size:12px;margin-left:10px;padding-left:10px">请选择你需要提交的图库压缩包,zip或rar格式</div>
              </td>
            </tr>
            <tr>
              <td style="width:20%;text-align:right;">{{ Form::label('inputTel', '联系电话', array('class' => 'tylabel')) }}</td>
              <td>{{ Form::text('tel', Session::get('utel'), array('class' => 'tyinput', 'id' => 'inputTel', 'style' => 'width:200px'))}}</td>
            </tr>
            <tr>
              <td style="width:20%;text-align:right;">{{ Form::label('inputQq', '联系QQ', array('class' => 'tylabel')) }}</td>
              <td>{{ Form::text('qq', '', array('class' => 'tyinput', 'id' => 'inputQq', 'style' => 'width:200px'))}}</td>
            </tr>
            <tr>
              <td></td>
              <td>
                {{ Form::hidden('column_id', $query['column_id']) }}
                {{ Form::submit('', array('class' => 'submitbtn')) }}
              </td>
            </tr>
          </table>
        {{ Form::close() }}
        <div class="clear"></div>
      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
</script>
@stop


