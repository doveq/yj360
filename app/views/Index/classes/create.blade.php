@extends('Index.master')
@section('title')我的班级 @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
    <div class="row">
  @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
          <a href="/classes/create?column_id={{$query['column_id']}}"><img src="/assets/img/addclasses.jpg" /></a>
          <a href="/message" class="tabtool-msg">消息(<span>{{Session::get('newmassage_count')}}</span>)</a>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        <div style="padding:10px;">你已加入{{$classes_num}}个班级, 安排了{{$trainings_num}}个重点训练</div>
        {{ HTML::ul($errors->all()) }}
        {{ Form::open(array('url' => '/classes', 'method' => 'post')) }}
          <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #f1f1f1; width:100%;">
            <tr><td style="background-color:#00bbac;padding:10px;" colspan="2">创建班级</td></tr>
            <tr>
              <td style="width:20%;text-align:right;">{{ Form::label('inputName', '班级名称', array('class' => 'tylabel')) }}</td>
              <td>{{ Form::text('name', '', array('class' => 'tyinput', 'id' => 'inputName','style' => 'width:200px'))}}</td>
            </tr>
            <tr>
              <td></td>
              <td>
                @if ($query['column_id'])
                {{ Form::hidden('column_id', $query['column_id'], array('class' => '')) }}
                @endif
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
</div>
@stop

@section('js')

@stop


