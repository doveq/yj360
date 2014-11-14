@extends('Index.master')
@section('title')重点训练 @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
        我的作业
        <a href="/message?column_id={{$query['column_id']}}" class="tabtool-msg" style="float:right;">消息(<span>{{Session::get('newmassage_count')}}</span>)</a>
      </div>
      <div class="clear"></div>
        <table  class="stable" border="0" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th>序号</th>
              <th>训练名称</th>
              <th>时间</th>
              <th>状态操作</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($lists as $list)
            <tr>
              <td>{{$list->id}}</td>
              <td>{{$list->name}}</td>
              <td>{{$list->created_at}}</td>
              <td>
                <button class="btn_publish" data-id="{{$list->id}}" data-status="{{$list->status}}">做题</button>
              </td>
              <td><a href="/training_result?training_id={{$list->id}}&column_id={{$query['column_id']}}">查看练习情况</a></td>
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


