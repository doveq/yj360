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
        <a href="/classes?column_id={{$query['column_id']}}" class="tabtool-btn-back">返回></a>
        <span class="tab-title">我的班级</span>
        <span class="tab-btn">
          <a href="/classes/create?column_id={{$query['column_id']}}" class="tabtool-btn">创建班级</a>
          <a href="/classm/add_class?column_id={{$query['column_id']}}" class="tabtool-btn">加入班级</a>
        </span>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        {{ HTML::ul($errors->all()) }}
        {{ Form::open(array('url' => '/classes', 'method' => 'post')) }}
          <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #f1f1f1; width:100%;">
            <tr><td style="background-color:#00a8a8;padding:10px;color:#fff;" colspan="2">创建班级</td></tr>
            <tr>
              <td style="width:20%;text-align:right;">{{ Form::label('inputName', '班级名称', array('class' => 'tylabel')) }}</td>
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


