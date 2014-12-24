@extends('Index.master')
@section('title')我的班级 @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
    <div class="row">
  @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
        <span class="tab-bar"></span>
        <span class="tab-title-prev">
            <a href="/classes?column_id={{$query['column_id']}}" class="tabtool-btn-back">我的班级</a>
            <span>&nbsp;>&nbsp;</span>
        </span>
        <span class="tab-title">创建班级</span>
        <span class="tab-btn">
          <a href="/classes/create?column_id={{$query['column_id']}}" class="tabtool-btn">创建班级</a>
          <a href="/classm/add_class?column_id={{$query['column_id']}}" class="tabtool-btn">加入班级</a>
        </span>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        {{ HTML::ul($errors->all()) }}
        {{ Form::open(array('url' => '/classes', 'method' => 'post')) }}
          <input type="hidden" name="tag" value="@if(!empty($query['tag'])){{$query['tag']}}@endif">
          <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #f1f1f1; width:100%;">
            <tr><td style="padding:10px;color:#ccc;text-align:center;" colspan="2">
创建的班级，最多可加入60位学生，解散班级需要先移除班级内成员。
</td></tr>
            <tr>
              <td style="width:40%;text-align:right;">{{ Form::label('inputName', '班级名称', array('class' => 'tylabel')) }}</td>
              <td>{{ Form::text('name', '', array('class' => 'tyinput', 'id' => 'inputName','style' => 'width:200px'))}}(最多50个字)</td>
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


