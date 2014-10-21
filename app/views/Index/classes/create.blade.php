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
          新建班级 {{ HTML::ul($errors->all()) }}
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        {{ HTML::ul($errors->all()) }}
        {{ Form::open(array('url' => '/classes', 'method' => 'post')) }}
          <table class="stable" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td style="text-align:right;margin:10px;padding:10px;">{{ Form::label('inputName', '班级名称', array('class' => '')) }} </td>
            <td style="text-align:left;margin:10px;padding:10px;">  {{ Form::text('name', '', array('class' => '', 'id' => 'inputName')) }}</td>
          </tr>
          <tr>
            <td style="text-align:left;margin:10px;padding:10px;"></td>
            <td style="text-align:left;margin:10px;padding:10px;">{{ Form::hidden('column_id', $query['column_id'], array('class' => '')) }}
{{ Form::submit('确定', array('class' => '')) }}</td>
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


