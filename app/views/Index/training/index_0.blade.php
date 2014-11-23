@extends('Index.master')
@section('title')重点训练 @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
        <span class="tab-bar"></span>
        <span class="tab-title">我的作业</span>
      </div>
      <div class="clear"></div>
        <table  class="stable" border="0" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th>班级</th>
              <th>作业</th>
              <th>时间</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($lists as $list)
            <tr>
              <td>{{$list->classes->name}}</td>
              <td>{{$list->name}}</td>
              <td>{{str_limit($list->created_at,10,'')}}</td>
              <td><a href="#" target="_blank">做题</a>  <a href="/training_result?training_id={{$list->id}}&column_id={{$query['column_id']}}">查看练习情况</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>

  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript" src="/assets/layer/layer.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {

});
</script>
@stop


